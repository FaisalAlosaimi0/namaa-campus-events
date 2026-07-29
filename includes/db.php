<?php
$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'namaa_campus_events';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die('The website cannot connect to the database at this time.');
}

mysqli_set_charset($conn, 'utf8mb4');
?>
