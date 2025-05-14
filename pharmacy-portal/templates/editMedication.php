<?php
require_once("PharmacyDatabase.php");

$db = new PharmacyDatabase();
$conn = $db->getConnection();

if (!isset($_GET['id'])) {
    die("Medication ID not provided.");
}

$medId = $_GET['id'];
$message = "";

$stmt = $conn->prepare("SELECT * FROM Medications WHERE medicationId = ?");
$stmt->execute([$medId]);
$medication = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$medication) {
    die("Medication not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['medicationName'];
    $dosage = $_POST['dosage'];
    $manufacturer = $_POST['manufacturer'];
    $quantity = $_POST['quantityInStock'];

    $update = $conn->prepare("
        UPDATE Medications 
        SET medicationName = ?, dosage = ?, manufacturer = ?, quantityInStock = ?
        WHERE medicationId = ?
    ");
    if ($update->execute([$newName, $dosage, $manufacturer, $quantity, $medId])) {
        $message = "Medication updated successfully.";
        $stmt->execute([$medId]);
        $medication = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $message = "Update failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Medication</title>
</head>
<body>
    <h1>Edit Medication</h1>

    <?php if ($message): ?>
        <p><strong><?= htmlspecialchars($message) ?></strong></p>
    <?php endif; ?>

    <form method="POST">
        <label for="medicationName">Medication Name:</label><br>
        <input type="text" name="medicationName" id="medicationName" value="<?= htmlspecialchars($medication['medicationName']) ?>" required><br><br>

        <label for="dosage">Dosage:</label><br>
        <input type="text" name="dosage" id="dosage" value="<?= htmlspecialchars($medication['dosage'] ?? '') ?>"><br><br>

        <label for="manufacturer">Manufacturer:</label><br>
        <input type="text" name="manufacturer" id="manufacturer" value="<?= htmlspecialchars($medication['manufacturer'] ?? '') ?>"><br><br>

        <label for="quantityInStock">Quantity In Stock:</label><br>
        <input type="number" name="quantityInStock" id="quantityInStock" value="<?= htmlspecialchars($medication['quantityInStock'] ?? 0) ?>" min="0"><br><br>

        <button type="submit">Save Changes</button>
    </form>

    <br>
    <a href="home.php?action=viewInventory">Back to Inventory</a>
</body>
</html>
