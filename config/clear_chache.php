<?php
$possible_cache_dirs = [
    __DIR__ . '/cache/',
    __DIR__ . '/tmp/',
    __DIR__ . '/storage/cache/',
    __DIR__ . '/var/cache/',
    sys_get_temp_dir() . '/cache/'
];

$cache_cleared = false;

foreach ($possible_cache_dirs as $cache_dir) {
    if (is_dir($cache_dir)) {
        $files = glob($cache_dir . '*'); // Get all files in the cache directory

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Delete the file
            }
        }
        $cache_cleared = true;
        echo json_encode(['message' => 'Cache cleared successfully from ' . $cache_dir]);
        break;
    }
}

if (!$cache_cleared) {
    http_response_code(404);
    echo json_encode(['error' => 'Cache directory not found.']);
}
?>
