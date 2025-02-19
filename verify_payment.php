<?php
$conn = new mysqli('localhost', 'root', '', 'bus_reservation');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transaction_id = $_POST['transaction_id'];
    $res_id = $_POST['res_id'];

    $sql = "UPDATE reservations SET payment_status='paid' WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $res_id);

    if ($stmt->execute()) {
        echo "<h2>Payment Verified! Your ticket is booked.</h2>";
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Online Bus Reservation</title>
        </head>
        <body>
        <nav>
            <div class="list">
           <button style="color: black;"><a href="index.html">Home</a></button>
           <button><a href="dashboard.php">dashboard</a></button>
           </div>
        </nav>
        </body>
        </html>
        <?php
    } else {
        echo "<h2>Payment Failed. Please try again.</h2>";
    }
}
?>