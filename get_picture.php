<?php
include('connection/dbconfig.php');

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$id = $_GET['id'];

// Try student
$query = "SELECT stud_id AS id, fullname, 'Student' AS user_type, 
                 CONCAT('images/user/', stud_id, '.jpg') AS pic
          FROM student 
          WHERE stud_id = :id
          UNION
          SELECT emp_id AS id, fullname, 'Employee' AS user_type, 
                 CONCAT('images/user/', emp_id, '.jpg') AS pic
          FROM employee 
          WHERE emp_id = :id";

$stmt = $conn->prepare($query);
$stmt->execute([':id' => $id]);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // fallback kung wala yung picture file
    if (!file_exists($row['pic'])) {
        $row['pic'] = "images/No_Pic 2.png";
    }

    echo json_encode([
        'success' => true,
        'fullname' => $row['fullname'],
        'user_type' => $row['user_type'],
        'primary_id' => $row['id'],
        'pic' => $row['pic']
    ]);
} else {
    echo json_encode(['success' => false]);
}