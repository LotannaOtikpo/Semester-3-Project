<?php
include_once "config.php"; 

// Initialize variables for errors and form values
$title = $subtitle = $content = $video_url = ""; // Form input variables
$titleErr = $subtitleErr = $contentErr = $video_urlErr = ""; // Error messages
$isValid = true; // Flag to check if the form is valid

// Check if ID is passed in the URL and fetch the relevant data
if (isset($_GET['id'])) {
    $url_id = $_GET['id']; // Get the ID from the URL
    $sql = "SELECT * FROM about WHERE id = '$url_id'"; // SQL query to fetch data for the given ID
    $query = mysqli_query($conn, $sql); // Execute the query
    $result = mysqli_fetch_assoc($query); // Fetch the result as an associative array

    // Populate form values with fetched data
    $title = $result['title']; // Set title from the database
    $content = $result['content']; // Set content from the database
    $video_url = $result['video_url']; // Set video URL from the database
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

    // Validate content input
    if (empty($_POST['content'])) {
        $contentErr = "Content is required!"; // Error message for empty content
        $isValid = false; // Set validity flag to false
    } else {
        $content = $_POST['content']; // Assign the content value
    }

    // Validate video URL input
    if (empty($_POST['video_url'])) {
        $video_urlErr = "Video URL is required!"; // Error message for empty video URL
        $isValid = false; // Set validity flag to false
    } else {
        $video_url = $_POST['video_url']; // Assign the video URL value
    }

    // Process the form and update the record if valid
    if ($isValid) {
        // SQL query to update the record in the about table
        $stm = "UPDATE about SET 
                    title = '$title', 
                    content = '$content',
                    video_url = '$video_url'
                WHERE id = '$url_id'";
        $stm_qry = mysqli_query($conn, $stm); // Execute the update query

        if ($stm_qry) {
            $_SESSION['success'] = "Record updated successfully!"; // Success message
            header("Location: about.php"); // Redirect to about.php
            exit(); // Stop execution
        } else {
            $error = "Unable to update record!"; // Error message for update failure
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About</title>
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
    <h1>Edit About</h1> <!-- Heading for the edit page -->

    <?php if (isset($error)) : ?> <!-- Check for error message -->
        <div class="alert alert-danger" role="alert"> <!-- Alert box for error -->
            <?php echo $error; ?> <!-- Display the error message -->
        </div>
    <?php endif; ?>
    
    <form action="" method="POST"> <!-- Form for editing about data -->
        <div class="mb-3"> <!-- Form group for title -->
            <label for="title" class="form-label">Title:</label> <!-- Title label -->
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title" value="<?php echo htmlspecialchars($title); ?>"> <!-- Title input -->
            <small class="text-danger"><?php echo $titleErr; ?></small> <!-- Error message for title -->
        </div>

        <div class="mb-3"> <!-- Form group for content -->
            <label for="content" class="form-label">Content:</label> <!-- Content label -->
            <textarea name="content" id="content" class="form-control"><?php echo htmlspecialchars($content); ?></textarea> <!-- Content textarea -->
            <small class="text-danger"><?php echo $contentErr; ?></small> <!-- Error message for content -->
        </div>

        <div class="mb-3"> <!-- Form group for video URL -->
            <label for="video_url" class="form-label">Video URL:</label> <!-- Video URL label -->
            <input type="text" class="form-control" id="video_url" name="video_url" placeholder="Enter video URL" value="<?php echo htmlspecialchars($video_url); ?>"> <!-- Video URL input -->
            <small class="text-danger"><?php echo $video_urlErr; ?></small> <!-- Error message for video URL -->
        </div>

        <button type="submit" name="submit" class="btn btn-outline-dark">Submit</button> <!-- Submit button -->
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> <!-- Include Bootstrap JS -->
</body>
</html>