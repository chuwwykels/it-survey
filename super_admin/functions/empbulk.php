<?php
// Load the database configuration file
session_start();
include_once '../../connection/dbconfig.php';

if (isset($_POST['importSubmit'])) {

    // Allowed mime types
    $csvMimes = array(
        'text/x-comma-separated-values', 'text/comma-separated-values',
        'application/octet-stream', 'application/vnd.ms-excel',
        'application/x-csv', 'text/x-csv', 'text/csv',
        'application/csv', 'application/excel',
        'application/vnd.msexcel', 'text/plain'
    );

    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

        // If the file is uploaded
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line (header row)
            fgetcsv($csvFile);

            while (($line = fgetcsv($csvFile)) !== FALSE) {
                $emp_id   = str_pad(trim($line[0]), 4, "0", STR_PAD_LEFT);
                $fullname = trim($line[1]);
                $rfid     = trim($line[2]);

                // Skip empty rows or invalid RFID
                if (empty($emp_id) || empty($fullname) || empty($rfid) || strtoupper($rfid) == "N/A") {
                    continue;
                }

                // Check whether employee already exists
                $select = $conn->prepare("SELECT emp_id FROM employee WHERE emp_id = ?");
                $select->execute([$emp_id]);

                if ($select->rowCount() > 0) {
                    // Update existing employee
                    $update = $conn->prepare("UPDATE employee SET fullname = ?, rfid = ? WHERE emp_id = ?");
                    $update->execute([$fullname, $rfid, $emp_id]);

                    // Audit log
                    addAuditLog($conn, "Updated Employee: $fullname");
                } else {
                    // Insert new employee
                    $insert = $conn->prepare("INSERT INTO employee (emp_id, fullname, rfid) VALUES (?, ?, ?)");
                    $insert->execute([$emp_id, $fullname, $rfid]);

                    // Audit log
                    addAuditLog($conn, "Added New Employee: $fullname");
                }
            }

            fclose($csvFile);
        }
    }

    $_SESSION['status'] = "Data Imported Successfully";
    $_SESSION['status_desc'] = "";
    $_SESSION['status_code'] = "success";

    header('Location: ../employee.php');
    exit(0);
}

// Function for audit logs
function addAuditLog($conn, $action)
{
    date_default_timezone_set("Asia/Manila");

    $time = date("H:i:s");
    $date = date("Y-m-d");

    $email = $_SESSION['email'] ?? "system";
    $access_level = $_SESSION['access_level'] ?? "system";

    $query = "INSERT INTO auditlogs (date,time,email,access_level,action) 
              VALUES (:date, :time, :email, :access_level, :action)";
    $stmt = $conn->prepare($query);

    $stmt->execute([
        ':date' => $date,
        ':time' => $time,
        ':email' => $email,
        ':access_level' => $access_level,
        ':action' => $action,
    ]);
}
?>