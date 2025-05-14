<?php
session_start();
require_once("PharmacyDatabase.php");

if (!in_array($_SESSION['userType'], ['admin', 'pharmacist'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new PharmacyDatabase();

    $patientUserName = $_POST["patientUserName"] ?? '';
    $medicationId = $_POST["medicationId"] ?? '';
    $dosageInstructions = $_POST["dosageInstructions"] ?? '';
    $quantity = $_POST["quantity"] ?? '';

    if ($patientUserName && $medicationId && $dosageInstructions && $quantity) {
        $result = $db->addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity);
        $message = $result ? "Prescription added successfully!" : "Error adding prescription.";
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prescription</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Add Prescription</h2>

        <?php if ($message): ?>
            <p><strong><?= htmlspecialchars($message) ?></strong></p>
        <?php endif; ?>

        <form method="post" action="addPrescription.php">
            <label for="patientUserName">Patient Username:</label><br>
            <input type="text" name="patientUserName" id="patientUserName" required><br><br>

            <label for="medicationId">Medication ID:</label><br>
            <input type="number" name="medicationId" id="medicationId" required><br><br>

            <label for="dosageInstructions">Dosage Instructions:</label><br>
            <textarea name="dosageInstructions" id="dosageInstructions" required></textarea><br><br>

            <label for="quantity">Quantity:</label><br>
            <input type="number" name="quantity" id="quantity" required><br><br>

            <button type="submit">Add Prescription</button>
        </form>

        <br>
        <a href="home.php" class="nav-link">Back to Dashboard</a>
    </div>
</body>
</html>
