<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli('localhost', 'root', '', 'bus_reservation');
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
    width: 1200px;
    margin: 2rem auto;
    padding: 0 2rem;
}
/* Search Section */
.search-section {
    background-color: #ecf0f1;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.search-section h1 {
    margin-bottom: 1.5rem;
    color: black;
}

.search-form {
    display: grid;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    align-items: start;
}

.form-group label {
    margin-bottom: 0.5rem;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 0.5rem;
    border-radius: 4px;
    border: 1px solid #ccc;
    color: black;
}

.search-btn {
    grid-column: span 3;
    padding: 0.75rem;
    background-color: #18bc9c;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.search-btn:hover {
    background-color: #06efc0;
}
.table{
    width: 90%;
}
.view{
     display: flex;
     justify-content: center;
     /* justify-content: flex-end; */
     cursor: pointer;

}
.view1{
    padding: auto;
    padding-left: 10px;
}
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Bus Booking</h1>
        <div class="view">
            <div> <a href="logout.php">Logout</a></div>
            <div class="view1"><a href="view.php"><input type="button" value="View"></a></div>
            <!-- <td><a href='book.php?schedule_id={$row['id']}'>Book</a></td> -->
        </div>
</header>
          <!-- Main Body -->
    <div class="container">
        <section class="search-section">
            <h1>Find and Book Your Bus :</h1>
            <form class="search-form" action="dashboard.php" method="post">
                <div class="form-group">
                    <label >From :</label>
                    <input type="text" name="from" placeholder="Enter departure city" required>
                </div>
                <div class="form-group">
                    <label>To :</label>
                    <input type="text" name="to" placeholder="Enter destination city" required>
                </div>
                <div class="form-group">
                    <label>Journey Date :</label>
                    <input type="date" name="date" required>
                </div>
                <button type="submit" class="search-btn" name="search">Search Bus</button>
            </form>
        </section>
    </div>
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $from=strtolower($_POST['from']);
    $to=strtolower($_POST['to']);
    $date=$_POST['date'];
  
  $conn=mysqli_connect("localhost","root","","bus_reservation");
  if(!$conn){
    Echo "Connection fail";
  }
  $sql="SELECT * FROM   `bus_schedules`";
  $result=mysqli_query($conn,$sql);
  $name=mysqli_num_rows($result);
  echo "<br>";
 ?>
  <table class="table" border="1px">
                <tr>
                    <th>Bus Name</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Bus Number</th>
                    <th>price(rs)</th>
                    <th>Action</th>
                </tr>
  <?php
  if($name>0){
    while($row=mysqli_fetch_assoc($result)){
            if($from==$row['origin']){
                if($to==$row['destination'])
                {
                    if($date<=$row['arrival_time']){
                echo "     <tr>
                            <td>{$row['bus_name']}</td>
                            <td>{$row['origin']}</td>
                            <td>{$row['destination']}</td>
                            <td>{$row['departure_time']}</td>
                            <td>{$row['arrival_time']}</td>
                            <td>{$row['bus_number']}</td>
                            <td>{$row['price']}</td>
                            <td><a href='book.php?schedule_id={$row['id']}'>Book</a></td>
                          </tr>";
                }
            echo "<br>";
            }
          }
           }
         }
         ?>
         </table>
         <?php
         $result->close(); 
        }
  ?>
</body>
</html>