<?php
require_once '../../connection/dbconfig.php';

// filename na may date
$filename = "responses_" . date('Y-m-d') . ".csv";

// headers para mag-download as CSV
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=$filename");

// open file pointer
$output = fopen("php://output", "w");

// header row
fputcsv($output, ['Fullname', 'Stud/Emp ID', 'User Type', 'Assistance Type', 'Rating', 'Timestamp']);

// query sa survey_result
$query = $conn->query("SELECT fullname, primary_id, user_type, assist_type, ratings, timestamp FROM survey_result");

while($row = $query->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>