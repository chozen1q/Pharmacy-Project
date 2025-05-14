<?php
session_start();
require_once("PharmacyDatabase.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $db = new PharmacyDatabase();
    $conn = $db->getConnection();

    $query = "SELECT userId, userName, userPassword, userType FROM Users WHERE userName = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $username);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['userPassword'])) {
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['userName'] = $user['userName']; 
            $_SESSION['userType'] = $user['userType'];

            header("Location: home.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pharmacy Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Pharmacy Portal Login</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <form method="POST" action="login.php">
            <label for="username">Username:</label><br>
            <input type="text" name="username" id="username" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" required><br><br>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
