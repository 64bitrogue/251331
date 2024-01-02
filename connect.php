<?php

$connection = new mysqli('localhost', 'root', '', '251331');

if (!$connection) {
    die(mysqli_error($connection));
}