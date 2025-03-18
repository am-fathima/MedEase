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
    <link rel="stylesheet" href="appointment.css">  
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
                    <th> Join</th>
                    <th> Cancel </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Sample array of doctors for demonstration
                    $doctors = [
                        ['id' => 1, 'name' => 'Dr. John Doe', 'specialization' => 'Cardiologist'],
                        ['id' => 2, 'name' => 'Dr. Jane Smith', 'specialization' => 'Cardiologist'],
                        ['id' => 3, 'name' => 'Dr. Robert Brown', 'specialization' => 'Cardiologist'],
                        ['id' => 4, 'name' => 'Dr. Silva', 'specialization' => 'Cardiologist'],
                        ['id' => 5, 'name' => 'Dr. Perera', 'specialization' => 'Cardiologist'],
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
                            <td><button type="submit" class="join-btn">Join</button> </td>
                            <td><button type="submit" class="cancel-btn">Cancel</button> </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?> <br><br>
                    <tr>
                        <td colspan="7">No appointments found.</td>
                    </tr>
                <?php endif; ?>
                <div class="back-btn-section">
            <button class="back-btn"><a href="home.html">HOME</a></button>
                 </div>
            </tbody>
        </table>
    </div>
</body>
</html>
