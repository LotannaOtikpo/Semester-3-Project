<?php 
session_start(); // Start the session

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit; // Exit to prevent further execution
}

include_once "config.php"; // Include the database configuration file

// Fetching relevant fields for the about section
$sql = "SELECT * FROM about"; // SQL query to select all records from the about table
$result = mysqli_query($conn, $sql); // Execute the query
$aboutData = mysqli_fetch_all($result, MYSQLI_ASSOC); // Fetch all results as an associative array
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Character set for the document -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive design -->
    <title>About Us - Admin</title> <!-- Title of the page -->
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
            gap: 10px; /* Space between action buttons */
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
            background-color: #343a40; /* Sidebar background color */
            padding-top: 20px; /* Sidebar top padding */
            border-top-right-radius: 50px; /* Rounded top right corner */
            border-bottom-right-radius: 50px; /* Rounded bottom right corner */
        }
        .sidebar a, .sidebar input[type="text"] {
            width: 170px; /* Fixed width for links and inputs */
            padding: 10px 15px; /* Padding for links and inputs */
            text-decoration: none; /* No underline for links */
            font-size: 18px; /* Font size for links */
            color: #fff; /* Text color for links */
            display: block; /* Block display for links */
            border: none; /* No border */
            background: none; /* No background */
            border-radius: 10px; /* Rounded corners for links */
        }
        ul {
            list-style-type: none; /* Remove list style */
            padding: 10px; /* List padding */
        }
        .sidebar input[type="text"] {
            color: #fff; /* Input text color */
            background-color: #495057; /* Input background color */
            margin-bottom: 20px; /* Margin below input */
        }
        .sidebar a:hover, .sidebar input[type="text"]:focus {
            background-color: #575d63; /* Background color on hover/focus */
            outline: none; /* No outline on focus */
        }
        .container {
            padding: 20px; /* Container padding */
        }
        .profile-img {
            width: 50px; /* Profile image width */
            height: 50px; /* Profile image height */
            border-radius: 20px; /* Rounded profile image */
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

<div class="main-content"> <!-- Main content area -->

        <h1>About Us Section</h1> <!-- Heading for the About Us section -->

        <table>
            <thead> <!-- Table header -->
                <tr>
                    <th>No</th> <!-- Column for item number -->
                    <th>Title</th> <!-- Column for the title -->
                    <th>Description</th> <!-- Column for the description -->
                    <th>Video URL</th> <!-- Column for the video URL -->
                    <th class="actions">Actions</th> <!-- Column for action buttons -->
                </tr>
            </thead>
            <tbody> <!-- Table body -->
                <?php if (!empty($aboutData)) : ?> <!-- Check if there is data to display -->
                    <?php foreach ($aboutData as $index => $aboutItem): ?> <!-- Loop through each item in aboutData -->
                        <tr>
                            <td><?php echo $index + 1; ?></td> <!-- Display item number -->
                            <td><?php echo htmlspecialchars($aboutItem['title']); ?></td> <!-- Display title, escaped for safety -->
                            <td><?php echo htmlspecialchars($aboutItem['content']); ?></td> <!-- Display description/content, escaped for safety -->
                            <td><?php echo htmlspecialchars($aboutItem['video_url']); ?></td> <!-- Display video URL, escaped for safety -->
                            <td>
                                <div class="actions"> <!-- Actions container -->
                                    <a href="edit_about.php?id=<?php echo $aboutItem['id']; ?>" class="btn btn-edit">Edit</a> <!-- Edit button -->
                                    <a href="delete.php?id=<?php echo $aboutItem['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a> <!-- Delete button with confirmation -->
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?> <!-- End of foreach loop -->
                <?php else: ?> <!-- No data available case -->
                    <tr>
                        <td colspan="6">No data available in the about section.</td> <!-- Message indicating no data -->
                    </tr>
                <?php endif; ?> <!-- End of if condition -->
            </tbody>
        </table> 

    </div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>