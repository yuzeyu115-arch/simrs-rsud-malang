<?php
// Usage: php update-env.php <db_name> <db_user> <db_pass>
$db = $argv[1] ?? 'simpleok';
$user = $argv[2] ?? 'root';
$pass = $argv[3] ?? '';

$root = realpath(__DIR__ . '/..');
$envExample = $root . DIRECTORY_SEPARATOR . '.env.example';
$envPath = $root . DIRECTORY_SEPARATOR . '.env';

if (!file_exists($envPath) && file_exists($envExample)) {
    copy($envExample, $envPath);
}

if (!file_exists($envPath)) {
    fwrite(STDERR, ".env not found and .env.example missing.\n");
    exit(1);
}

$env = file_get_contents($envPath);
$map = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_PORT' => '3306',
    'DB_DATABASE' => $db,
    'DB_USERNAME' => $user,
    'DB_PASSWORD' => $pass,
];

foreach ($map as $k => $v) {
    if (preg_match('/^' . preg_quote($k, '/') . '=.*/m', $env)) {
        $env = preg_replace('/^' . preg_quote($k, '/') . '=.*/m', $k . '=' . $v, $env);
    } else {
        $env .= PHP_EOL . $k . '=' . $v;
    }
}

file_put_contents($envPath, $env);
echo ".env updated\n";
