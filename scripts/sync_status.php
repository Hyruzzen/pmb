<?php
// Usage: php sync_status.php --email=mahasiswa@gmail.com
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
    echo "Usage: php sync_status.php --email=mahasiswa@gmail.com\n";
    exit(1);
}
$email = $args['email'];
try {
    // Fetch user status
    $stmt = $pdo->prepare('SELECT u.id, u.status_pendaftaran, p.id as pend_id, p.status_pendaftaran as pend_status FROM users u LEFT JOIN pendaftarans p ON u.id = p.user_id WHERE u.email = ? LIMIT 1');
    $stmt->execute([$email]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
        echo "User with email {$email} not found.\n";
        exit(1);
    }
    
    echo "User: {$email}\n";
    echo "  users.status_pendaftaran: {$data['status_pendaftaran']}\n";
    echo "  pendaftarans.status_pendaftaran: {$data['pend_status']}\n";
    
    if ($data['pend_id'] && $data['status_pendaftaran'] !== $data['pend_status']) {
        // Sync: update pendaftarans.status_pendaftaran to match users.status_pendaftaran
        $stmt = $pdo->prepare('UPDATE pendaftarans SET status_pendaftaran = ? WHERE id = ?');
        $stmt->execute([$data['status_pendaftaran'], $data['pend_id']]);
        echo "\nSynced: pendaftarans id={$data['pend_id']} status_pendaftaran set to '{$data['status_pendaftaran']}'\n";
    } else {
        echo "\nNo sync needed (already in sync).\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
