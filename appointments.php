<?php
session_start();/*
session_start();
include 'db.php'; // Include database connection

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch appointment data for the logged-in user
try {
    $stmt = $conn->prepare("
        SELECT 
            appointments.id AS appointment_id, 
            doctors.name AS doctor_name, 
            appointments.appointment_date, 
            appointments.appointment_time 
        FROM appointments 
        INNER JOIN doctors ON appointments.doctor_id = doctors.id
        WHERE appointments.user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching appointments: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="appointment.css">
</head>
<body>
    <div class="container">
        <h1>My Appointments</h1>
        <?php if ($appointments): ?>
            <table>
                <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Doctor Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['appointment_id']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                            <td>
                                <!-- Reschedule Button -->
                                <form action="reschedule.php" method="GET">
                                    <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['appointment_id']); ?>">
                                    <button type="submit" class="update-btn">Reschedule</button>
                                </form>
                                
                                <!-- Cancel Appointment Button -->
                                <form action="cancel_appointment.php" method="POST" style="margin-top: 5px;">
                                    <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['appointment_id']); ?>">
                                    <button type="submit" class="cancel-btn">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no appointments scheduled.</p>
        <?php endif; ?>
    </div>
</body>
</html>*/
 

include 'db.php'; // Include database connection

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location:   confirmation.html");
    exit;
}

// Fetch appointment data for the logged-in user
try {
    $stmt = $conn->prepare("
        SELECT 
            appointments.id AS appointment_id, 
            doctors.name AS doctor_name, 
            appointments.appointment_date, 
            appointments.appointment_time 
        FROM appointments 
        INNER JOIN doctors ON appointments.doctor_id = doctors.id
        WHERE appointments.user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching appointments: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="appointment.css">
</head>
<body>
    <div class="container">
        <h1>My Appointments</h1>
        <?php if ($appointments): ?>
            <table>
                <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Doctor Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['appointment_id']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                            <td>
                                <!-- Reschedule Button -->
                                <form action="reschedule.php" method="GET">
                                    <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['appointment_id']); ?>">
                                    <button type="submit" class="update-btn">Reschedule</button>
                                </form>
                                
                                <!-- Cancel Appointment Button -->
                                <form action="cancel_appointment.php" method="POST" style="margin-top: 5px;">
                                    <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['appointment_id']); ?>">
                                    <button type="submit" class="cancel-btn">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no appointments scheduled.</p>
        <?php endif; ?>
    </div>
</body>
</html>

