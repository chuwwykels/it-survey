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
                $stud_id   = trim($line[0]);
                $fullname = trim($line[1]);
                $rfid     = trim($line[2]);

                // Skip empty rows or invalid RFID
                if (empty($stud_id) || empty($fullname) || empty($rfid) || strtoupper($rfid) == "N/A") {
                    continue;
                }

                // Check whether student already exists
                $select = $conn->prepare("SELECT stud_id FROM student WHERE stud_id = ?");
                $select->execute([$stud_id]);

                if ($select->rowCount() > 0) {
                    // Update existing student
                    $update = $conn->prepare("UPDATE student SET fullname = ?, rfid = ? WHERE stud_id = ?");
                    $update->execute([$fullname, $rfid, $stud_id]);

                    // Audit log
                    addAuditLog($conn, "Updated Student: $fullname");
                } else {
                    // Insert new student
                    $insert = $conn->prepare("INSERT INTO student (stud_id, fullname, rfid) VALUES (?, ?, ?)");
                    $insert->execute([$stud_id, $fullname, $rfid]);

                    // Audit log
                    addAuditLog($conn, "Added New Student: $fullname");
                }
            }

            fclose($csvFile);
        }
    }

    $_SESSION['status'] = "Data Imported Successfully";
    $_SESSION['status_desc'] = "";
    $_SESSION['status_code'] = "success";

    header('Location: ../student.php');
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