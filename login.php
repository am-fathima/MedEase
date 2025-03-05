<?php
// Enable error reporting to catch any issues
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // Start the session

include 'db.php'; // Include the database connection file

// Initialize error message
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input values from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Get selected role

    try {
        if ($role === 'patient') {
            // Check login details in the patients table
            $stmt = $conn->prepare("SELECT id,  password FROM patients WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Fetch the patient data
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password and redirect to patient dashboard
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = 'patient';
                $_SESSION['fullname'] = $user['fullname']; // Store name for personalized greeting

                header("Location:  home.html");
                exit;
            } else {
                $errorMessage = "Invalid email or password.";
            }

        }elseif ($role === 'admin') {
       
            // Check login details in the admin table
            $stmt = $conn->prepare("SELECT id, name, password FROM admin WHERE name = :name");
            $stmt->bindParam(':name', $email); // Since admin logs in with 'name', not email
            $stmt->execute();

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

           // Directly compare passwords (since it's stored in plain text)
           if ($admin && $password === $admin['password']) {
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['role'] = 'admin';
            $_SESSION['fullname'] = $admin['name']; // Store admin name

                header("Location: admin view doctors.html");
                exit;
            } else {
                $errorMessage = "Invalid admin name or password.";
            }
        } else {
            $errorMessage = "Invalid role selected.";
        }
    } catch (PDOException $e) {
        // Catch any database errors
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedEase - Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="image-overlay"></div>
    <div class="content">
        <div class="login-container">
            <div class="login-box">
                <h1>MedEase</h1>
                <h2>Login to your Account</h2>
                <?php if ($errorMessage): ?>
                    <p class="error-message"><?= htmlspecialchars($errorMessage) ?></p>
                <?php endif; ?>
                <form action="login.php" method="POST">
                    <input type="text" name="email" placeholder="Enter Username / Email" required>
                    <input type="password" name="password" placeholder="Password" required>

                    <!-- Role Selection Dropdown -->
                    <select name="role" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="patient">Patient</option>
                        <option value="admin">Admin</option>
                    </select>

                    <a href="signup.html">Do not have an account? Register here</a>
                    <button type="submit">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
