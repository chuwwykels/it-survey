<?php

$query = "SELECT * FROM system LIMIT 1";
$statement = $conn->prepare($query);
$statement->execute();

$result = $statement->fetch(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="../images/<?= $result->site_logo; ?>" rel="icon">
    <link href="images/<?= $result->site_logo; ?>" rel="icon">
    <title><?php if(isset($page_title)){echo "$page_title";} ?></title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/dash1.css" rel="stylesheet">
    <link href="../assets/css/loader3.php" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="../js/scripts.js"></script>
    
    
</head>

<!-- No arrwo for number input -->
<style type="text/css">
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
}
</style>

<body id="page-top">

    <div id="wrapper">