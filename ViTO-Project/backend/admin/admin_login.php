<?php
session_start(); // Start a new session or resume the existing session

require_once 'config.php'; // Include the configuration file

$hashed_password = password_hash('lotanna1214', PASSWORD_DEFAULT); // Hash the predefined password for verification

// Initialize variables
$username = '';
$username_error = '';
$password_error = '';
$error_class = ''; // Class for error styling

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if the request method is POST
    $username = $_POST['username']; // Get the username from the form
    $password = $_POST['password']; // Get the password from the form

    // Validate username and password
    if (empty($username)) {
        $username_error = "Username is required"; // Set error message if username is empty
        $error_class = 'error'; // Add error class for styling
    }

    if (empty($password)) {
        $password_error = "Password is required"; // Set error message if password is empty
        $error_class = 'error'; // Add error class for styling
    }

    // Only check credentials if both fields are filled
    if (empty($username_error) && empty($password_error)) {
        // Check if the username and password are correct
        if ($username === 'Otikpo Lotanna' && password_verify($password, $hashed_password)) {
            $_SESSION['admin_logged_in'] = true; // Set session variable for admin login
            $_SESSION['username'] = $username; // Store username in session

            // Redirect to admin dashboard (home.php)
            header('Location: home.php'); // Redirect to the home page
            exit(); // Terminate the script to ensure no further code is executed
        } else {
            $username_error = "Invalid username or password"; // Set error message for invalid credentials
            $error_class = 'error'; // Add error class for styling
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('hero2.jpg'); /* Background image for the login page */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; 
        }

        .login-container {
            background-color: white; /* Background color for the login form */
            padding: 20px; /* Padding inside the form */
            border: 1px solid black; /* Border for the form */
            border-radius: 10px; /* Rounded corners for the form */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow effect for the form */
            width: 350px; /* Width of the form */
        }

        .login-container h2 {
            text-align: center; /* Center the heading text */
            margin-bottom: 20px; /* Space below the heading */
            color: black; /* Color for the heading */
        }

        .error-message {
            color: red; /* Color for error messages */
            font-size: 1em; /* Font size for error messages */
            margin-bottom: 10px; /* Space below the error message */
            text-align: center; /* Center the error message text */
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%; /* Full width for the input fields */
            padding: 10px; /* Padding inside the input fields */
            margin: 10px 0; /* Space above and below the input fields */
            border: 1px solid #ccc; /* Light gray border for the input fields */
            border-radius: 5px; /* Rounded corners for the input fields */
        }

        .login-container input[type="text"].error,
        .login-container input[type="password"].error {
            border-color: red; /* Red border for input fields with errors */
        }

        .login-container input[type="text"].error::placeholder,
        .login-container input[type="password"].error::placeholder {
            color: red; /* Red color for placeholder text in input fields with errors */
        }

        .login-container button {
            width: 100%; /* Full width for the button */
            padding: 10px; /* Padding inside the button */
            background-color: purple; /* Background color for the button */
            color: white; /* Text color for the button */
            border: none; /* Remove border from the button */
            border-radius: 5px; /* Rounded corners for the button */
            cursor: pointer; /* Pointer cursor on hover */
            transition: transform 0.5s ease, background-color 0.5s ease; /* Transition effects for button hover */
            margin-left: 10px; /* Space to the left of the button */
        }

        .login-container button:hover {
            transform: scale(1.05); /* Slightly increase button size on hover */
        }

        .login-container p {
            text-align: center; /* Center the text */
        }

        form {
            margin-right: 30px; /* Space to the right of the form */
        }

        .error-text {
            color: red; /* Color for error text */
            font-size: 0.9em; /* Font size for error text */
            margin-top: -5px; /* Negative margin to reduce space above */
            margin-bottom: 10px; /* Space below the error text */
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>
    <?php
    if (isset($error)) {
        echo "<div class='error-message'>$error</div>"; // Display error message if set
    }
    ?>
    <form action="admin_login.php" method="POST"> <!-- Form submission to the same page -->
        <input type="text" id="username" name="username" class="<?php echo !empty($username_error) ? 'error' : ''; ?>" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" >
        <div class="error-text"><?php echo $username_error; ?></div> <!-- Display username error -->

        <input type="password" id="password" name="password" class="<?php echo !empty($password_error) ? 'error' : ''; ?>" placeholder="Password" >
        <div class="error-text"><?php echo $password_error; ?></div> <!-- Display password error -->

        <button type="submit">Login</button> <!-- Submit button for the form -->
    </form>
</div>

</body>
</html>