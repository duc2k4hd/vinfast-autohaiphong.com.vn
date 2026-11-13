<?php
function scanDirBlade($dir) {
    $results = [];
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            $results = array_merge($results, scanDirBlade($path));
        } elseif (str_ends_with($file, '.blade.php')) {
            $results[] = $path;
        }
    }
    return $results;
}

$files = scanDirBlade('resources/views');
foreach ($files as $file) {
    $c = file_get_contents($file);
    $ifs = preg_match_all('/@(if|unless|isset|empty)\b/', $c);
    $endifs = preg_match_all('/@(endif|endunless|endisset|endempty)\b/', $c);
    if ($ifs !== $endifs) {
        echo "MISMATCH in $file: ifs=$ifs, endifs=$endifs\n";
    }
}
echo "DONE SCAN\n";

