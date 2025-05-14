<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("PharmacyDatabase.php");

if (!isset($_SESSION['userType']) || !in_array($_SESSION['userType'], ['admin', 'pharmacist'])) {
    header("Location: login.php");
    exit();
}

$db = new PharmacyDatabase();
$conn = $db->getConnection();

$query = "SELECT * FROM MedicationInventoryView";
$inventory = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Medication Inventory Report</h2>

<?php if (count($inventory) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Medication Name</th>
                <th>Dosage</th>
                <th>Manufacturer</th>
                <th>Quantity Available</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventory as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['medicationName']) ?></td>
                    <td><?= htmlspecialchars($row['dosage']) ?></td>
                    <td><?= htmlspecialchars($row['manufacturer']) ?></td>
                    <td><?= htmlspecialchars($row['quantityAvailable']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="no-data">No inventory data found.</p>
<?php endif; ?>

<br>
<a href="home.php" class="nav-link">Back to Dashboard</a>
