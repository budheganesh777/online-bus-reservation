<?php
/* session_start();
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password1 = $_POST['password'];
    $conn = new mysqli('localhost', 'root', '', 'bus_reservation');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
           echo $password=$user['password'];
           echo"<br>";
           echo $password1;
        if ($password1==$password) {
            $_SESSION['user_id'] = $user['id'];
            header("Location:dashboard.php");
        } else {
            echo "Invalid password.";
            // echo "<script>alert('Invalid password.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "No user found with this email.";
        echo "<script>alert('No user found with this email.'); window.location.href='login.html';</script>";
    }
    $stmt->close();
    $conn->close();
 }*/
 ?>
 <?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'bus_reservation');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
        } else {
            echo "Invalid password.";
            echo "<script>alert('Invalid password.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "No user found with this email.";
        echo "<script>alert('No user found with this email.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>