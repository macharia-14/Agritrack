<?php
session_start();
require_once __DIR__ . '/../../src/config/connection.php';

if (empty($_SESSION['userId']) || empty($_SESSION['farmId'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['animalId'])) {
    $animalId = $_POST['animalId'];

    $stmt = $mysqli->prepare("CALL DeleteAnimal(?)");
    $stmt->bind_param("i", $animalId);

    if ($stmt->execute()) {

        header("Location: /Agritrack/src/pages/animals.php?status=deleted");
        exit();
    } else {
        echo "Error removing animal.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
