<?php
require_once("../PharmacyDatabase.php");

$db = new PharmacyDatabase();
$medications = $db->getAllMedications();

echo "<table>";
echo "<tr><th>Medication Name</th><th>Dosage</th><th>Manufacturer</th></tr>";
foreach ($medications as $medication) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($medication['medicationName']) . "</td>";
    echo "<td>" . htmlspecialchars($medication['dosage']) . "</td>";
    echo "<td>" . htmlspecialchars($medication['manufacturer']) . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
