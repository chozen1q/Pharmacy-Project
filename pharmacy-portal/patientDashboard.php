<?php
session_start();
if ($_SESSION['userType'] !== 'patient') {
    header("Location: login.php");
    exit();
}
?>
<h2>Welcome, Patient <?= $_SESSION['username'] ?>!</h2>
<a href="logout.php">Logout</a>
