<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data and sanitize it
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate form fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = "All fields are required.";
    } else {
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'DeepTechDB');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            $success_message = "Thank you for contacting us! We will get back to you soon.";
        } else {
            $error_message = "Error: Could not submit the form. Please try again later.";
        }
    
        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2E073F; /* Dark Purple */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #EBD3F8; /* Light Purple */
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #2E073F; /* Dark Purple */
        }

        .form-container input, 
        .form-container select, 
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid #AD49E1; /* Medium Purple */
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #7A1CAC; /* Bright Purple */
            color: white;
            font-size: 1rem;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #5E0A8A; /* Darker shade for hover effect */
        }

        .success {
            color: green;
            font-size: 1rem;
            text-align: center;
        }

        .error {
            color: red;
            font-size: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Contact Us</h1>

        <!-- Display success or error message -->
        <?php if (isset($success_message)) { ?>
            <p class="success"><?php echo $success_message; ?></p>
            <script>
                // Redirect to index.html after 5 seconds
                setTimeout(function() {
                    window.location.href = 'index.html';
                }, 5000);
            </script>
        <?php } elseif (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
    </div>
</body>
</html>