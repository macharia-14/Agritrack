<?php
session_start();
require_once __DIR__ . '/../../src/config/connection.php';

if (empty($_SESSION['userId']) || empty($_SESSION['farmId'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employeeId'])) {
    $employeeId = $_POST['employeeId'];

    $stmt = $mysqli->prepare("CALL DeleteEmployee(?)");
    $stmt->bind_param("i", $employeeId);

    if ($stmt->execute()) {

        header("Location: /Agritrack/src/pages/employees.php?status=deleted");
        exit();
    } else {
        echo "Error deleting employee.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
