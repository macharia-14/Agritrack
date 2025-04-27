<?php
session_start();                        // ← Start the session!
require_once __DIR__ . '/../config/connection.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName  = trim($_POST['lastName']  ?? '');
    $userName  = trim($_POST['userName']  ?? '');
    $email     = trim($_POST['email']     ?? '');
    $contact   = trim($_POST['contact']   ?? '');
    $password  = $_POST['password']       ?? '';

    // 1) Basic validation
    if (
        empty($firstName) || empty($lastName) || empty($userName)
        || empty($email) || empty($contact) || empty($password)
    ) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if (!preg_match('/^\d{7,15}$/', $contact)) {
        $errors[] = "Contact must be a valid phone number (7–15 digits).";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // 2) Uniqueness checks
    if (empty($errors)) {
        $stmt = $mysqli->prepare(
            "SELECT userId 
               FROM users 
              WHERE userName = ? 
                 OR email    = ?"
        );
        $stmt->bind_param("ss", $userName, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Username or email already exists.";
        }
    }

    // 3) Insert new user
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare(
            "INSERT INTO users 
                (firstName, lastName, userName, email, contact, password, dateJoined)
             VALUES (?, ?, ?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param(
            "ssssss",
            $firstName,
            $lastName,
            $userName,
            $email,
            $contact,
            $password_hash
        );

        if ($stmt->execute()) {
            // ——— HERE’S THE KEY CHANGE ———
            // 4) Remember the new user’s ID in session:
            $_SESSION['userId'] = $mysqli->insert_id;

            // 5) Redirect to the “Add First Farm” form:
            header("Location: addfarm.php");
            exit();
        } else {
            $errors[] = "Error during registration. Please try again.";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Agritrack - Register</title>

</head>

<body>
    <div class="register-container">
        <div class="header">
            <img src="../assets/logo.png" alt="Agritrack Logo" class="logo">
            <h1>Join Agritrack</h1>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                ⚠️ <?= htmlspecialchars(implode('<br>', $errors)) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                ✅ <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <div class="input-wrapper">
                        <input type="text" id="firstName" name="firstName"
                            value="<?= htmlspecialchars($firstName ?? '') ?>" required>
                        <i class="input-icon fas fa-user"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <div class="input-wrapper">
                        <input type="text" id="lastName" name="lastName"
                            value="<?= htmlspecialchars($lastName ?? '') ?>" required>
                        <i class="input-icon fas fa-user"></i>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="userName">Username</label>
                <div class="input-wrapper">
                    <input type="text" id="userName" name="userName"
                        value="<?= htmlspecialchars($userName ?? '') ?>" required>
                    <i class="input-icon fas fa-at"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email"
                        value="<?= htmlspecialchars($email ?? '') ?>" required>
                    <i class="input-icon fas fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <div class="input-wrapper">
                    <input type="tel" id="contact" name="contact"
                        value="<?= htmlspecialchars($contact ?? '') ?>" required>
                    <i class="input-icon fas fa-phone"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required>
                    <i class="input-icon fas fa-lock"></i>
                    <i class="toggle-password fas fa-eye" onclick="togglePassword()"></i>
                </div>
                <div class="password-strength">
                    <div class="strength-bar" id="strengthBar"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-wrapper">
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <i class="input-icon fas fa-lock"></i>
                </div>
            </div>

            <button type="submit">
                <i class="fas fa-user-plus"></i>
                Create Account
            </button>
        </form>

        <div class="links">
            Already have an account? <a href="login.php">Sign in here</a><br>
            By registering, you agree to our <a href="#">Terms & Conditions</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function(e) {
            const strengthBar = document.getElementById('strengthBar');
            const strength = calculatePasswordStrength(e.target.value);
            strengthBar.style.width = strength + '%';
            strengthBar.style.background = getStrengthColor(strength);
        });

        function calculatePasswordStrength(password) {
            let strength = 0;
            if (password.match(/[A-Z]/)) strength += 20;
            if (password.match(/[a-z]/)) strength += 20;
            if (password.match(/[0-9]/)) strength += 20;
            if (password.match(/[^A-Za-z0-9]/)) strength += 20;
            if (password.length >= 8) strength += 20;
            return Math.min(strength, 100);
        }

        function getStrengthColor(strength) {
            if (strength < 40) return '#e74c3c';
            if (strength < 70) return '#f1c40f';
            return '#2ecc71';
        }
    </script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</body>

</html>