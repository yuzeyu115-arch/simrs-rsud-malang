<?php
$db = __DIR__ . '/../database/database.sqlite';
if (!file_exists($db)) { echo "MISSING_DB\n"; exit(1); }
try {
    $pdo = new PDO('sqlite:' . $db);
    $stmt = $pdo->prepare('SELECT id, username, email, role, password FROM users WHERE username IN ("tppSimpleOk","kppSimpleOk","dpjbSimpleOk","peranSimpleOk","farmasiSImpleOk","simrsITSK")');
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    file_put_contents(__DIR__ . '/.users_dump.json', json_encode($rows, JSON_PRETTY_PRINT));
    echo "OK\n";
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/.users_dump.json', json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT));
    echo "ERROR\n";
}
