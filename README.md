# Pharmacy Portal

## Course: CIS 344 - Web Programming  
**Instructor**: Professor Yanilda Peralta Ramos  
**Project Due**: May 5, 2025  
**Presentation**: May 12 or May 14, 2025  

## Overview

This project is a web-based pharmacy portal built using PHP and MySQL. It allows both pharmacists and patients to securely log in, manage prescriptions, medications, inventory, and track sales. The system was created to simulate real-world functionality in a simple and educational way.

## Features

- **Secure Login System**  
  - Role-based access for patients and pharmacists  
  - Passwords are hashed and stored securely  
  - Session management included  

- **User Management**  
  - Users are automatically added to the database if they don’t exist  
  - Users can also be added while entering prescriptions  

- **Prescription Management**  
  - Pharmacists can prescribe medication to patients  
  - Patients can view their active prescriptions  

- **Medication Inventory**  
  - Pharmacists can see available medications and current stock  
  - View displays data from a custom SQL view (`MedicationInventoryView`)  

- **Sales Tracking**  
  - Each prescription can be recorded as a sale  
  - Sales data is linked to prescriptions and tracked in the system  

## Database

Database name: `pharmacy_portal_db`

### Tables
- `Users`
- `Medications`
- `Prescriptions`
- `Inventory`
- `Sales`

### SQL Features
- View: `MedicationInventoryView`
- Trigger: `AfterPrescriptionInsert` (updates inventory after new prescription)
- Stored Procedures:
  - `AddOrUpdateUser`
  - `ProcessSale`

## Project Setup

1. Import the SQL file in your local MySQL server
2. Edit `PharmacyDatabase.php` with your database credentials
3. Run the platform locally using XAMPP, MAMP, or your preferred PHP environment

## How to Use

1. Navigate to `login.php`
2. Log in as either a pharmacist or a patient
3. Pharmacists can add medications, prescriptions, and view inventory
4. Patients can log in and view their prescriptions

## Files

- `login.php`, `authenticate.php`, `dashboard.php`, etc.
- `PharmacyDatabase.php`: contains database connection and key functions
- `viewInventory.php`, `addPrescription.php`, etc.
- `README.md` (this file)
- `report.pdf`: Full explanation of the system with screenshots

## Notes

- All functionality was coded manually, and I tested each feature locally.
- The project helped me better understand database relationships, role-based access, and PHP/MySQL integration.

---

If anything doesn’t work or seems off, feel free to contact me.
