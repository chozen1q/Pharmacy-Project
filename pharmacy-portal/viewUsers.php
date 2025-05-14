<?php
session_start();
require_once("PharmacyDatabase.php");


if ($_SESSION['userType'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$db = new PharmacyDatabase();
$conn = $db->getConnection();

$query = "SELECT userId, userName, userType FROM Users";
$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Users</title>
</head>
<body>
    <h2>Registered Users</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>User Type</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['userId']) ?></td>
            <td><?= htmlspecialchars($user['userName']) ?></td>
            <td><?= htmlspecialchars($user['userType']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="adminDashboard.php">Back to Dashboard</a>
</body>
</html>
