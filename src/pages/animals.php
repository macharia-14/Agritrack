<?php
session_start();
require_once __DIR__ . '/../../src/config/connection.php';

$animals = [];
if ($stmt = $mysqli->prepare("SELECT animalId,animalName,breed, type, gender, age,  status FROM animals")) {
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $animals[] = $row;
  }
  $stmt->close();
} else {
  die("Database error: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Livestock - Agritrack</title>
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
        <a href="employees.php" class="nav-link">
          <i class="fas fa-users"></i>
          <span>Employees</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="animals.php" class="nav-link active">
          <i class="fas fa-cow"></i>
          <span>Animals</span>
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
        <input type="text" placeholder="Search Livestock..." />
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
        <h2>Livestock</h2>
        <div class="actions">
          <button
            class="btn btn-primary"
            onclick="window.location.href='../forms/addanimals.php'">
            <i class="fas fa-plus"></i> Add Animal
          </button>
        </div>
      </div>
      <div class="animal-stats">
        <div class="stat-card">
          <h3>4,861</h3>
          <p>Total Animals</p>
          <span class="subtext">100% of 4,861</span>
        </div>
        <div class="stat-card">
          <h3>2,109</h3>
          <p>Chicken Layer</p>

        </div>
        <div class="stat-card">
          <h3>2,000</h3>
          <p>Bees</p>

        </div>
        <div class="stat-card">
          <h3>369</h3>
          <p>Other</p>

        </div>
        <div class="stat-card">
          <h3>250</h3>
          <p>Pigs</p>

        </div>
        <div class="stat-card">
          <h3>133</h3>
          <p>Other</p>

        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3>Animal List</h3>
          <div class="card-actions">
            <button class="btn"><i class="fas fa-filter"></i> Filter</button>
          </div>
        </div>
        <div class="card-body">
          <div class="filter-row">
            <div class="filter-item">
              <label>Status:</label>
              <select>
                <option>Active or Sold or Lactating</option>
                <option>Active</option>
                <option>Under treatment</option>
                <option>Lactating</option>
                <option>Sold</option>
                <option>Pregnant</option>
              </select>
            </div>
            <div class="filter-item">
              <label>Animal Types:</label>
              <select>
                <option>All</option>
                <option>Cattle</option>
                <option>Chicken</option>
                <option>Sheep</option>
                <option>Goat</option>
                <option>Pig</option>
                <option>Fish</option>
                <option>Bee</option>
              </select>
            </div>
          </div>
          <table>
            <thead>
              <tr>

                <th>ID</th>
                <th>Animal</th>
                <th>Species</th>
                <th>Breed</th>
                <th>Gender</th>
                <th>Age</th>

                <th>Status</th>

                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($animals as $animal): ?>
                <tr>
                  <td><?php echo htmlspecialchars($animal['animalId']); ?></td>
                  <td><?php echo htmlspecialchars($animal['animalName']); ?></td>
                  <td><?php echo htmlspecialchars($animal['type']); ?></td>
                  <td><?php echo htmlspecialchars($animal['breed']); ?></td>
                  <td><?php echo htmlspecialchars($animal['gender']); ?></td>
                  <td><?php echo htmlspecialchars($animal['age']); ?></td>

                  <td><?php echo htmlspecialchars($animal['status']); ?></td>


                  <td>
                    <button class="action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <form method="POST" action="../forms/deleteanimal.php" style="display: inline;">
                      <input type="hidden" name="animalId" value="<?php echo htmlspecialchars($animal['animalId']); ?>">

                      <button type="submit" class="action-btn" onclick="return confirm('Are you sure you want to remove this animal?');">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                </tr>

                </td>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script type="module" src="../main.ts"></script>
</body>

</html>