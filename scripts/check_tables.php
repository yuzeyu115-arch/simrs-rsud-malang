<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$res = $app['db']->select(
    "SELECT table_name FROM information_schema.tables WHERE table_schema = ? AND table_name = ?",
    ['simro_db', 'surgery_schedules']
);

echo json_encode($res, JSON_PRETTY_PRINT);
