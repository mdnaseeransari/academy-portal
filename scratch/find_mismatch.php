<?php
$code = file_get_contents('app/Http/Controllers/TeacherController.php');
$tokens = token_get_all($code);

$stack = [];
$inMethod = false;

foreach ($tokens as $token) {
    if (is_array($token)) {
        $name = token_name($token[0]);
        $content = $token[1];
        $line = $token[2];
    } else {
        $name = 'CHAR';
        $content = $token;
        $line = 0; // token_get_all doesn't give line for single char in old php, let's keep track or estimate
    }

    if ($name === 'T_FUNCTION') {
        // we'll get the line of the function keyword
        $currentFuncLine = $line;
    }
    
    // Track lines approximately
    static $lastLine = 1;
    if ($line > 0) {
        $lastLine = $line;
    } else {
        $line = $lastLine;
    }

    if (is_array($token) && $token[0] === T_STRING && $token[1] === 'showAttendance') {
        $inMethod = true;
        echo "showAttendance started at line $line\n";
    }

    if ($inMethod) {
        if ($content === '{') {
            $stack[] = $line;
            echo "  Open '{' at line $line. Stack size: " . count($stack) . "\n";
        } elseif ($content === '}') {
            $openedAt = array_pop($stack);
            echo "  Close '}' at line $line (matching '{' from line $openedAt). Stack size: " . count($stack) . "\n";
            if (empty($stack)) {
                echo "showAttendance completed at line $line!\n";
                $inMethod = false;
            }
        }
    }
}
