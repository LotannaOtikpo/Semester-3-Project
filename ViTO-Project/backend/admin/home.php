<?php 
session_start(); 

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

include_once "config.php";

// Fetching relevant fields for the home section
$sql = "SELECT * FROM home"; 
$result = mysqli_query($conn, $sql);
$homeData = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light background for better contrast */
            color: #343a40; /* Dark text color for readability */
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
            background-color: white; /* White background for the content area */
            border-radius: 10px; /* Rounded corners for the main content */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }
        th, td {
            padding: 10px; 
            text-align: left;
            border: 1px solid #dee2e6; /* Light border for table cells */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s; /* Smooth transition for hover effect */
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
            margin-left: 350px;
            padding: 20px;
        }
        form {
            padding: 20px;
            width: 600px;
            margin: auto;
            border: 1px solid black;
            border-radius: 20px;
        }
        h3 {
            color: white;
            padding: 20px;
            font-size: 20px;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            background-color: #343a40;
            padding-top: 20px;
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
        }
        .sidebar a, .sidebar input[type="text"] {
            width: 170px;
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            border: none;
            background: none;
            border-radius: 10px;
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }
        ul {
            list-style-type: none;
            padding: 10px;
        }
        .sidebar input[type="text"] {
            color: #fff;
            background-color: #495057;
            margin-bottom: 20px;
        }
        .sidebar a:hover, .sidebar input[type="text"]:focus {
            background-color: #575d63;
            outline: none;
        }
        .container {
            padding: 20px;
        }
        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 20px;
        }
        p {
            color: white;
            padding: 10px;
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
    
    <h1>Home Section</h1>
    <table>
        <thead>
            <tr>
                <th>No</th> <!-- Column for item number -->
                <th>Title</th> <!-- Column for item title -->
                <th>Subtitle</th> <!-- Column for item subtitle -->
                <th>Description</th> <!-- Column for item description -->
                <th class="actions">Actions</th> <!-- Column for action buttons -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($homeData)) : // Check if there are any items to display ?>
                <?php foreach ($homeData as $index => $homeItem): // Loop through each item ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td> <!-- Display item number -->
                        <td><?php echo htmlspecialchars($homeItem['title']); ?></td> <!-- Display item title -->
                        <td><?php echo htmlspecialchars($homeItem['subtitle']); ?></td> <!-- Display item subtitle -->
                        <td><?php echo htmlspecialchars($homeItem['description']); ?></td> <!-- Display item description -->
                        <td>
                            <div class="actions"> <!-- Container for action buttons -->
                                <a href="edit_home.php?id=<?php echo $homeItem['id']; ?>" class="btn btn-edit">Edit</a> <!-- Edit button -->
                                <a href="delete.php?id=<?php echo $homeItem['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a> <!-- Delete button with confirmation -->
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: // If there are no items to display ?>
                <tr>
                    <td colspan="5">No data available in the home section.</td> <!-- Message when no data is available -->
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>