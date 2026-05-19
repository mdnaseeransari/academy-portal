<?php
$code = file_get_contents('app/Http/Controllers/TeacherController.php');
$lines = explode("\n", $code);

$inMethod = false;
$stack = 0;

for ($i = 0; $i < count($lines); $i++) {
    $lineNum = $i + 1;
    $line = $lines[$i];
    
    if (strpos($line, 'function showAttendance') !== false) {
        $inMethod = true;
        echo "Method started at line $lineNum\n";
    }
    
    if ($inMethod) {
        // Simple brace counting per line (ignoring comments/strings for simplicity)
        $len = strlen($line);
        for ($j = 0; $j < $len; $j++) {
            $char = $line[$j];
            if ($char === '{') {
                $stack++;
                echo "Line $lineNum: Open brace { (Stack size: $stack) - Line content: " . trim($line) . "\n";
            } elseif ($char === '}') {
                $stack--;
                echo "Line $lineNum: Close brace } (Stack size: $stack) - Line content: " . trim($line) . "\n";
                if ($stack === 0) {
                    echo "Method ended at line $lineNum!\n";
                    $inMethod = false;
                    break;
                }
            }
        }
    }
}
