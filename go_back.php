<?php
session_start();

require_once 'connection/dbconfig.php';

$assist_types = [
    "Hardware Issue ( PC, Laptop, Printer, etc )",
    "Software / Application Issue",
    "Network / Internet Connectivity",
    "Account / Login Assistance"
];

if (in_array($_SESSION['assist_type'], $assist_types)) {
    header("Location: rfid.php");
    exit();
} else {
    header("Location: rfid1.php");
    exit();
}
?>