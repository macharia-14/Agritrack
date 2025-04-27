<?php
session_start();
// You can now access $_SESSION['userId'], $_SESSION['farmId'], etc.
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agritrack - Farm Management System</title>
  <link rel="stylesheet" href="src/style.css?v=1.0" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
  <div class="sidebar">
    <div class="sidebar-header">
      <img src="src/assets/logo.png" alt="Agritrack Logo" />
      <h1>Agritrack</h1>
    </div>
    <ul class="nav-menu">
      <li class="nav-item">
        <a href="index.php" class="nav-link active">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="src/pages/farms.php" class="nav-link">
          <i class="fas fa-building"></i>
          <span>Farms</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="src/pages/employees.php" class="nav-link">
          <i class="fas fa-users"></i>
          <span>Employees</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="src/pages/animals.php" class="nav-link">
          <i class="fas fa-cow"></i>
          <span>Animals</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="src/pages/health.html" class="nav-link">
          <i class="fas fa-file-medical"></i>
          <span>Health Records</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="src/pages/feeding.html" class="nav-link">
          <i class="fas fa-wheat-awn"></i>
          <span>Feed Records</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="src/pages/breeding.html" class="nav-link">
          <i class="fas fa-baby"></i>
          <span>Breeding Records</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="src/pages/sales.html" class="nav-link">
          <i class="fas fa-dollar-sign"></i>
          <span>Sales</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="src/pages/suppliers.html" class="nav-link">
          <i class="fas fa-truck"></i>
          <span>Suppliers</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="src/pages/crops.html" class="nav-link">
          <i class="fas fa-seedling"></i>
          <span>Crops</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="src/pages/equipment.html" class="nav-link">
          <i class="fas fa-tractor"></i>
          <span>Equipment</span>
        </a>
      </li>
    </ul>
  </div>
  <div class="main-content">
    <div class="header">
      <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search..." />
      </div>
      <div class="header-actions"></div>
      <div class="dropdown">
        <div class="dropdown-toggle">
          <img src="src/assets/user.png" alt="User" />
          <span>
            <?php
            if (isset($_SESSION['firstName'], $_SESSION['lastName'])) {
              echo htmlspecialchars($_SESSION['firstName'] . ' ' . $_SESSION['lastName']);
            } else {
              echo 'Guest';
            }
            ?>
          </span>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="page-title">
        <h2>Dashboard</h2>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3>Farm Overview</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h4>Welcome to Agritrack!</h4>
            <p>
              Your comprehensive farm management solution. Use the navigation
              menu on the left to access different sections of the
              application.
            </p>
            <p>Here are some quick statistics:</p>
            <div class="animal-stats">
              <div class="stat-card">
                <h3>4</h3>
                <p>Farms</p>
              </div>
              <div class="stat-card">
                <h3>256</h3>
                <p>Total animals</p>
              </div>
              <div class="stat-card">
                <h3>6</h3>
                <p>Employees</p>
              </div>
              <div class="stat-card">
                <h3>3</h3>
                <p>Crops</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3>Recent Activities</h3>
      </div>
      <div class="card-body">
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Activity</th>
              <th>User</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>2025-03-21</td>
              <td>Added Animals</td>
              <td>Elic Macharia</td>
              <td>Added 5 new animals</td>
            </tr>
            <tr>
              <td>2025-03-19</td>
              <td>Updated health records</td>
              <td>Elic Macharia</td>
              <td>Vaccination completed for 10 animals</td>
            </tr>
            <tr>
              <td>2025-03-15</td>
              <td>New Employee</td>
              <td>Elic Macharia</td>
              <td>Added Richard Mawin as farm hand</td>
            </tr>
            <tr>
              <td>2025-02-03</td>
              <td>Sales Record</td>
              <td>Elic Macharia</td>
              <td>Sold 2 bulls for ksh 160,000</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script type="module" src="main.ts"></script>
</body>

</html>