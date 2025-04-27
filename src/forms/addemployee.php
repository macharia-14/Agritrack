<?php
session_start();
require_once __DIR__ . '/../../src/config/connection.php';

if (empty($_SESSION['userId']) || empty($_SESSION['farmId'])) {
  header('Location: login.php');
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $firstName = htmlspecialchars(trim($_POST['firstName']));
  $lastName = htmlspecialchars(trim($_POST['lastName']));
  $role = htmlspecialchars(trim($_POST['role']));
  $salary = intval($_POST['salary']);
  $contact = intval($_POST['contact']);

  $farmId = $_SESSION['farmId'];

  $stmt = $mysqli->prepare("INSERT INTO employees (firstName, lastName, role,salary,contact, farmId)VALUES(?,?,?,?,?,?)");
  $stmt->bind_param("sssiii", $firstName, $lastName, $role, $salary, $contact, $farmId);

  if ($stmt->execute()) {
    $success_message = "New employee record submitted successfully!";
    header('Location: /Agritrack/src/pages/employees.php');
    exit;
  } else {
    $error_message = "Error:" . $stmt->error;
  }

  $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Employee Registration - Farm Management System</title>
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
      <h2>Employee Registration</h2>
      <form action="addemployee.php" method="POST">
        <div class="form-row">
          <div class="form-col">
            <div class="form-group">
              <label for="firstName">First Name*</label>
              <input type="text" id="firstName" name="firstName" required />
            </div>
          </div>
          <div class="form-col">
            <div class="form-group">
              <label for="lastName">Last Name*</label>
              <input type="text" id="lastName" name="lastName" required />
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-col">
            <div class="form-group">
              <label for="role">Role*</label>
              <select id="role" name="role" required>
                <option value="" disabled selected>Select role</option>
                <option value="Manager">Farm Manager</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Laborer">Farm Laborer</option>
                <option value="Veterinarian">Veterinarian</option>
                <option value="Technician">Technician</option>
                <option value="Admin">Administrative Staff</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>
          <div class="form-col">
            <div class="form-group">
              <label for="salary">Salary (Ksh)*</label>
              <input
                type="number"
                id="salary"
                name="salary"
                min="0"
                step="1000"
                required />
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="contact">Contact Number*</label>
          <input
            type="tel"
            id="contact"
            name="contact"
            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
            placeholder="123-456-7890"
            required />
          <small>Format: 123-456-7890</small>
        </div>

        <button type="submit" class="btn">Submit Employee Record</button>
        <a href="/Agritrack/src/pages/employees.php" class="back-button">

          Back
        </a>
      </form>
    </div>
  </div>
</body>

</html>