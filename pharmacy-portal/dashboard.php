<?php
session_start();

if (!isset($_SESSION['userId'])) {
   
    header("Location: login.php");
    exit();
}

echo "<h1>Welcome, " . $_SESSION['username'] . "</h1>";
echo "<p>User Type: " . $_SESSION['userType'] . "</p>";

?>


<a href="logout.php">Logout</a>
