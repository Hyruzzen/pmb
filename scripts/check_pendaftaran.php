<?php
// Simple script to read DB creds from .env and dump latest pendaftarans
$env = file_get_contents(__DIR__ . '/../.env');
$lines = explode("\n", $env);
$config = [];
foreach ($lines as $line) {
    if (!trim($line) || $line[0]==='#') continue;
    $parts = explode('=', $line, 2);
    if (count($parts)===2) {
        $config[trim($parts[0])] = trim($parts[1]);
    }
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

try {
    $stmt = $pdo->query('SELECT p.*, u.email as user_email FROM pendaftarans p LEFT JOIN users u ON u.id = p.user_id ORDER BY p.id DESC LIMIT 10');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) . PHP_EOL;
} catch (Exception $e) {
    echo "ERROR: Query failed: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
