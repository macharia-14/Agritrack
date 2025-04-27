<?php
session_start();
require_once __DIR__ . '/../../src/config/connection.php';

// 1) Ensure the user is logged in
if (empty($_SESSION['userId'])) {
    header('Location: /Agritrack/src/forms/login.php');
    exit;
}

$success_message = '';
$error_message   = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 2) Grab & sanitize inputs
    $farmName  = htmlspecialchars(trim($_POST['farmName']   ?? ''));
    $location  = htmlspecialchars(trim($_POST['location']   ?? ''));
    $farmType  = htmlspecialchars(trim($_POST['farmType']   ?? ''));
    $totalArea = trim($_POST['totalArea'] ?? '');


    if (empty($errors)) {
        // 3) Prepare INSERT including userId
        $sql = "INSERT INTO farms 
                   (userId, farmName, location, farmType, totalArea)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $userId = (int) $_SESSION['userId'];
        $ta     = (float) $totalArea;           // ensure float for DECIMAL
        $stmt->bind_param(
            "isssd",
            $userId,
            $farmName,
            $location,
            $farmType,
            $ta
        );

        if ($stmt->execute()) {
            $success_message = "New farm record submitted successfully!";
            // 4) Remember the current farm in session
            $_SESSION['farmId'] = $mysqli->insert_id;

            // 5) Redirect to dashboard (or wherever)
            header('Location: /Agritrack/src/pages/farms.php');
            exit;
        } else {
            $error_message = "Database error: " . htmlspecialchars($stmt->error);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Registration - Farm Management System</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            margin-bottom: 30px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 10px;
        }

        .navigation {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .nav-link {
            display: inline-block;
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .nav-link:hover {
            background-color: #2980b9;
        }

        .nav-link.active {
            background-color: #2c3e50;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2c3e50;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .btn {
            background-color: #3e8e41;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .back-button:hover {
            background: #4caf50;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .form-col {
            flex: 1;
            padding: 0 10px;
            min-width: 250px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            padding: 0.8rem 1.2rem;
            background-color: #3e8e41;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            float: right;
        }

        .back-button:hover {
            background: #4caf50;
        }


        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }

            .form-col {
                margin-bottom: 15px;
            }

            .navigation {
                flex-direction: column;
                gap: 10px;
            }

            .nav-link {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <?php if (isset($success_message)): ?>
        <p class="success"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <div class="container">
        <header>
            <h1>Farm Management System</h1>

        </header>

        <div class="form-container">
            <h2>Farm Registration</h2>
            <form action="addfarm.php" method="POST">
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="farmName">Farm Name*</label>
                            <input type="text" id="farmName" name="farmName" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="location">Location*</label>
                            <input type="text" id="location" name="location" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="totalArea">Total Area (acres)*</label>
                            <input type="number" id="totalArea" name="totalArea" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label for="farmType">Farm Type*</label>
                            <select id="farmType" name="farmType" required>
                                <option value="" disabled selected>Select farm type</option>
                                <option value="Dairy">Dairy</option>
                                <option value="Livestock">Livestock</option>
                                <option value="Crop">Crop</option>
                                <option value="Mixed">Mixed</option>
                                <option value="Poultry">Poultry</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn">Submit Farm Record</button>
                <a href="/Agritrack/src/pages/farms.php" class="back-button">

                    Back
                </a>
            </form>
        </div>
    </div>
</body>

</html>