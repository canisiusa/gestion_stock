<?php

namespace App\Controllers;

// FileController.php

class FileController
{
    public function serveFile($filename)
    {
        $filePath = __DIR__ . '/../../storage/' . $filename;

        if (file_exists($filePath)) {
            $mimeType = mime_content_type($filePath);

            header('Content-Type: ' . $mimeType);
            readfile($filePath);
        } else {
            header('HTTP/1.0 404 Not Found');
            echo 'File not found';
        }
    }
}
