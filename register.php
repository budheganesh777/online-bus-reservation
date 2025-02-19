<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $mobile_no=$_POST['mobile_no'];
    $conn = new mysqli('localhost', 'root', '', 'bus_reservation');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO users (name,email,password,Mobile_no) VALUES (?,?,?,?)");
    $stmt->bind_param("sssi",$name,$email,$password,$mobile_no);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    echo "<script>alert('Registration successful!'); window.location.href='login.html';</script>";
 }
 ?>