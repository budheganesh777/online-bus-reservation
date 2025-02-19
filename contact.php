<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $to = "ganeshbudhe2022@gmail.com";  // Replace with your admin email
    $subject = "New Contact Form Submission from " . $name;
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";

    $fullMessage = "Name: $name\n";
    $fullMessage .= "Email: $email\n";
    $fullMessage .= "Message:\n$message\n";

    if (!mail($to, $subject, $fullMessage, $headers)) {
        echo "<script>alert('Your message has been sent successfully!'); window.location.href='contact_us.html';</script>";
    } else {
        echo "<script>alert('Failed to send message. Please try again later.'); window.location.href='contact_us.html';</script>";
      }
}
?>