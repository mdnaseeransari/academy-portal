<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:convert-images-webp', function () {
    $paths = [
        public_path('images'),
        storage_path('app/public'),
    ];

    $this->info('Starting image conversion to WebP...');

    foreach ($paths as $path) {
        if (!is_dir($path)) continue;

        $directory = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($directory);

        foreach ($iterator as $file) {
            if ($file->isDir()) continue;
            
            $filePath = $file->getRealPath();
            $extension = strtolower($file->getExtension());

            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) continue;

            $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $filePath);

            if (file_exists($webpPath)) {
                $this->line("Skipping (already exists): $webpPath");
                continue;
            }

            $this->info("Converting: $filePath");

            $success = false;
            if (function_exists('imagewebp')) {
                $image = null;
                if ($extension === 'jpg' || $extension === 'jpeg') {
                    $image = @imagecreatefromjpeg($filePath);
                } elseif ($extension === 'png') {
                    $image = @imagecreatefrompng($filePath);
                }

                if ($image) {
                    $success = imagewebp($image, $webpPath, 80);
                    imagedestroy($image);
                }
            }

            if (!$success) {
                // Fallback to npx (Node.js) if GD is not available or fails
                $command = "npx -y cwebp-bin \"$filePath\" -o \"$webpPath\"";
                $output = [];
                $resultCode = 0;
                exec($command, $output, $resultCode);
                $success = ($resultCode === 0);
            }

            if ($success) {
                $this->info("Success: $webpPath");
            } else {
                $this->error("Failed to convert: $filePath");
            }
        }
    }

    $this->info('Image conversion completed!');
})->purpose('Convert all JPG and PNG images to WebP format');
