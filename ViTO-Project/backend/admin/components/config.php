<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "vitoproject";

$con = mysqli_connect($servername, $username, $password, $database);

if (!$con) {
    die("CONNECTION FAILED! " . mysqli_connect_error());
}

