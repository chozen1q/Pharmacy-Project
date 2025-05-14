<?php
require_once("PharmacyDatabase.php");
session_start();

if (!in_array($_SESSION['userType'], ['admin', 'pharmacist'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Medication ID missing.");
}

$medId = $_GET['id'];

$db = new PharmacyDatabase();
$conn = $db->getConnection();

$stmt = $conn->prepare("DELETE FROM Medications WHERE medicationId = ?");
if ($stmt->execute([$medId])) {
    header("Location: home.php?action=viewInventory");
    exit();
} else {
    echo "Error deleting medication.";
}
