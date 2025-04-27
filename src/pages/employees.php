<?php
session_start();

require_once __DIR__ . '/../../src/config/connection.php';

if (empty($_SESSION['userId'])) {
  header('Location: login.php');
  exit;
}


$sql = "SELECT * FROM employeeFarmView";
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
  <title>Employees - Agritrack</title>
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
        <a href="farms.php" class="nav-link">
          <i class="fas fa-building"></i>
          <span>Farms</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="employees.php" class="nav-link active">
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
        <input type="text" placeholder="Search Employees..." />
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
        <h2>Employees</h2>

        <div class="actions">
          <button
            class="btn btn-primary"
            onclick="window.location.href='../forms/addemployee.php'">
            <i class="fas fa-user-plus"></i> Add Employee
          </button>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3>Employee Directory</h3>
          <div class="card-actions">
            <button class="btn"><i class="fas fa-filter"></i> Filter</button>
          </div>
        </div>
        <div class="card-body">
          <div class="filter-row">
            <div class="filter-item">
              <label>Position:</label>
              <select>
                <option>All Positions</option>
                <option>Farm Manager</option>
                <option>Farm Hand</option>
                <option>Administrator</option>
                <option>Veterinarian</option>
                <option>Mechanic</option>
              </select>
            </div>
            <div class="filter-item">
              <label>Farm:</label>
              <select>
                <option>All Farms</option>
                <option>Green Valley Ranch</option>
                <option>Sunny Acres</option>
                <option>Rocky Top Farm</option>
                <option>Mountain View Dairy</option>
              </select>
            </div>

          </div>
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Position</th>

                <th>Contact</th>
                <th>Farm</th>
                <th>Farm Type</th>
                <th>Actions</th>

              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td>
                    <div style="display: flex; align-items: center">
                      <div
                        style="
                          width: 30px;
                          height: 30px;
                          background-color: #f0f0f0;
                          border-radius: 50%;
                          margin-right: 10px;
                          text-align: center;
                          line-height: 30px;
                        ">
                        <?php
                        // Initials based on first and last name
                        echo strtoupper(substr($row['firstName'], 0, 1) . substr($row['lastName'], 0, 1));
                        ?>
                      </div>
                      <div><?php echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']); ?></div>
                    </div>
                  </td>
                  <td><?php echo htmlspecialchars($row['role']); ?></td>

                  <td><?php echo htmlspecialchars($row['contact']); ?></td>
                  <td><?php echo htmlspecialchars($row['farmName']); ?></td>
                  <td><?php echo htmlspecialchars($row['farmType']); ?></td>

                  <td>
                    <button class="action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <form method="POST" action="../forms/deleteemployee.php" style="display: inline;">
                      <input type="hidden" name="employeeId" value="<?php echo $row['employeeId']; ?>">
                      <button type="submit" class="action-btn" onclick="return confirm('Are you sure you want to delete this employee?');">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>

                    
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script type="module" src="../main.ts"></script>
</body>

</html>