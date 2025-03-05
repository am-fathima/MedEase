<?php
session_start();
include 'db.php'; 
 
// Check if the user is logged in (user_id should be stored in the session)
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Retrieve user_id from session
$user_id = $_SESSION['user_id'];

// Fetch appointments for the logged-in user
try {
    $stmt = $conn->prepare("
        SELECT id, doctor_id, appointment_date AS date, appointment_time AS time, 
               payment_method, queue_number, status
        FROM appointments 
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="appointments.css"> <!-- Your CSS file -->
</head>
<body>
    <div class="container">
        <h2>My Appointment Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Doctor Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Queue Number</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
                    // Sample array of doctors for demonstration
                    $doctors = [
                        ['id' => 1, 'name' => 'Dr. A', 'specialization' => 'Cardiologist'],
                        ['id' => 2, 'name' => 'Dr. B', 'specialization' => 'Cardiologist'],
                        ['id' => 3, 'name' => 'Dr. C', 'specialization' => 'Cardiologist'],
                        ['id' => 4, 'name' => 'Dr. D', 'specialization' => 'Cardiologist'],
                        ['id' => 5, 'name' => 'Dr. X', 'specialization' => 'Cardiologist'],
                    ]; ?>

                <?php if (count($appointments) > 0): ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?= htmlspecialchars($appointment['id']) ?></td>
                            <td><?php
                                  $doctorName = 'Unknown'; // Default value if no match is found
                                    foreach ($doctors as $doctor) {
                                          if ($doctor['id'] == $appointment['doctor_id']) {
                                                $doctorName = $doctor['name'];
                                                break;
                                         }
                                    }
                                   echo htmlspecialchars($doctorName);
                            ?></td>
                            <td><?= htmlspecialchars($appointment['date']) ?></td>
                            <td><?= htmlspecialchars($appointment['time']) ?></td>
                            <td><?= htmlspecialchars($appointment['queue_number']) ?></td>
                            <td><?= htmlspecialchars($appointment['payment_method']) ?></td>
                            <td><?= htmlspecialchars($appointment['status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No appointments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
