<!DOCTYPE html>
<html>
<head>
    <title>UPI Payment</title>
</head>
<body>
     <?php
     session_start();
     if (!isset($_SESSION['schedule_id'])) {
      header("Location: dashboard.php");
      exit();
     }
     $schedule_id = $_SESSION['schedule_id'];
     $conn = new mysqli('localhost', 'root','', 'bus_reservation');
       $print="SELECT * FROM `bus_schedules` WHERE id=?";
       $stmt = $conn->prepare($print);
       $stmt->bind_param("i",$schedule_id);
       $stmt->execute();
       $result = $stmt->get_result();
      //  $result=mysqli_query($conn,$print);
      //  $schedule_id = $_GET['schedule_id'];
       if(!$result->num_rows > 0){
         echo "<p style='color:red;'>Connection _fail...</p>";
       }
       if($row=mysqli_fetch_assoc($result)){
             $price=$row['price'];
             $bus_number=$row['bus_number'];
       }
     ?>
    <h2>Scan & Pay via UPI</h2>
    <img src="GooglePay_QR.png" alt="Scan to Pay" width="300">
    <p>UPI ID: ganeshbudhe2022@okhdfcbank</p>
    <?php
         echo "Amount:₹$price";
    ?>
    <form action="verify_payment.php" method="POST">
        <label>Enter Transaction ID:</label>
        <input type="text" name="transaction_id" required>
        <input type="hidden" name="res_id" value="<?php echo $_GET['res_id']; ?>">
        <button type="submit">Verify Payment</button>
    </form>
</body>
</html>