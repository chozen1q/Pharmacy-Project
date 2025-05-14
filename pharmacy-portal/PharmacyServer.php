<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Portal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Welcome to the Pharmacy Portal</h1>
    
    
    <nav>
        <a href="?action=addPrescription" class="nav-link">Add Prescription</a>
        <a href="?action=viewPrescriptions" class="nav-link">View Prescriptions</a>
        <a href="?action=addMedication" class="nav-link">Add Medication</a> <!-- Add Medication link -->
    </nav>
    
    <div>
        <?php
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'addPrescription':
                    include 'templates/addPrescription.php';
                    break;
                case 'viewPrescriptions':
                    include 'templates/viewPrescriptions.php';
                    break;
                case 'addMedication':
                    include 'templates/addMedication.php';
                    break;
            }
        }
        ?>
    </div>
</body>
</html>