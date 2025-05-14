<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("PharmacyDatabase.php");

if (!isset($_SESSION['userType']) || !in_array($_SESSION['userType'], ['pharmacist', 'admin'])) {
    header("Location: login.php");
    exit();
}

$db = new PharmacyDatabase();
$conn = $db->getConnection();

$patients = $conn->query("SELECT userId, userName FROM Users WHERE userType = 'patient'")->fetchAll(PDO::FETCH_ASSOC);
$medications = $conn->query("SELECT medicationId, medicationName FROM Medications")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $patientId = $_POST['patientId'];
    $medId = $_POST['medicationId'];
    $instructions = $_POST['dosageInstructions'];
    $qty = $_POST['quantity'];

    $stmt = $conn->prepare("
        INSERT INTO Prescriptions (userId, medicationId, dosageInstructions, quantity, prescribedDate)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt->bindParam(1, $patientId);
    $stmt->bindParam(2, $medId);
    $stmt->bindParam(3, $instructions);
    $stmt->bindParam(4, $qty);

    $message = $stmt->execute() ? "Prescription added!" : "Failed to add prescription.";
}
?>

<h2>Assign Prescription</h2>

<?php if (isset($message)) echo "<p>$message</p>"; ?>

<form method="POST" action="addPrescription.php">
    <label>Patient Username:</label><br>
    <?php if (empty($patients)): ?>
        <p style="color: red;">⚠ No patients found in the system.</p>
    <?php else: ?>
        <select name="patientId" required>
            <?php foreach ($patients as $p): ?>
                <option value="<?= $p['userId'] ?>"><?= htmlspecialchars($p['userName']) ?></option>
            <?php endforeach; ?>
        </select><br><br>
    <?php endif; ?>

    <label>Medication:</label><br>
    <select name="medicationId" required>
        <?php foreach ($medications as $m): ?>
            <option value="<?= $m['medicationId'] ?>"><?= htmlspecialchars($m['medicationName']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Dosage Instructions:</label><br>
    <textarea name="dosageInstructions" rows="3" cols="30" required></textarea><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" required><br><br>

    <button type="submit">Add Prescription</button>
</form>

<br>
<a href="home.php" class="nav-link">Back to Dashboard</a>
