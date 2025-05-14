<?php
session_start();
require_once("PharmacyDatabase.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $db = new PharmacyDatabase();

    $query = "SELECT userId, userName, userPassword, userType FROM Users WHERE userName = ?";
    $stmt = $db->getConnection()->prepare($query);
    
    if (!$stmt) {
        die("Database error: " . $db->getConnection()->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $userName, $hashedPassword, $userType);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['userId'] = $userId;
            $_SESSION['username'] = $userName;
            $_SESSION['userType'] = $userType;

            header("Location: dashboard.php");
            exit();
        }
    }

    header("Location: login.php?error=true");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>