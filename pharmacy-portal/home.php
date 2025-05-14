<?php
session_start();
require_once("PharmacyDatabase.php");

if (!isset($_SESSION['userType'])) {
    header("Location: login.php");
    exit();
}

$action = $_GET['action'] ?? '';
$userName = $_SESSION['userName'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Pharmacy Portal</h1>

        <nav>
            <?php if (in_array($_SESSION['userType'], ['admin', 'pharmacist'])): ?>
                <a href="?action=addPrescription" class="nav-link">Add Prescription</a>
                <a href="?action=viewPrescriptions" class="nav-link">View Prescriptions</a>
                <a href="?action=viewInventory" class="nav-link">View Inventory</a>
                <a href="?action=addMedication" class="nav-link">Add Medication</a>
                <a href="viewInventoryReport.php" class="nav-link">Inventory Report</a>
                <a href="recordSale.php" class="nav-link">Record Sale</a>
            <?php elseif ($_SESSION['userType'] === 'patient'): ?>
                <a href="?action=viewPrescriptions" class="nav-link">My Prescriptions</a>
            <?php endif; ?>
            <a href="logout.php" class="nav-link">Logout</a>
        </nav>

        <main>
            <?php
            switch ($action) {
                case 'addPrescription':
                    include 'addPrescription.php';
                    break;
                case 'viewPrescriptions':
                    include 'viewPrescriptions.php';
                    break;
                case 'viewInventory':
                    include 'viewInventory.php';
                    break;
                case 'addMedication':
                    include 'addMedication.php';
                    break;
                default:
                    echo "<p>Welcome, " . htmlspecialchars($userName) . "!</p>";
                    break;
            }
            ?>
        </main>
    </div>
</body>
</html>
