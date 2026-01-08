<?php
// Usage: php make_admin.php --email=mahasiswa@gmail.com
$env = @file_get_contents(__DIR__ . '/../.env');
$lines = $env ? explode("\n", $env) : [];
$config = [];
foreach ($lines as $line) {
    if (!trim($line) || $line[0]==='#') continue;
    $parts = explode('=', $line, 2);
    if (count($parts)===2) $config[trim($parts[0])] = trim($parts[1]);
}
$db = [
    'host' => $config['DB_HOST'] ?? '127.0.0.1',
    'port' => $config['DB_PORT'] ?? '3306',
    'name' => $config['DB_DATABASE'] ?? '',
    'user' => $config['DB_USERNAME'] ?? '',
    'pass' => $config['DB_PASSWORD'] ?? '',
];
$dsn = "mysql:host={$db['host']};port={$db['port']};dbname={$db['name']};charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $db['user'], $db['pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo "ERROR: Could not connect to DB: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
// parse args
$args = [];
foreach ($argv as $a) {
    if (strpos($a, '--') === 0) {
        $p = substr($a, 2);
        $parts = explode('=', $p, 2);
        $k = $parts[0];
        $v = $parts[1] ?? '';
        $args[$k] = $v;
    }
}
if (empty($args['email'])) {
    echo "Usage: php make_admin.php --email=you@example.com\n";
    exit(1);
}
$email = $args['email'];
try {
    $stmt = $pdo->prepare('SELECT id, email, role FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo "User with email {$email} not found.\n";
        exit(1);
    }
    $stmt = $pdo->prepare('UPDATE users SET role = ? WHERE id = ?');
    $stmt->execute(['admin', $user['id']]);
    echo "Success: set role='admin' for user {$email} (id={$user['id']}).\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
