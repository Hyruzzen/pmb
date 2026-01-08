<?php
// Usage examples:
// php update_pendaftaran.php --id=1 --tempat="Bandung" --tanggal=1990-01-01 --alamat="Jalan Mawar 1"
// php update_pendaftaran.php --email=mahasiswa@gmail.com --tempat="Bandung" --tanggal=1990-01-01 --alamat="Jalan Mawar 1"

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

if (empty($args['id']) && empty($args['email'])) {
    echo "Provide --id or --email and at least one of --tempat, --tanggal, --alamat\n";
    exit(1);
}

$fields = [];
if (isset($args['tempat'])) $fields['tempat_lahir'] = $args['tempat'];
if (isset($args['tanggal'])) $fields['tanggal_lahir'] = $args['tanggal'];
if (isset($args['alamat'])) $fields['alamat'] = $args['alamat'];
if (isset($args['jenis'])) $fields['jenis_kelamin'] = $args['jenis'];

if (empty($fields)) {
    echo "Nothing to update. Use --tempat, --tanggal, --alamat or --jenis\n";
    exit(1);
}

try {
    if (!empty($args['id'])) {
        $id = (int)$args['id'];
        $placeholders = [];
        $params = [];
        foreach ($fields as $k => $v) {
            $placeholders[] = "`$k` = ?";
            $params[] = $v;
        }
        $params[] = $id;
        $sql = "UPDATE pendaftarans SET " . implode(', ', $placeholders) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        echo "Updated pendaftarans id=$id\n";
    } else {
        // resolve id by email
        $stmt = $pdo->prepare('SELECT p.id FROM pendaftarans p JOIN users u ON u.id = p.user_id WHERE u.email = ? LIMIT 1');
        $stmt->execute([$args['email']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            echo "No pendaftaran found for email {$args['email']}\n";
            exit(1);
        }
        $id = (int)$row['id'];
        $placeholders = [];
        $params = [];
        foreach ($fields as $k => $v) {
            $placeholders[] = "`$k` = ?";
            $params[] = $v;
        }
        $params[] = $id;
        $sql = "UPDATE pendaftarans SET " . implode(', ', $placeholders) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        echo "Updated pendaftarans id=$id (resolved from {$args['email']})\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
