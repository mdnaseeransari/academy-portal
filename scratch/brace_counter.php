<?php
$code = file_get_contents('app/Http/Controllers/TeacherController.php');
$tokens = token_get_all($code);
$stack = [];
$lines = explode("\n", $code);

foreach ($tokens as $token) {
    if (is_array($token)) {
        $name = token_name($token[0]);
        $content = $token[1];
        $line = $token[2];
    } else {
        $name = 'CHAR';
        $content = $token;
        // Search line number roughly
        $line = 0;
    }

    if ($content === '{') {
        $stack[] = $line;
    } elseif ($content === '}') {
        if (empty($stack)) {
            echo "Error: Extra closing brace '}' at line $line\n";
        } else {
            array_pop($stack);
        }
    }
}

if (!empty($stack)) {
    echo "Error: Unclosed opening braces '{' from lines: " . implode(', ', $stack) . "\n";
} else {
    echo "All braces are perfectly balanced!\n";
}
