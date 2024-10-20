<?php
// Initialize error messages and form input variables
$errors = ['name' => '', 'email' => '', 'password' => '', 'confirm_password' => '', 'passport' => ''];
$name = $email = $password = $confirm_password = $passport = '';
$success_message = ''; 

// Establish a database connection
$conn = mysqli_connect("localhost", "root", "", "vitoproject");

// Check if the form is submitted
if (isset($_POST['signup'])) {
    // Trim and assign form input values to variables
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $passport = $_FILES['passport']['name'];
    
    // Name validation
    if (empty($name)) {
        $errors['name'] = "Name is required!";
    } else {
        // Check if name contains only letters and spaces
        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            $errors['name'] = "Enter a valid name!";
        }
    }

    // Email validation
    if (empty($email)) {
        $errors['email'] = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Validate email format
        $errors['email'] = "Invalid email format!";
    }

    // Password validation
    if (empty($password)) {
        $errors['password'] = "Password is required!";
    } elseif (strlen($password) < 4) {
        // Check password length
        $errors['password'] = "Password must be more than 4 characters!";
    } elseif (strlen($password) > 8) {
        $errors['password'] = "Password must not exceed 8 characters!";
    } elseif (!preg_match("/^[a-zA-Z0-9@]+$/", $password)) {
        // Validate password content
        $errors['password'] = "Password can only contain letters, numbers, and the '@' symbol!";
    }

    // Confirm Password validation
    if (empty($confirm_password)) {
        $errors['confirm_password'] = "Please confirm your password!";
    } elseif ($password !== $confirm_password) {
        // Check if passwords match
        $errors['confirm_password'] = "Passwords do not match!";
    }

    // Passport validation
    if (empty($passport)) {
        $errors['passport'] = "Passport is required!";
    } elseif (!preg_match('!image!', $_FILES['passport']['type'])) {
        // Validate if the passport file is an image
        $errors['passport'] = "Passport file must be an image extension!";
    } elseif (isset($_FILES['passport'])) {
        // Check file size
        $maxFileSize = 5 * 1024 * 1024; // 5MB limit
        if ($_FILES['passport']['size'] > $maxFileSize) {
            $errors['passport'] = "Exceed 5MB size limit. Upload a file less than 5MB!";
        }
    }

    // Check for errors before proceeding
    if (!array_filter($errors)) {
        // Check if the email already exists in the database
        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $checkEmail);
        
        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = "Email already registered!";
        } else {
            // Hash the password before saving
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Save the passport image to the uploads directory
            move_uploaded_file($_FILES['passport']['tmp_name'], "uploads/" . $passport);
            
            // Save user information into the database
            $sql = "INSERT INTO users (name, email, password, passport) VALUES ('$name', '$email', '$hashedPassword', '$passport')";
            
            // Execute the SQL query
            if (mysqli_query($conn, $sql)) {
                // Redirect to the login page after successful signup
                header("Location: login.php");
                exit();
            } else {
                // Display error message if query fails
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <style>
    /* Styling for the body and container */
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
      text-decoration: none;
      color: purple;
    }

    form {
      margin-right: 50px;
    }

    .signup-container {
      background-color: white;
      padding: 20px;
      border: 1px solid black;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 350px;
    }

    .signup-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: black;
    }

    .signup-container input[type="text"],
    .signup-container input[type="email"],
    .signup-container input[type="password"],
    .signup-container input[type="file"] {
      width: 100%; /* Full width for input fields */
      padding: 10px; /* Padding inside the input fields */
      margin: 10px; /* Margin around input fields */
      border: 1px solid black; /* Border for input fields */
      border-radius: 5px; /* Rounded corners for input fields */
      color: black; /* Text color inside input fields */
    }

    .signup-container input.error {
      border: 1px solid red; /* Field border turns red when there's an error */
    }

    .signup-container input::placeholder {
      color: #999; /* Placeholder color */
    }

    .signup-container input.error::placeholder {
      color: red; /* Placeholder color for error fields */
    }

    .signup-container button {
      width: 100%; /* Full width for button */
      padding: 10px; /* Padding inside the button */
      margin-top: 10px; /* Margin above the button */
      background-color: purple; /* Button background color */
      color: white; /* Button text color */
      border: none; /* No border for the button */
      border-radius: 10px; /* Rounded corners for button */
      cursor: pointer; /* Pointer cursor on hover */
      margin-left: 20px; /* Margin on the left of button */
      transition: transform 0.5s ease, background-color 0.5s ease; /* Transition effects */
    }

    .signup-container button:hover {
      transform: scale(1.05); /* Scale effect on hover */
    }

    .signup-container span.error-message {
      color: red; /* Error message color */
      font-size: 0.9em; /* Font size for error message */
      margin: 5px 0; /* Margin around error message */
      display: block; /* Display error message as a block */
      margin-left: 10px; /* Margin on the left of error message */
    }

    .signup-container p {
      text-align: center; /* Center text alignment for paragraph */
    }
  </style>
</head>
<body>

  <div class="signup-container">
    <h2>Sign Up</h2>

    <form action="signup.php" method="post" enctype="multipart/form-data">
      <!-- Name input field -->
      <input type="text" name="name" 
             class="<?php echo !empty($errors['name']) ? 'error' : ''; ?>" 
             placeholder="Name" 
             value="<?php echo htmlspecialchars($name); ?>">
      <?php if (!empty($errors['name'])): ?>
          <span class="error-message"><?php echo $errors['name']; ?></span>
      <?php endif; ?>

      <!-- Email input field -->
      <input type="email" name="email" 
             class="<?php echo !empty($errors['email']) ? 'error' : ''; ?>" 
             placeholder="Email" 
             value="<?php echo htmlspecialchars($email); ?>">
      <?php if (!empty($errors['email'])): ?>
          <span class="error-message"><?php echo $errors['email']; ?></span>
      <?php endif; ?>

      <!-- Password input field -->
      <input type="password" name="password" 
             class="<?php echo !empty($errors['password']) ? 'error' : ''; ?>" 
             placeholder="Password">
      <?php if (!empty($errors['password'])): ?>
          <span class="error-message"><?php echo $errors['password']; ?></span>
      <?php endif; ?>

      <!-- Confirm Password input field -->
      <input type="password" name="confirm_password" 
             class="<?php echo !empty($errors['confirm_password']) ? 'error' : ''; ?>" 
             placeholder="Confirm Password">
      <?php if (!empty($errors['confirm_password'])): ?>
        <span class="error-message"><?php echo $errors['confirm_password']; ?></span>
      <?php endif; ?>

      <!-- Passport upload input field -->
      <input type="file" name="passport" 
             class="<?php echo !empty($errors['passport']) ? 'error' : ''; ?>" 
             placeholder="Upload Passport">
      <?php if (!empty($errors['passport'])): ?>
          <span class="error-message"><?php echo $errors['passport']; ?></span>
      <?php endif; ?>

      <!-- Sign Up button -->
      <button type="submit" name="signup">Sign Up</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</body>
</html>