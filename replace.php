<?php

$baseDir = 'c:\laragon\SIMRO-SIMRS KOTA MALANG\simrs-rsud-malang';
$excludeDirs = ['vendor', 'node_modules', 'storage', '.git'];

$reps = [
    'SIMRS RSUD Kota Malang' => 'SimpleOK RSUD',
    'SIMRS RSUD KOTA MALANG' => 'SimpleOK RSUD',
    'SIMRS RS Sahabat Sehat' => 'SimpleOK RSUD',
    'SIMRO-SIMRS KOTA MALANG' => 'SimpleOK RSUD',
    'SIMRS' => 'SimpleOK',
    'SIMRO' => 'SimpleOK',
    'simro_db' => 'simpleok_db',
    'simro' => 'simpleok',
    'Simro' => 'Simpleok'
];

$iterator = new RecursiveIteratorIterator(
    new RecursiveCallbackFilterIterator(
        new RecursiveDirectoryIterator($baseDir, RecursiveDirectoryIterator::SKIP_DOTS),
        function ($fileInfo, $key, $iterator) use ($excludeDirs) {
            if ($iterator->hasChildren() && in_array($fileInfo->getFilename(), $excludeDirs)) {
                return false;
            }
            return true;
        }
    )
);

foreach ($iterator as $file) {
    if ($file->isFile() && in_array($file->getExtension(), ['php', 'env', 'html', 'js', 'css', 'md', 'sql'])) {
        $filePath = $file->getPathname();
        // Skip this script itself
        if (basename($filePath) === 'replace.php') continue;
        
        $content = file_get_contents($filePath);
        $orig = $content;
        foreach ($reps as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        if ($orig !== $content) {
            file_put_contents($filePath, $content);
            echo "Updated $filePath\n";
        }
    }
}
