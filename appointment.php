<?php
require 'db_connection.php';

$sql = "SELECT * FROM appointments";
$stmt = $conn->query($sql);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Appointments</title>
</head>
<body>
    <h2>Your Appointments</h2>
    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Doctor Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Payment Method</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?= htmlspecialchars($appointment['id']) ?></td>
                    <td><?= htmlspecialchars($appointment['doctor_name']) ?></td>
                    <td><?= htmlspecialchars($appointment['date']) ?></td>
                    <td><?= htmlspecialchars($appointment['time']) ?></td>
                    <td><?= htmlspecialchars($appointment['payment_method']) ?></td>
                    <td><?= htmlspecialchars($appointment['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
