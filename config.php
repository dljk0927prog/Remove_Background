<?php
/**
 * Application configuration
 */
declare(strict_types=1);

define('APP_ROOT', __DIR__);
define('UPLOAD_DIR', APP_ROOT . DIRECTORY_SEPARATOR . 'uploads');
define('OUTPUT_DIR', APP_ROOT . DIRECTORY_SEPARATOR . 'outputs');
define('MAX_FILE_SIZE', 8 * 1024 * 1024); // 8 MB
define('ALLOWED_MIME', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
define('ALLOWED_EXT', ['jpg', 'jpeg', 'png', 'webp', 'gif']);
define('SESSION_TTL', 3600); // 1 hour

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

foreach ([UPLOAD_DIR, OUTPUT_DIR] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}
