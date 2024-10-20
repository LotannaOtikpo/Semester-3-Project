<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "vitoproject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['login'])) {
    header("Location: ../logout.php");
    exit;
} else {
    $user_id = $_SESSION['login'];
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
}
?>