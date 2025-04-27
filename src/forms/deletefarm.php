<?php
session_start();
require_once __DIR__ . '/../../src/config/connection.php';

if (empty($_SESSION['userId']) || empty($_SESSION['farmId'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['farmId'])) {
    $farmId = $_POST['farmId'];

    $stmt = $mysqli->prepare("CALL DeleteFarm(?)");
    $stmt->bind_param("i", $farmId);

    if ($stmt->execute()) {

        header("Location: /Agritrack/src/pages/farms.php?status=deleted");
        exit();
    } else {
        echo "Error deleting farm.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
