<?php
session_start();
include 'db.php';   

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

$user_id = $_SESSION['user_id'];

$doctor_id = $_GET['doctor_id'] ?? $_POST['doctor_id'] ?? null;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data safely
    $doctor_id = $_POST['doctor_id'] ?? null;
    $name = $_POST['name'] ?? null;
    $mobile = $_POST['mobile'] ?? null;
    $email = $_POST['email'] ?? null;
    $nic = $_POST['nic'] ?? null;
    $payment_method = $_POST['payment-method'] ?? null;
    $slot  = $_POST['slot'] ?? null;

    // Check if all required data is available
    if ($doctor_id && $name && $mobile && $email && $nic && $payment_method && $slot) {
         
         // Validate and extract date, time, and queue number
        $slot_data = explode('|', $slot);
        if (count($slot_data) === 3) {
            $date = trim($slot_data[0]); // Date
            $time = trim($slot_data[1]); // Time
            $queue_number = trim($slot_data[2]); // Queue number
        } else {
            echo "Invalid slot format.";
            exit;
        }

        try {
            // Insert appointment into the database
            if (!empty($date) && !empty($time)) {
                // Insert appointment with the logged-in `user_id`
                $stmt = $conn->prepare("
                    INSERT INTO appointments (user_id, doctor_id, user_name, mobile, email, nic, payment_method, appointment_date, appointment_time, queue_number) 
                    VALUES (:user_id, :doctor_id, :name, :mobile, :email, :nic, :payment_method, :date, :time, :queue_number)
                ");
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Store appointment for logged-in user
                $stmt->bindParam(':doctor_id', $doctor_id);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':mobile', $mobile);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':nic', $nic);
                $stmt->bindParam(':payment_method', $payment_method);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':time', $time);
                $stmt->bindParam(':queue_number', $queue_number);
                $stmt->execute();


            // Redirect to the payment page
            header("Location: payment.html?status=success");
            exit;
            }else{
                echo "date or time missing";
                exit;
            }
        } catch (PDOException $e) {
            echo " databse Error: " . $e->getMessage();
        }
    } 
}
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedEase - Appointment Form</title>
    <link rel="stylesheet" href="bookingform.css"> <!-- Retaining your CSS -->
</head>
<body>
    <div class="container">
        <div class="profile-section">
            <div class="profile-pic"></div>
            <div class="doctor-info">
                <h2>
       
                    <?php echo htmlspecialchars($_POST['doctor_name'] ?? 'Dr. Unknown'); ?></h2>
                <p>Cardiologist</p>
            </div>
        </div>

        <form class="appointment-form" action="bookingform.php" method="POST">
            <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($_POST['doctor_id'] ?? ''); ?>">
            <input type="hidden" name="slot" value="<?php echo htmlspecialchars($_POST['slot'] ?? ''); ?>">

            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="mobile">Mobile</label>
            <input type="text" id="mobile" name="mobile" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="nic">NIC</label>
            <input type="text" id="nic" name="nic" required>

            <label for="payment-method">Payment Method:</label>
            <select id="payment-method" name="payment-method" required>
                <option value="credit-card">Credit Card</option>
                <option value="debit-card">Debit Card</option>
                <option value="paypal">PayPal</option>
            </select>

            <div class="form-buttons">
                <button type="button" class="back-btn"><a href="doctor_profile.php">Go back</a></button>
                <button type="submit" class="submit-btn">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>

 