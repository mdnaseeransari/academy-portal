<?php
$url = "https://res.cloudinary.com/dtcrssdks/raw/upload/v1715372000/assignments/abcdefg.pdf";
$pattern = '/upload\/(?:v\d+\/)?([^\.]+)/';
if (preg_match($pattern, $url, $matches)) {
    echo "Public ID: " . $matches[1] . "\n";
} else {
    echo "No match\n";
}
