<?php
// Auto login test: bootstrap Laravel and check hashed passwords for test users
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$tests = [
    ['username' => 'tppSimpleOk', 'password' => 'tpp123'],
    ['username' => 'kppSimpleOk', 'password' => 'kpp123'],
    ['username' => 'dpjbSimpleOk', 'password' => 'dpjb123'],
    ['username' => 'peranSimpleOk', 'password' => 'anestesi123'],
    ['username' => 'farmasiSImpleOk', 'password' => 'farmasi123'],
];

$results = [];
foreach ($tests as $t) {
    $username = $t['username'];
    $password = $t['password'];
    $user = User::whereRaw('LOWER(username)=?', [strtolower($username)])->first();
    if (! $user) {
        $results[] = ['username' => $username, 'found' => false, 'can_login' => false, 'message' => 'user_not_found'];
        continue;
    }
    $ok = Hash::check($password, $user->password);
    $results[] = ['username' => $username, 'found' => true, 'db_username' => $user->username, 'role' => $user->role, 'can_login' => $ok];
}

file_put_contents(__DIR__ . '/auto_login_result.json', json_encode($results, JSON_PRETTY_PRINT));
echo "DONE\n";
