<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli('localhost', 'root','', 'bus_reservation');
$user_id = $_SESSION['user_id'];
$schedule_id = $_GET['schedule_id'];
$_SESSION['schedule_id'] = $schedule_id;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seat_number = $_POST['seat_number'];
  $print="SELECT * FROM `bus_schedules` WHERE id=$schedule_id";
  $result=mysqli_query($conn,$print);
  if(!$result){
    echo "<p style='color:red;'>Connection _fail...</p>";
  }
  if($row=mysqli_fetch_assoc($result)){
        $price=$row['price'];
        $bus_number=$row['bus_number'];
  }
    // Check if the seat is already booked
    $check_sql = "SELECT * FROM reservations WHERE schedule_id =? AND seat_number = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii",$schedule_id,$seat_number);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Seat is already booked
        echo "<p style='color:red;'>Seat number $seat_number is already taken. Please choose a different seat.</p>";
    } else {
        if($seat_number<=60){
        // Proceed with booking the seat
        $insert_sql = "INSERT INTO reservations (user_id, schedule_id, seat_number,bus_number,price) VALUES (?,?,?,?,?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iiisi",$user_id,$schedule_id,$seat_number,$bus_number,$price);
        }
        else
        {
         echo "<p style='color:red;'>Please choose a seat between 1 to 60.</p>";
        }
        if ($insert_stmt->execute()) {
            echo "Seat Booked! Pay Now: <a href='payment.php?res_id={$conn->insert_id}'>Proceed to Payment</a>";
            // <td><a href='book.php?schedule_id={$row['id']}'>Book</a></td>

                // header("Location: dashboard.php");
                ?>
                <br>
        <a href="dashboard.php"><input type="button" value="back to dashbord"></a>
          <?php
            exit();
        } else {
            echo "<p style='color:red;'>There was an error booking the seat. Please try again.</p>";
            ?>
        <a href="dashboard.php"><input type="button" value="back to dashbord"></a>
          <?php
        }
    }

       ?>
        <a href="dashboard.php"><input type="button" value="back to dashbord"></a>
    <?php
    $check_stmt->close();
    $insert_stmt->close();
}
$schedule_sql = "SELECT * FROM bus_schedules WHERE id = ?";
$schedule_stmt = $conn->prepare($schedule_sql);
$schedule_stmt->bind_param("i", $schedule_id);
$schedule_stmt->execute();
$schedule_result = $schedule_stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Seat</title>
</head>
<body>
    <h1>Book Seat for</h1> <h1 style="color: red;"><?php echo $schedule_result['bus_name']; ?></h1>
    <form method="POST">
        <label for="seat_number">Seat Number:</label>
        <input type="number" name="seat_number" id="seat_number" required>
       <input type="submit" value="Book">
    </form>
</body>
</html>