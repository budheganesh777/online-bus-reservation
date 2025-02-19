<?php
// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "bus_reservation");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    
    $sql = "INSERT INTO comments (name, comment) VALUES ('$name', '$comment')";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Comment added successfully!</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve comments
$result = $conn->query("SELECT * FROM comments ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Page</title>
   <style>
    body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 0;
    background-color: #f4f4f4;
}

h2 {
    color: #333;
}

form {
    background: white;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    margin-bottom: 20px;
}

input, textarea {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px;
    width: 100%;
    cursor: pointer;
    border-radius: 5px;
}

.comment-box {
    background: white;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    box-shadow: 0px 0px 5px rgba(0,0,0,0.1);
}
   </style>
</head>
<body>
    <h2>Leave a Comment</h2>
    <form action="" method="post">
        <input type="text" name="name" placeholder="Your Name" required><br>
        <textarea name="comment" placeholder="Write your comment..." required></textarea><br>
        <button type="submit">Submit</button>
    </form>

    <h2>Comments</h2>
    <?php while ($row = $result->fetch_assoc()) : ?>
        <div class="comment-box">
            <p><strong><?php echo htmlspecialchars($row['name']); ?></strong> (<?php echo $row['created_at']; ?>)</p>
            <p><?php echo htmlspecialchars($row['comment']); ?></p>
        </div>
    <?php endwhile; ?>

</body>
</html>