<?php
require_once("PharmacyDatabase.php");


if (!in_array($_SESSION['userType'], ['admin', 'pharmacist'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['medicationName']);
    $manufacturer = trim($_POST['manufacturer']);
    $qty = intval($_POST['quantity']);
    $price = floatval($_POST['price']); 

    $db = new PharmacyDatabase();
    $conn = $db->getConnection();

    $query = "INSERT INTO Medications (medicationName, dosage, manufacturer) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $qty); 
    $stmt->bindParam(3, $manufacturer);

    $message = $stmt->execute() ? "Medication added successfully!" : "Error adding medication.";
}
?>

<h2>Add New Medication</h2>

<?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>

<form method="post" action="addMedication.php">
    <label for="medicationName">Medication Name:</label><br>
    <input type="text" name="medicationName" id="medicationName" required><br><br>

    <label for="manufacturer">Manufacturer:</label><br>
    <input type="text" name="manufacturer" id="manufacturer" required><br><br>

    <label for="quantity">Dosage:</label><br>
    <input type="text" name="quantity" id="quantity" required><br><br>

  

    <button type="submit">Add Medication</button>
</form>

<br>
<a href="home.php" class="nav-link">Back to Dashboard</a>
