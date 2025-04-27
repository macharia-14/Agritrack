<?php
session_start();
require_once __DIR__ . '/../../src/config/connection.php';

$sql = "SELECT * FROM farmview";
$result = $mysqli->query($sql);

if (!$result) {
  die("Database error: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Farms - Agritrack</title>
  <link rel="stylesheet" href="../style.css?v=1.0" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
  <div class="sidebar">
    <div class="sidebar-header">
      <img src="../assets/logo.png" alt="Agritrack Logo" />
      <h1>Agritrack</h1>
    </div>
    <ul class="nav-menu">
      <li class="nav-item">
        <a href="../../index.php" class="nav-link">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="farms.php" class="nav-link active">
          <i class="fas fa-building"></i>
          <span>Farms</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="employees.php" class="nav-link">
          <i class="fas fa-users"></i>
          <span>Employees</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="animals.php" class="nav-link">
          <i class="fas fa-cow"></i>
          <span>Livestock</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="health.html" class="nav-link">
          <i class="fas fa-file-medical"></i>
          <span>Health Records</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="feeding.html" class="nav-link">
          <i class="fas fa-wheat-awn"></i>
          <span>Feeding Records</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="breeding.html" class="nav-link">
          <i class="fas fa-baby"></i>
          <span>Breeding</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="sales.html" class="nav-link">
          <i class="fas fa-dollar-sign"></i>
          <span>Sales</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="suppliers.html" class="nav-link">
          <i class="fas fa-truck"></i>
          <span>Suppliers</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="crops.html" class="nav-link">
          <i class="fas fa-seedling"></i>
          <span>Crops</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="equipment.html" class="nav-link">
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
        <input type="text" placeholder="Search Farms..." />
      </div>
      <div class="header-actions">
        <div class="dropdown">
          <div class="dropdown-toggle">
            <img src="../assets/user.png" alt="User" />
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
    </div>

    <div class="content">
      <div class="page-title">
        <h2>Farms</h2>
        <button
          class="btn btn-primary"
          onclick="window.location.href='../forms/addfarm.php'">
          <i class="fas fa-user-plus"></i> Add Farm
        </button>
      </div>

      <div class="card">
        <div class="card-header">
          <h3>Farms List</h3>
          <div class="card-actions">
            <button class="btn"><i class="fas fa-filter"></i> Filter</button>
          </div>
        </div>
        <div class="card-body">
          <table>
            <thead>
              <tr>
                <th>Farm Name</th>
                <th>Location</th>
                <th>Size (acres)</th>
                <th>Livestock Count</th>
                <th>Farm Type</th>
                <th>Manager</th>
                <th>Contact</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>




                  <td><?php echo htmlspecialchars($row['farmName']); ?></td>
                  <td><?php echo htmlspecialchars($row['location']); ?></td>
                  <td><?php echo htmlspecialchars($row['totalArea']); ?></td>
                  <td><?php echo htmlspecialchars($row['animalCount']); ?></td>
                  <td><?php echo htmlspecialchars($row['farmType']); ?></td>
                  <td><?php echo htmlspecialchars($row['farmManager']); ?></td>
                  <td><?php echo htmlspecialchars($row['Contact']); ?></td>



                  <td>
                    <button class="action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <form method="POST" action="../forms/deletefarm.php" style="display: inline;">
                      <input type="hidden" name="farmId" value="<?php echo isset($row['farmId']) ? htmlspecialchars($row['farmId']) : ''; ?>">
                      <button type="submit" class="action-btn" onclick="return confirm('Are you sure you want to delete this farms?');">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>


                  </td>
                </tr>
              <?php endwhile; ?>
              <tr>
                <td>Green Valley Ranch</td>
                <td>Boulder, CO</td>
                <td>520</td>
                <td>156</td>
                <td>Corn, Wheat</td>
                <td>John Smith</td>
                <td>
                  <button class="action-btn">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="action-btn">
                    <i class="fas fa-trash"></i>
                  </button>
                  <button class="action-btn">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3>Farm Overview</h3>
        </div>
        <div class="card-body">
          <div class="animal-stats">
            <div class="stat-card">
              <h3>4</h3>
              <p>Total Farms</p>
            </div>
            <div class="stat-card">
              <h3>2,055</h3>
              <p>Total Acres</p>
            </div>
            <div class="stat-card">
              <h3>768</h3>
              <p>Total Livestock</p>
            </div>
            <div class="stat-card">
              <h3>3</h3>
              <p>Crop Types</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="module" src="main.ts"></script>
</body>

</html>