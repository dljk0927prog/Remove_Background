<?php
/**
 * Download the processed PNG.
 */
declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

$token = preg_replace('/[^a-f0-9]/', '', (string) ($_GET['token'] ?? ''));

if ($token === '') {
    http_response_code(400);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Invalid request.';
    exit;
}

$path = OUTPUT_DIR . DIRECTORY_SEPARATOR . $token . DIRECTORY_SEPARATOR . 'result.png';
if (!is_file($path)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'File not found.';
    exit;
}

$filename = 'no-bg-' . substr($token, 0, 8) . '.png';
header('Content-Type: image/png');
header('Content-Length: ' . (string) filesize($path));
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, no-store');
readfile($path);
exit;
