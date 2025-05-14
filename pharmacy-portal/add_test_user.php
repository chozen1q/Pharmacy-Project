<?php
require_once("PharmacyDatabase.php");
$db = new PharmacyDatabase();


$userName = "jane_doe";  
$contactInfo = "jane@example.com";
$userType = "patient";
$password = "password123"; 

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$stmt = $db->getConnection()->prepare(
    "INSERT INTO Users (userName, contactInfo, userType, userPassword) VALUES (?, ?, ?, ?)"
);

if ($stmt) {
    $stmt->bind_param("ssss", $userName, $contactInfo, $userType, $hashedPassword);
    if ($stmt->execute()) {
        echo "Test user 'jane_doe' added successfully!";
    } else {
        echo "Error inserting user: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Prepare failed: " . $db->getConnection()->error;
}
?>