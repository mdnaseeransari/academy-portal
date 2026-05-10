<?php
$urls = [
    "https://res.cloudinary.com/dtcrssdks/raw/upload/v1715372000/assignments/abcdefg.pdf",
    "https://res.cloudinary.com/dtcrssdks/image/upload/v1715372000/assignments/image.png"
];
$pattern = '/res\.cloudinary\.com\/[^\/]+\/([^\/]+)\/upload\/(?:v\d+\/)?([^\.]+)/';

foreach ($urls as $url) {
    if (preg_match($pattern, $url, $matches)) {
        echo "URL: $url\n";
        echo "Type: " . $matches[1] . "\n";
        echo "Public ID: " . $matches[2] . "\n\n";
    }
}
