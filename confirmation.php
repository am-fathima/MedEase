<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['appointment_id'])) {
    header("Location: confirmation.php");
    exit;
}

$appointment_id = $_SESSION['appointment_id'];
$sql = "SELECT * FROM appointments WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $appointment_id]);
$appointment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$appointment) {
    die("Appointment not found!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Confirmation</title>
</head>
<body>
    <h2>Thanks for Booking</h2>
    <p>Appointment ID: <?= htmlspecialchars($appointment['id']) ?></p>
    <p>Doctor Name: <?= htmlspecialchars($appointment['doctor_name']) ?></p>
    <p>Time: <?= htmlspecialchars($appointment['time']) ?></p>
    <p>Date: <?= htmlspecialchars($appointment['date']) ?></p>
    <a href="appointments.php">OK</a>
</body>
</html>

