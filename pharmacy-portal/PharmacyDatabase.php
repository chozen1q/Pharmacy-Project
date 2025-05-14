<?php

class PharmacyDatabase {
    private $conn;

    public function __construct() {
        $host = "localhost";
        $dbname = "pharmacy";
        $username = "root";
        $password = "root"; 

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function getPDOConnection() {
        return $this->conn;
    }

    public function addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity) {
        $stmt = $this->conn->prepare("SELECT userId FROM Users WHERE userName = ?");
        $stmt->execute([$patientUserName]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "User not found.";
            return false;
        }

        $userId = $user['userId'];

        $insert = $this->conn->prepare("
            INSERT INTO Prescriptions (userId, medicationId, dosageInstructions, quantity, prescribedDate)
            VALUES (?, ?, ?, ?, NOW())
        ");
        return $insert->execute([$userId, $medicationId, $dosageInstructions, $quantity]);
    }

    public function addMedication($name, $dosage, $manufacturer) {
        $stmt = $this->conn->prepare(
            "INSERT INTO Medications (medicationName, dosage, manufacturer) VALUES (?, ?, ?)"
        );
        $stmt->execute([$name, $dosage, $manufacturer]);
    }

    public function getAllMedications() {
        $stmt = $this->conn->query("SELECT * FROM Medications");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser($userName, $contactInfo, $userType, $plainPassword) {
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare(
            "INSERT INTO Users (userName, contactInfo, userType, userPassword) VALUES (?, ?, ?, ?)"
        );
        if ($stmt->execute([$userName, $contactInfo, $userType, $hashedPassword])) {
            echo "User '$userName' added successfully.<br>";
        } else {
            echo "Error adding user: " . $stmt->errorInfo()[2] . "<br>";
        }
    }

    public function getAllPrescriptions() {
        $query = "SELECT p.prescriptionId, u.userName, m.medicationName, p.dosageInstructions, p.quantity
                  FROM Prescriptions p
                  JOIN Users u ON p.userId = u.userId
                  JOIN Medications m ON p.medicationId = m.medicationId";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getUserDetails($userId) {
        $stmt = $this->conn->prepare("
            SELECT u.userName, u.contactInfo, u.userType,
                   p.prescriptionId, m.medicationName, p.dosageInstructions, p.quantity, p.prescribedDate
            FROM Users u
            LEFT JOIN Prescriptions p ON u.userId = p.userId
            LEFT JOIN Medications m ON p.medicationId = m.medicationId
            WHERE u.userId = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
