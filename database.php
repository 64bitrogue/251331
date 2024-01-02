<?php

$host = "localhost";
$dbname = "251331";
$username = "root";
$password = "";

$connection = new mysqli($host, $username, $password, $dbname);

if (!$mysqli) {
    die("Connection error: " . mysqli_error($connection));
}