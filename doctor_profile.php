<?php 
if (!isset($_GET['doctor_id'])) {
    header("Location: specialist.php");
    exit;
}

$doctor_id = $_GET['doctor_id'];

// Mock doctor details for demonstration
$doctors = [
    1 => ['name' => 'Dr. A', 'info' => 'Consultant Cardiologist with 10 years of experience'],
    2 => ['name' => 'Dr. B', 'info' => 'Senior Cardiologist specializing in Interventional Cardiology'],
    3 => ['name' => 'Dr. C', 'info' => 'Expert in Pediatric Cardiology'],
    4 => ['name' => 'Dr. D', 'info' => 'Renowned Cardiac Surgeon'],
    5 => ['name' => 'Dr. X', 'info' => 'Specialist in Preventive Cardiology'],
];

// Fetch doctor details based on ID and checks if the doctor id exist in the array
$doctor = $doctors[$doctor_id] ?? null;
if (!$doctor) {
    header("Location: specialist.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedEase - Doctor Booking</title>
    <link rel="stylesheet" href="doctor_profile.css"> <!-- Retaining CSS -->
</head>
<body>
    <div class="container">
        <div class="profile-section">
            <div class="profile-pic"></div>
            <div class="doctor-info">
                <h2><?php echo htmlspecialchars($doctor['name']); ?></h2>
                <p><?php echo htmlspecialchars($doctor['info']); ?></p>
            </div>
        </div>

        <div class="booking-section">
            <form action="bookingform.php" method="POST">
                <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                <input type="hidden" name="doctor_name" value="<?php echo htmlspecialchars($doctor['name']); ?>">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Next Available Number</th>
                            <th>Select</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>04-July-2024</td>
                            <td>Thursday 8:00 pm</td>
                            <td>1</td>
                            <td>
                                <input type="radio" name="slot" value="04-July-2024|Thursday 8:00 pm|1" required>
                            </td>
                            <td>Available</td>
                        </tr>
                        <tr>
                            <td>14-July-2024</td>
                            <td>Thursday 8:00 pm</td>
                            <td>0</td>
                            <td>
                                <input type="radio" name="slot" value="14-July-2024|Thursday 8:00 pm|0" required>
                            </td>
                            <td>Available</td>
                        </tr>
                        <tr>
                            <td>24-July-2024</td>
                            <td>Thursday 8:00 pm</td>
                            <td>2</td>
                            <td>
                                <input type="radio" name="slot" value="24-July-2024|Thursday 8:00 pm|2" required>
                            </td>
                            <td>Available</td>
                        </tr>
                        <tr>
                            <td>30-July-2024</td>
                            <td>Thursday 8:00 pm</td>
                            <td>1</td>
                            <td>
                                <input type="radio" name="slot" value="30-July-2024|Thursday 8:00 pm|1" required>
                            </td>
                            <td>Available</td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="book-btn">  Book Now </button>
            </form>
        </div>

        <div class="back-btn-section">
            <button class="back-btn"><a href="specialist.php">Go Back</a></button>
        </div>
    </div>
</body>
</html>
