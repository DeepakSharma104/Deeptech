<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2E073F;
            color: #EBD3F8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #7A1CAC;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: none;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #AD49E1;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .form-container button:hover {
            background-color: #9A38C1;
        }
        .error {
            color: #FF726F;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Register</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = htmlspecialchars(trim($_POST['name']));
            $email = htmlspecialchars(trim($_POST['email']));
            $password = htmlspecialchars(trim($_POST['password']));
            $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

            // Form validation
            $errors = [];
            if (empty($name)) $errors[] = "Name is required.";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
            if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
            if ($password !== $confirm_password) $errors[] = "Passwords do not match.";

            if (empty($errors)) {
                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'DeepTechDB');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

                if ($conn->query($sql) === TRUE) {
                    echo "<p>Registration successful! <a href='signin.php'>Login here</a>.</p>";
                } else {
                    echo "<p class='error'>Error: " . $conn->error . "</p>";
                }

                $conn->close();
            } else {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            }
        }
        ?>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
