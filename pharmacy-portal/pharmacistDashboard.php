<?php
session_start();
if ($_SESSION['userType'] !== 'pharmacist') {
    header("Location: login.php");
    exit();
}
?>
<h2>Welcome, Pharmacist <?= $_SESSION['username'] ?>!</h2>
<a href="logout.php">Logout</a>
