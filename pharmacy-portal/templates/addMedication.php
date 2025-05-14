<?php
session_start();
require_once("PharmacyDatabase.php");

if (!in_array($_SESSION['userType'], ['admin', 'pharmacist'])) {
    header("Location: login.php");
    exit();
}

$db = new PharmacyDatabase();
$conn = $db->getConnection();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['medicationName'];
    $dosage = $_POST['dosage'];
    $manufacturer = $_POST['manufacturer'];
    $quantity = $_POST['quantityInStock'];

    $stmt = $conn->prepare("
        INSERT INTO Medications (medicationName, dosage, manufacturer, quantityInStock)
        VALUES (?, ?, ?, ?)
    ");
