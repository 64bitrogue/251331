<?php

include "connect.php";

$resident_code = $_POST['id'];

$query = "DELETE FROM residents WHERE resident_code = '$resident_code'";

if ($connection->query($query)) {
    $connection->close();
    header("Location: index.php");
} else {
    echo $connection->error;
}