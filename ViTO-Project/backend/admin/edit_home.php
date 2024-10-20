<?php
include_once "config.php"; // Include database configuration

// Initialize variables for errors and form values
$title = $subtitle = $description = ""; // Form input variables
$titleErr = $subtitleErr = $descriptionErr = ""; // Error messages
$isValid = true; // Flag to check if the form is valid

// Check if ID is passed in the URL and fetch the relevant data
if (isset($_GET['id'])) {
    $url_id = $_GET['id']; // Get the ID from the URL
    $sql = "SELECT * FROM home WHERE id = '$url_id'"; // SQL query to fetch data for the given ID
    $query = mysqli_query($conn, $sql); // Execute the query
    $result = mysqli_fetch_assoc($query); // Fetch the result as an associative array

    // Populate form values with fetched data
    $title = $result['title']; // Set title from the database
    $subtitle = $result['subtitle']; // Set subtitle from the database
    $description = $result['description']; // Set description from the database
} else {
    echo "No ID provided!"; // Error message if no ID is present
    exit(); // Stop execution
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title input
    if (empty($_POST['title'])) {
        $titleErr = "Title is required!"; // Error message for empty title
        $isValid = false; // Set validity flag to false
    } else {
        $title = $_POST['title']; // Assign the title value
    }

    // Validate subtitle input
    if (empty($_POST['subtitle'])) {
        $subtitleErr = "Subtitle is required!"; // Error message for empty subtitle
        $isValid = false; // Set validity flag to false
    } else {
        $subtitle = $_POST['subtitle']; // Assign the subtitle value
    }

    // Validate description input
    if (empty($_POST['description'])) {
        $descriptionErr = "Description is required!"; // Error message for empty description
        $isValid = false; // Set validity flag to false
    } else {
        $description = $_POST['description']; // Assign the description value
    }

    // Process the form and update the record if valid
    if ($isValid) {
        // SQL query to update the record in the home table
        $stm = "UPDATE home SET 
                    title = '$title', 
                    subtitle = '$subtitle', 
                    description = '$description' 
                WHERE id = '$url_id'";
        $stm_qry = mysqli_query($conn, $stm); // Execute the update query

        if ($stm_qry) {
            $_SESSION['success'] = "Record updated successfully!"; // Success message
            header("Location: home.php"); // Redirect to home.php
            exit(); // Stop execution
        } else {
            $_SESSION['error'] = "Unable to update record!"; // Error message for update failure
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Include Bootstrap CSS -->
    <style>
        h1 {
            margin-left: 350px; /* Center the heading */
            padding: 20px; /* Add padding around the heading */
        }
        form {
            padding: 20px; /* Add padding inside the form */
            width: 600px; /* Set form width */
            margin: auto; /* Center the form */
            border: 1px solid black; /* Border for the form */
            border-radius: 20px; /* Rounded corners for the form */
        }
    </style>
</head>
<body>

<div class="container"> <!-- Main container for the content -->
    <h1>Edit Home</h1> <!-- Heading for the edit page -->

    <!-- Include success and error messages -->
    <?php if (isset($_SESSION['success'])): ?> <!-- Check for success message -->
        <?php include 'components/success.php'; ?> <!-- Include success message component -->
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?> <!-- Check for error message -->
        <?php include 'components/error.php'; ?> <!-- Include error message component -->
    <?php endif; ?>

    <form action="" method="POST"> <!-- Form for editing home data -->
        <div class="mb-3"> <!-- Form group for title -->
            <label for="title" class="form-label">Title:</label> <!-- Title label -->
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title" value="<?php echo htmlspecialchars($title); ?>"> <!-- Title input -->
            <small class="text-danger"><?php echo $titleErr; ?></small> <!-- Error message for title -->
        </div>

        <div class="mb-3"> <!-- Form group for subtitle -->
            <label for="subtitle" class="form-label">Subtitle:</label> <!-- Subtitle label -->
            <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Enter the subtitle" value="<?php echo htmlspecialchars($subtitle); ?>"> <!-- Subtitle input -->
            <small class="text-danger"><?php echo $subtitleErr; ?></small> <!-- Error message for subtitle -->
        </div>

        <div class="mb-3"> <!-- Form group for description -->
            <label for="description" class="form-label">Description:</label> <!-- Description label -->
            <textarea name="description" id="description" class="form-control"><?php echo htmlspecialchars($description); ?></textarea> <!-- Description textarea -->
            <small class="text-danger"><?php echo $descriptionErr; ?></small> <!-- Error message for description -->
        </div>

        <button type="submit" name="submit" class="btn btn-outline-dark">Submit</button> <!-- Submit button -->
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> <!-- Include Bootstrap JS -->
</body>
</html>