<?php
require_once __DIR__ . '/../config/connection.php';  // Ensure the connection file path is correct

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the form
    $username = trim($_POST['userName']);  // Assuming 'userName' is the correct field name in the form
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = 'Username and password are required.';
    } else {
        // Prepare SQL statement to prevent SQL injection
        $sql = "SELECT userId, password FROM users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $username);  // Binding the username parameter to prevent SQL injection
            $stmt->execute();
            $result = $stmt->get_result();

            $_SESSION['userId'] = $user['userId'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];

            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();

                // Verify the password
                if (password_verify($password, $user['password'])) {

                    $_SESSION['userName'] = $user['userName'];
                    $_SESSION['userId'] = $user['userId'];
                    header("Location: /Agritrack/index.php");  // Redirect to the homepage
                    exit;
                } else {
                    $error = 'Invalid password.';
                }
            } else {
                $error = 'User not found.';
            }

            $stmt->close();
        } else {
            $error = 'Error preparing the SQL statement.';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AgriTrack Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="register-container">
        <div class="header">
            <img src="../assets/logo.png" alt="AgriTrack Logo" class="logo">
            <h1>Login</h1>
        </div>

        <!-- Alert placeholder -->
        <!-- Example: <div class="alert alert-error"><span>Invalid login credentials</span></div> -->

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="userName">Username</label>
                <div class="input-wrapper">
                    <span class="input-icon">&#128100;</span>
                    <input type="text" id="userName" name="userName" placeholder="Enter username" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">&#128274;</span>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="links">
            <p>Don't have an account? <a href="registration.php">Register here</a></p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const toggleIcon = document.querySelector(".toggle-password");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.textContent = "🙈";
            } else {
                passwordField.type = "password";
                toggleIcon.textContent = "👁️";
            }
        }
    </script>

</body>

</html>