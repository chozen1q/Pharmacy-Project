<?php
require_once("PharmacyDatabase.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $userType = $_POST['userType'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  

    $db = new PharmacyDatabase();
    $conn = $db->getConnection();

    
    $query = "SELECT userId FROM Users WHERE userName = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $error = "Username already exists.";
    } else {
        
        $insertQuery = "INSERT INTO Users (userName, userPassword, userType) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(1, $username);
        $insertStmt->bindParam(2, $hashedPassword);
        $insertStmt->bindParam(3, $userType);

        if ($insertStmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error registering the user.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Pharmacy Portal</title>
</head>
<body>
    <h2>Register for Pharmacy Portal</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="register.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>User Type:</label><br>
        <select name="userType" required>
            <option value="admin">Admin</option>
            <option value="pharmacist">Pharmacist</option>
            <option value="patient">Patient</option>
        </select><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
