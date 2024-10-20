<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost:3000"); // Allow requests from your React app
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Specify allowed methods
header("Access-Control-Allow-Headers: Content-Type"); // Specify allowed headers

include('admin/config.php'); // Adjust the path to your config file

// Ensure you have a connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to get about data
$sql = "SELECT title, content FROM about"; // Adjust the query as per your database
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Check if data exists
if ($result->num_rows > 0) {
    $aboutData = $result->fetch_assoc(); // Fetch the data
    echo json_encode($aboutData); // Send data back as JSON
} else {
    echo json_encode([]); // No data found
}

$stmt->close();
$conn->close();
?>