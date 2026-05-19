<?php
$code = file_get_contents('app/Http/Controllers/TeacherController.php');
$tokens = token_get_all($code);

$output = false;
$count = 0;

foreach ($tokens as $token) {
    if (is_array($token)) {
        $name = token_name($token[0]);
        $content = $token[1];
        $line = $token[2];
    } else {
        $name = 'CHAR';
        $content = $token;
        $line = 0;
    }

    if ($line >= 165 && $line <= 192) {
        echo "Line $line: $name ('$content')\n";
    }
}
