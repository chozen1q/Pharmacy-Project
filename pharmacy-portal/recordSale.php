<?php
session_start();
require_once("PharmacyDatabase.php");

if (!in_array($_SESSION['userType'], ['admin', 'pharmacist'])) {
    header("Location: login.php");
    exit();
}

$db = new PharmacyDatabase();
$conn = $db->getConnection();

$prescriptions = $conn->query("
    SELECT p.prescriptionId, u.userName, m.medicationName
    FROM Prescriptions p
    JOIN Users u ON p.userId = u.userId
    JOIN Medications m ON p.medicationId = m.medicationId
")->fetchAll(PDO::FETCH_ASSOC);

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prescriptionId = $_POST['prescriptionId'];
    $quantitySold = $_POST['quantitySold'];
    $saleAmount = $_POST['saleAmount'];

    try {
        $stmt = $conn->prepare("CALL ProcessSale(?, ?, ?)");
        $stmt->execute([$prescriptionId, $quantitySold, $saleAmount]);
        $message = "Sale recorded successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Record Sale</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Record Sale</h2>

        <?php if ($message): ?>
            <p><strong><?= htmlspecialchars($message) ?></strong></p>
        <?php endif; ?>

        <form method="POST" action="recordSale.php">
            <label for="prescriptionId">Select Prescription:</label><br>
            <select name="prescriptionId" id="prescriptionId" required>
                <?php foreach ($prescriptions as $p): ?>
                    <option value="<?= $p['prescriptionId'] ?>">
                        <?= htmlspecialchars($p['prescriptionId'] . " - " . $p['userName'] . " - " . $p['medicationName']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="quantitySold">Quantity Sold:</label><br>
            <input type="number" name="quantitySold" id="quantitySold" min="1" required><br><br>

            <label for="saleAmount">Sale Amount ($):</label><br>
            <input type="number" name="saleAmount" id="saleAmount" step="0.01" min="0" required><br><br>

            <button type="submit">Record Sale</button>
        </form>

        <br>
        <a href="home.php" class="nav-link">Back to Dashboard</a>
    </div>
</body>
</html>
