<?php
/**
 * Upload image and remove background (single AI result).
 */
declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

function json_fail(string $message, int $code = 400): void
{
    http_response_code($code);
    echo json_encode(['ok' => false, 'error' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_fail('Method not allowed', 405);
}

if (!isset($_FILES['image']) || !is_array($_FILES['image'])) {
    json_fail('No image uploaded.');
}

$file = $_FILES['image'];
if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    json_fail('Upload failed. Please try again.');
}

if (($file['size'] ?? 0) <= 0 || $file['size'] > MAX_FILE_SIZE) {
    json_fail('File too large. Max size is 8 MB.');
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']) ?: '';
if (!in_array($mime, ALLOWED_MIME, true)) {
    json_fail('Unsupported file type. Use JPG, PNG, WEBP or GIF.');
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, ALLOWED_EXT, true)) {
    $ext = match ($mime) {
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        default      => 'png',
    };
}

$info = @getimagesize($file['tmp_name']);
if ($info === false) {
    json_fail('Invalid image file.');
}

$maxDim = 1400;
$w = (int) $info[0];
$h = (int) $info[1];
if ($w < 16 || $h < 16) {
    json_fail('Image is too small.');
}
if ($w > 6000 || $h > 6000) {
    json_fail('Image dimensions are too large.');
}

$token = bin2hex(random_bytes(16));
$jobDir = OUTPUT_DIR . DIRECTORY_SEPARATOR . $token;
if (!mkdir($jobDir, 0755, true) && !is_dir($jobDir)) {
    json_fail('Server storage error.', 500);
}

$originalPath = $jobDir . DIRECTORY_SEPARATOR . 'original.' . $ext;
if (!move_uploaded_file($file['tmp_name'], $originalPath)) {
    json_fail('Failed to save upload.', 500);
}

$workPath = $originalPath;
$needResize = $w > $maxDim || $h > $maxDim;
if ($needResize) {
    $scale = min($maxDim / $w, $maxDim / $h);
    $nw = max(1, (int) round($w * $scale));
    $nh = max(1, (int) round($h * $scale));
    $src = match ($info[2]) {
        IMAGETYPE_JPEG => @imagecreatefromjpeg($originalPath),
        IMAGETYPE_PNG  => @imagecreatefrompng($originalPath),
        IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($originalPath) : false,
        IMAGETYPE_GIF  => @imagecreatefromgif($originalPath),
        default        => false,
    };
    if ($src !== false) {
        $dst = imagecreatetruecolor($nw, $nh);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
        imagefilledrectangle($dst, 0, 0, $nw, $nh, $transparent);
        imagealphablending($dst, true);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagedestroy($src);
        $workPath = $jobDir . DIRECTORY_SEPARATOR . 'work.png';
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        imagepng($dst, $workPath, 6);
        imagedestroy($dst);
    }
}

try {
    @set_time_limit(300);
    process_with_ai($workPath, $jobDir);

    $dest = $jobDir . DIRECTORY_SEPARATOR . 'result.png';
    if (!is_file($dest)) {
        throw new RuntimeException('Missing result.png');
    }
} catch (Throwable $e) {
    json_fail('Processing failed: ' . $e->getMessage(), 500);
}

function process_with_ai(string $workPath, string $jobDir): void
{
    $scene = strtolower(trim((string) ($_POST['scene'] ?? 'anime')));
    if (!in_array($scene, ['anime', 'general', 'portrait'], true)) {
        $scene = 'anime';
    }

    $script = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'remove_bg.py';
    if (!is_file($script)) {
        throw new RuntimeException('AI script missing (includes/remove_bg.py).');
    }

    $python = find_python();
    if ($python === null) {
        throw new RuntimeException(
            'AI engine not available. Please install: pip install "rembg[cpu]"'
        );
    }

    $cmd = escapeshellarg($python) . ' ' . escapeshellarg($script) . ' '
        . escapeshellarg($workPath) . ' ' . escapeshellarg($jobDir) . ' '
        . escapeshellarg($scene) . ' 2>&1';
    $output = [];
    $code = 0;
    exec($cmd, $output, $code);
    $text = trim(implode("\n", $output));

    if ($code !== 0) {
        $detail = $text !== '' ? $text : 'unknown error';
        $json = json_decode($text, true);
        if (is_array($json) && !empty($json['error'])) {
            $detail = (string) $json['error'];
        }
        throw new RuntimeException('AI processing failed: ' . $detail);
    }

    if (!is_file($jobDir . DIRECTORY_SEPARATOR . 'result.png')) {
        throw new RuntimeException('AI did not produce result.png. ' . $text);
    }
}

function find_python(): ?string
{
    static $cached = false;
    static $bin = null;
    if ($cached) {
        return $bin;
    }
    $cached = true;

    $candidates = [];
    $where = [];
    exec('where python 2>&1', $where);
    foreach ($where as $line) {
        $line = trim($line);
        if ($line !== '' && is_file($line)) {
            $candidates[] = $line;
        }
    }
    $candidates[] = 'python';
    $candidates[] = 'python3';

    foreach (array_unique($candidates) as $candidate) {
        $check = escapeshellarg($candidate) . ' -c "from rembg import remove; print(1)" 2>&1';
        $out = [];
        $code = 0;
        exec($check, $out, $code);
        if ($code === 0 && isset($out[0]) && trim($out[0]) === '1') {
            $bin = $candidate;
            return $bin;
        }
    }
    return null;
}

$_SESSION['jobs'][$token] = [
    'created' => time(),
    'dir'     => $jobDir,
];

if (!empty($_SESSION['jobs']) && is_array($_SESSION['jobs'])) {
    foreach ($_SESSION['jobs'] as $t => $job) {
        if (!is_array($job) || (time() - (int) ($job['created'] ?? 0)) > SESSION_TTL) {
            unset($_SESSION['jobs'][$t]);
        }
    }
}

echo json_encode([
    'ok'       => true,
    'token'    => $token,
    'original' => 'outputs/' . rawurlencode($token) . '/original.' . $ext,
    'result'   => [
        'url'      => 'outputs/' . rawurlencode($token) . '/result.png',
        'download' => 'api/download.php?token=' . urlencode($token),
    ],
], JSON_UNESCAPED_UNICODE);
