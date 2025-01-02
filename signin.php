<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
        <h1>Login</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = htmlspecialchars(trim($_POST['email']));
            $password = htmlspecialchars(trim($_POST['password']));

            // Form validation
            if (empty($email) || empty($password)) {
                echo "<p class='error'>Please enter both email and password.</p>";
            } else {
                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'DeepTechDB');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        echo "<p>Login successful! <a href='index.html'>Go to Dashboard</a>.</p>";
                    } else {
                        echo "<p class='error'>Invalid password.</p>";
                    }
                } else {
                    echo "<p class='error'>No user found with this email.</p>";
                }

                $conn->close();
            }
        }
        ?>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
