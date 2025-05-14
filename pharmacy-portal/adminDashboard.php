<?php
session_start();
if ($_SESSION['userType'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome Admin, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    
    <ul>
        <li><a href="viewUsers.php">View Users</a></li>
        <li><a href="viewInventory.php">View Inventory</a></li>
        <li><a href="addMedication.php">Add Medication</a></li>
    </ul>

    <a href="logout.php">Logout</a>
</body>
</html>
