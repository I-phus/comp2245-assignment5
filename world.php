<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $country = isset($_GET['country']) ? trim($_GET['country']) : '';

    if (!empty($country)) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute([':country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $conn->query("SELECT * FROM countries");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>
<ul>
<?php if ($results): ?>
    <?php foreach ($results as $row): ?>
        <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
    <?php endforeach; ?>
<?php else: ?>
    <li>No results found.</li>
<?php endif; ?>
</ul>
