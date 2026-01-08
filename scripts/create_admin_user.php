<?php
// Usage:
// php create_admin_user.php --email=admin@example.com --name="Admin" --password=secret

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
    echo "Usage: php create_admin_user.php --email=admin@example.com --name=Admin --password=secret\n";
    exit(1);
}
$email = $args['email'];
$name = $args['name'] ?? 'Admin';
$password = $args['password'] ?? bin2hex(random_bytes(4));
$hashed = password_hash($password, PASSWORD_BCRYPT);

try {
    // check existing
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($exists) {
        echo "User with email {$email} already exists (id={$exists['id']}). Use make_admin.php to set role.\n";
        exit(1);
    }

    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare('INSERT INTO users (name,email,password,role,email_verified_at,created_at,updated_at) VALUES (?,?,?,?,?,?,?)');
    $stmt->execute([$name, $email, $hashed, 'admin', $now, $now, $now]);
    $id = $pdo->lastInsertId();
    echo "Created admin user id={$id}, email={$email}, password={$password}\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
