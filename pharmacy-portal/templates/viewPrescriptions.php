<?php
session_start();
require_once("PharmacyDatabase.php");

if (!isset($_SESSION['userType'])) {
    header("Location: login.php");
    exit();
}

$db = new PharmacyDatabase();
$conn = $db->getConnection();

$userType = $_SESSION['userType'];
$userId = $_SESSION['userId'];

if (in_array($userType, ['admin', 'pharmacist'])) {
    $query = "
        SELECT p.prescriptionId, u.userName, m.medicationName, p.dosageInstructions, p.quantity, p.prescribedDate
        FROM Prescriptions p
        JOIN Users u ON p.userId = u.userId
        JOIN Medications m ON p.medicationId = m.medicationId
        ORDER BY p.prescribedDate DESC
    ";
    $stmt = $conn->query($query);
} else {
    $query = "
        SELECT p.prescriptionId, m.medicationName, p.dosageInstructions, p.quantity, p.prescribedDate
        FROM Prescriptions p
        JOIN Medications m ON p.medicationId = m.medicationId
        WHERE p.userId = ?
        ORDER BY p.prescribedDate DESC
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute([$userId]);
}

$prescriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Prescriptions</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Prescriptions</h1>

        <table>
            <thead>
                <tr>
                    <?php if ($userType !== 'patient'): ?>
                        <th>Patient</th>
                    <?php endif; ?>
                    <th>Medication</th>
                    <th>Dosage Instructions</th>
                    <th>Quantity</th>
                    <th>Prescribed Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($prescriptions) > 0): ?>
                    <?php foreach ($prescriptions as $row): ?>
                        <tr>
                            <?php if ($userType !== 'patient'): ?>
                                <td><?= htmlspecialchars($row['userName']) ?></td>
                            <?php endif; ?>
                            <td><?= htmlspecialchars($row['medicationName']) ?></td>
                            <td><?= htmlspecialchars($row['dosageInstructions']) ?></td>
                            <td><?= htmlspecialchars($row['quantity']) ?></td>
                            <td><?= htmlspecialchars($row['prescribedDate']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= ($userType === 'patient') ? '4' : '5' ?>" class="no-data">No prescriptions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br>
        <a href="home.php" class="nav-link">Back to Dashboard</a>
    </div>
</body>
</html>
