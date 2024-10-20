<?php
session_start(); // Start a new session or resume the existing session
$conn = mysqli_connect("localhost", "root", "", "vitoproject"); // Connect to the MySQL database

$email = $password = ''; // Initialize email and password variables
$errors = ['email' => '', 'password' => '']; // Initialize error messages for email and password

if (isset($_POST['login'])) { // Check if the login form has been submitted
    $email = trim($_POST['email']); // Trim whitespace from the email input
    $password = trim($_POST['password']); // Trim whitespace from the password input

    // Email validation
    if (empty($email)) {
        $errors['email'] = "Email is required!"; // Error if email is empty
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format!"; // Error if email format is invalid
    } else {
        // SQL query to fetch user data based on email
        $sql = "SELECT id, email, password FROM users WHERE email='$email'";
        $query = mysqli_query($conn, $sql); // Execute the query

        // Check if any user was found with the provided email
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query); // Fetch user data
            // Verify the provided password with the hashed password in the database
            if (!password_verify($password, $row['password'])) {
                $errors['password'] = "Incorrect password!"; // Error if the password does not match
            }
        } else {
            $errors['email'] = "Email not recognized!"; // Error if email is not found in the database
        }
    }

    // Password validation
    if (empty($password)) {
        $errors['password'] = "Password is required!"; // Error if password is empty
    }

    // If there are no errors, log the user in
    if (!array_filter($errors)) {
        $_SESSION['login'] = $row['id']; // Store user ID in session
        header("Location: http://localhost:3000/home"); // Redirect to the home page
        unset($_POST['email']); // Clear email input after successful login
        unset($_POST['password']); // Clear password input after successful login
        exit(); // Exit the script
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Styles for body to center content and add background image */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('hero2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat; 
        }

        a {
            text-decoration: none; /* Remove underline from links */
            color: purple; /* Set link color */
        }

        form {
            margin-right: 30px; /* Add right margin to the form */
        }

        /* Styles for the login container */
        .login-container {
            background-color: white; /* Set background color */
            padding: 20px; /* Add padding */
            border: 1px solid black; /* Set border */
            border-radius: 10px; /* Round corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
            width: 350px; /* Set width of the container */
        }

        /* Styles for headings in the login container */
        .login-container h2 {
            text-align: center; /* Center align the heading */
            margin-bottom: 20px; /* Add bottom margin */
            color: black; /* Set text color */
        }

        /* Styles for input fields in the login container */
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%; /* Full width */
            padding: 10px; /* Add padding */
            margin: 10px 0; /* Add vertical margin */
            border: 1px solid black; /* Set border */
            border-radius: 5px; /* Round corners */
            color: black; /* Set text color */
        }

        .login-container input.error {
            border: 1px solid red; /* Turn border red when there's an error */
        }

        .login-container input::placeholder {
            color: #999; /* Set placeholder text color */
        }

        .login-container input.error::placeholder {
            color: red; /* Change placeholder text color to red on error */
        }

        /* Styles for error message display */
        .login-container span.error-message {
            color: red; /* Set error message text color */
            font-size: 0.9em; /* Set font size */
            margin: 5px 0; /* Add vertical margin */
            display: block; /* Make it a block element */
            margin-left: 10px; /* Add left margin */
        }

        /* Styles for the login button */
        .login-container button {
            width: 100%; /* Full width */
            padding: 10px; /* Add padding */
            margin-top: 10px; /* Add top margin */
            background-color: purple; /* Set background color */
            color: white; /* Set text color */
            border: none; /* Remove border */
            border-radius: 10px; /* Round corners */
            cursor: pointer; /* Change cursor on hover */
            margin-left: 20px; /* Add left margin */
            transition: transform 0.5s ease, background-color 0.5s ease; /* Add transition effect */
        }

        .login-container button:hover {
            transform: scale(1.05); /* Scale button on hover */
        }

        /* Styles for paragraph text in the login container */
        .login-container p {
            text-align: center; /* Center align the paragraph */
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <form action="login.php" method="post"> <!-- Form submission to the same page -->
        <input type="text" name="email" 
               class="<?php echo !empty($errors['email']) ? 'error' : ''; ?>" 
               placeholder="Email" 
               value="<?php echo htmlspecialchars($email); ?>"> <!-- Pre-fill email input if available -->
        <?php if (!empty($errors['email'])): ?>
            <span class="error-message"><?php echo $errors['email']; ?></span> <!-- Display email error message -->
        <?php endif; ?>

        <input type="password" name="password" 
               class="<?php echo !empty($errors['password']) ? 'error' : ''; ?>" 
               placeholder="Password"> <!-- Password input -->
        <?php if (!empty($errors['password'])): ?>
            <span class="error-message"><?php echo $errors['password']; ?></span> <!-- Display password error message -->
        <?php endif; ?>

        <p><a href="login.php">Forgot Password?</a></p> <!-- Link for forgotten password -->

        <button type="submit" name="login">Login</button> <!-- Submit button -->
    </form>

    <p>Don't have an account? <a href="signup.php">Sign Up</a></p> <!-- Link to signup page -->
</div>

</body>
</html>