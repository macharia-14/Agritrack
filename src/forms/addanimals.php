<?php
require_once __DIR__ . '/../../src/config/connection.php';
session_start(); // Make sure to start session to access session variables

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if farmId is set in session
  if (!isset($_SESSION['farmId'])) {
    die("Farm ID not set in session. Cannot add animal.");
  }

  $farmId = $_SESSION['farmId'];
  $animalName = htmlspecialchars(trim($_POST['animalName']));
  $type = htmlspecialchars(trim($_POST['type']));
  $breed = htmlspecialchars(trim($_POST['breed']));
  $gender = htmlspecialchars(trim($_POST['gender']));
  $age = intval($_POST['age']);
  $status = htmlspecialchars(trim($_POST['status']));

  $farmId = $_SESSION['farmId'];

  // Now include farmId in the query
  $stmt = $mysqli->prepare("INSERT INTO animals (animalName, type, breed, gender, age, status, farmId) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssisi", $animalName, $type, $breed, $gender, $age, $status, $farmId);

  if ($stmt->execute()) {
    $success_message = "Animal record submitted successfully!";
    header('Location: /Agritrack/src/pages/animals.php');
    exit;
  } else {
    $error_message = "Error: " . $stmt->error;
  }

  $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Animal Registration - Farm Management System</title>
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

    .btn:hover {
      background-color: #4caf50;

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
      <h2>Animal Registration</h2>
      <form action="addanimals.php
        " method="POST">
        <div class="form-row">
          <div class="form-col">
            <div class="form-group">
              <label for="animalName">Animal Name*</label>
              <input type="text" id="animalName" name="animalName" required />
            </div>
          </div>
          <div class="form-col">
            <div class="form-group">
              <label for="type">Animal Type*</label>
              <select id="type" name="type" required>
                <option value="" disabled selected>Select animal type</option>
                <option value="Cattle">Cattle</option>
                <option value="Sheep">Sheep</option>
                <option value="Goat">Goat</option>
                <option value="Pig">Pig</option>
                <option value="Chicken">Chicken</option>
                <option value="Horse">Horse</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-col">
            <div class="form-group">
              <label for="breed">Breed*</label>
              <input type="text" id="breed" name="breed" required />
            </div>
          </div>
          <div class="form-col">
            <div class="form-group">
              <label for="gender">Gender*</label>
              <select id="gender" name="gender" required>
                <option value="" disabled selected>Select gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-col">
            <div class="form-group">
              <label for="age">Age (months)*</label>
              <input type="number" id="age" name="age" min="0" required />
            </div>
          </div>
          <div class="form-col">
            <div class="form-group">
              <label for="status">Status*</label>
              <select id="status" name="status" required>
                <option value="" disabled selected>Select status</option>
                <option value="Healthy">Healthy</option>
                <option value="Sick">Sick</option>
                <option value="Pregnant">Pregnant</option>
                <option value="Quarantined">Quarantined</option>
                <option value="Treated">Under Treatment</option>
              </select>
            </div>
          </div>
        </div>

        <button type="submit" class="btn">Submit Animal Record</button>
        <a href="/Agritrack/src/pages/farms.php" class="back-button">

          Back
        </a>
      </form>
    </div>
  </div>
</body>

</html>