<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "con_net";

$conn = mysqli_connect($host,$user,$pass,$dbname);

if (!$conn) {
    die("Error COnnectig to database" . mysqli_connect_error($conn));
}
?>