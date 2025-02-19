<html>
    <body>
    <?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli('localhost', 'root','', 'bus_reservation');
$user_id = $_SESSION['user_id'];
if(!$conn){
    echo "connection are fail";
}
$sql="SELECT * FROM `reservations`";
$result=mysqli_query($conn,$sql);
$name=mysqli_num_rows($result);
$sql1="SELECT * FROM `bus_schedules`";
$result1=mysqli_query($conn,$sql1);
$name=mysqli_num_rows($result1);
 ?>
        <h1 style="color: orange;">Your Bus Booking:</h1>
    <table style="width: 90%;" border="1px">
                <tr>
                    <th>Bus Name</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Bus Number</th>
                    <th>price(rs)</th>
                </tr>
 <?php
      if($name>0){
        while($row=mysqli_fetch_assoc($result)){
              if($user_id==$row['user_id']){
                echo $schedule_id=$row['schedule_id'];
                echo "<br>";
                  while($row1=mysqli_fetch_assoc($result1)){
                    if($schedule_id==$row1['id']){
    echo " <tr>
                 <td>{$row1['bus_name']}</td>
                 <td>{$row1['origin']}</td>
                 <td>{$row1['destination']}</td>
                 <td>{$row1['departure_time']}</td>
                 <td>{$row1['arrival_time']}</td>
                 <td>{$row1['bus_number']}</td>
                 <td>{$row1['price']}</td>
            </tr>";
                   }
                   }
                  }
                  } 
                } 
?>
</body>
</html>
        <!-- // echo  "<tr>
        // <td>{$row['user_id']}</td>
        // <td>{$row['schedule_id']}</td>
        // <td>$schedule_id</td>
        // </tr>";
        //   while($row1=mysqli_fetch_assoc($result1)){
        //     if($schedule_id==$row1['id']){
        //         echo "<tr>
        //       <td>{$row1['bus_name']}</td>
        //       <td>{$row1['id']}</td>
        //       </tr>"; -->