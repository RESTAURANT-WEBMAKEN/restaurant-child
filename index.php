<?php

// Include the public index.php file to process on the Nginx server
$indexPath = __DIR__ . '/public/index.php';

if (file_exists($indexPath)) {
    require $indexPath;
} else {
    // Handle the error if the file does not exist
    http_response_code(404);
    echo "404 Not Found: The requested file does not exist.";
}