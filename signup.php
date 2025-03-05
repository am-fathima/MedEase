<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO patients (full_name, email, phone_number, password) VALUES (:full_name, :email, :phone_number, :password)");
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
        header("Location: login.php?signup=success");
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate email
            echo "Email already exists. Please try another.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
