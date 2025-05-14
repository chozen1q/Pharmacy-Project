<?php
require_once("../PharmacyDatabase.php");

$db = new PharmacyDatabase();
$prescriptions = $db->getAllPrescriptions();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prescription Reports</title>
</head>
<body>
    <h1>All Prescriptions</h1>
    <table border="1">
        <tr>
            <th>Prescription ID</th>
            <th>Patient Username</th>
            <th>Medication</th>
            <th>Dosage</th>
            <th>Quantity</th>
        </tr>
        <?php foreach ($prescriptions as $prescription): ?>
            <tr>
                <td><?= htmlspecialchars($prescription["prescriptionId"]) ?></td>
                <td><?= htmlspecialchars($prescription["patientUserName"]) ?></td>
                <td><?= htmlspecialchars($prescription["medicationName"]) ?></td>
                <td><?= htmlspecialchars($prescription["dosageInstructions"]) ?></td>
                <td><?= htmlspecialchars($prescription["quantity"]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

