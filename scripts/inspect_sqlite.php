<?php
$envFile = __DIR__ . '/../.env';
$env = [];
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (!strpos($line, '=')) continue;
        [$k,$v] = explode('=', $line, 2);
        $env[trim($k)] = trim(trim($v), "\"'");
    }
}
$dbPath = $env['DB_DATABASE'] ?? (__DIR__ . '/../database/database.sqlite');
if (!file_exists($dbPath)) {
    echo json_encode(['status'=>'missing_db','path'=>$dbPath]);
    exit(0);
}
try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name")->fetchAll(PDO::FETCH_COLUMN);
    $users = [];
    try {
        $stmt = $pdo->query("SELECT id, username, email, role FROM users LIMIT 100");
        if ($stmt) $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $users = ['error' => 'users_table_missing_or_error', 'message' => $e->getMessage()];
    }
    echo json_encode(['status'=>'ok','db'=>$dbPath,'tables'=>$tables,'users'=>$users], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
