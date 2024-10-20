<?php 
session_start(); // Start the session

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit; // Exit to prevent further execution
}

include_once "config.php"; // Include the database configuration file

// Fetching all data from the 'services' table
$sql = "SELECT * FROM services"; // SQL query to select all records from the services table
$result = mysqli_query($conn, $sql); // Execute the query
$servicesData = mysqli_fetch_all($result, MYSQLI_ASSOC); // Fetch all results as an associative array
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Character set for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive design -->
    <title>Services - Admin</title> <!-- Title of the page -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <style>
        body {
            font-family: Arial, sans-serif; /* Body font */
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
            background-color: white; /* White background for the content area */
            border-radius: 10px; /* Rounded corners for the main content */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }
        th, td {
            padding: 10px;  /* Table cell padding */
            text-align: left; /* Left align text */
            border: 1px solid #dee2e6; /* Light border for table cells */
        }
        table {
            width: 100%; /* Full width table */
            border-collapse: collapse; /* Collapse borders */
        }
        .actions {
            display: flex; /* Flexbox for actions */
            gap: 10px; /* Button gap */
        }
        .btn {
            padding: 5px 10px; /* Button padding */
            border-radius: 5px; /* Button corners */
            cursor: pointer; /* Pointer cursor */
            color: white; /* Button text color */
            text-decoration: none; /* No underline */
        }
        .btn-edit {
            background-color: green;
        }
        .btn-edit:hover {
            color: white;
            background-color: #218838; /* Darker green on hover */
        }
        .btn-delete {
            background-color: red;
        }
        .btn-delete:hover {
            color: white;
            background-color: #c82333; /* Darker red on hover */
        }
        h1 {
            margin-left: 350px; /* Center heading */
            padding: 20px; /* Heading padding */
        }
        form {
            padding: 20px; /* Form padding */
            width: 600px; /* Form width */
            margin: auto; /* Center form */
            border: 1px solid black; /* Form border */
            border-radius: 20px; /* Form corners */
        }
        h3 {
            color: white; /* Subheading color */
            padding: 20px; /* Subheading padding */
            font-size: 20px; /* Subheading font size */
        }
        .sidebar {
            height: 100vh; /* Full height sidebar */
            width: 250px; /* Fixed sidebar width */
            position: fixed; /* Fixed position */
            background-color: #343a40; /* Sidebar background */
            padding-top: 20px; /* Sidebar top padding */
            border-top-right-radius: 50px; /* Rounded corner */
            border-bottom-right-radius: 50px; /* Rounded corner */
        }
        .sidebar a, .sidebar input[type="text"] {
            width: 170px; /* Fixed link/input width */
            padding: 10px 15px; /* Link/input padding */
            text-decoration: none; /* No underline */
            font-size: 18px; /* Font size */
            color: #fff; /* Text color */
            display: block; /* Block display */
            border: none; /* No border */
            background: none;  /* No background */

            border-radius: 10px; /* Rounded corners */
        }
        ul {
            list-style-type: none; /* Remove list style */
            padding: 10px; /* List padding */
        }
        .sidebar input[type="text"] {
            color: #fff; /* Input text color */
            background-color: #495057; /* Input background */
            margin-bottom: 20px; /* Input bottom margin */
        }
        .sidebar a:hover, .sidebar input[type="text"]:focus {
            background-color: #575d63; /* Hover/focus background */
            outline: none; /* No outline */
        }
        .container {
            padding: 20px; /* Container padding */
        }
        .profile-img {
            width: 50px; /* Profile image width */
            height: 50px; /* Profile image height */
            border-radius: 20px; /* Rounded image */
        }
        p {
            color: white; /* Paragraph text color */
            padding: 10px; /* Paragraph padding */
        }
    </style>
</head>
<body>

   <!-- Navbar -->
   <div class="sidebar">

        <h3>
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-ui-checks-grid-fill" viewBox="0 0 16 16" style="margin-right: 5px;">
        <path d="M2 10h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1m9-9h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1m0 9a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1zm0-10a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM2 9a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2zm7 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-3a2 2 0 0 1-2-2zM0 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5.354.854a.5.5 0 1 0-.708-.708L3 3.793l-.646-.647a.5.5 0 1 0-.708.708l1 1a.5.5 0 0 0 .708 0z"/>
        </svg> Admin Dashboard</h3>

        <p><img src="MyPic.jpg" alt="Otikpo Lotanna" class="profile-img" style="margin-right: 5px;"> Otikpo Lotanna</p>

        <ul>
        <input type="text" id="searchInput" onkeyup="filterLinks()" placeholder="Search...">

        <li><a href="home.php">  
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="white" class="bi bi-house-fill" viewBox="0 0 16 16" style="margin-right: 5px;">
        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
        <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
        </svg> Home </a>
        </li>

        <li><a href="about.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="white" class="bi bi-file-person-fill" viewBox="0 0 16 16" style="margin-right: 5px;">
        <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2m-1 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-3 4c2.623 0 4.146.826 5 1.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-1.245C3.854 11.825 5.377 11 8 11"/>
        </svg> About</a></li>
            

        <li><a href="services.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-list-check" viewBox="0 0 16 16" style="margin-right: 5px;">
        <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/>
        </svg> Sevices</a></li>

        </ul>

        <p>
        <a href="admin_logout.php" class="btn btn-danger">Logout</a>
        </p>

    </div>

<div class="main-content">
    
    <h1>Services Section</h1> <!-- Title for the Services section -->

    <table>
        <thead>
            <tr>
                <th>No</th> <!-- Column for item number -->
                <th>Title</th> <!-- Column for service title -->
                <th>Description</th> <!-- Column for service description -->
                <th class="actions">Actions</th> <!-- Column for action buttons -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($servicesData)) : // Check if there are any service items to display ?>
                <?php foreach ($servicesData as $index => $serviceItem): // Loop through each service item ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td> <!-- Display service item number -->
                        <td><?php echo htmlspecialchars($serviceItem['title']); ?></td> <!-- Display service title -->
                        <td><?php echo htmlspecialchars($serviceItem['description']); ?></td> <!-- Display service description -->
                        <td>
                            <div class="actions"> <!-- Container for action buttons -->
                                <a href="edit_services.php?id=<?php echo $serviceItem['id']; ?>" class="btn btn-edit">Edit</a> <!-- Edit button for the service -->
                                <a href="delete.php?id=<?php echo $serviceItem['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a> <!-- Delete button with confirmation -->
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: // If there are no service items to display ?>
                <tr>
                    <td colspan="4">No data available in the services section.</td> <!-- Message displayed when no data is available -->
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>