<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "hive";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password_raw = $_POST['password'];
    $user_type = $_POST['user_type'];

    $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, user_type) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password_hashed, $user_type);

    if ($stmt->execute()) {
        echo "<h2>Account created successfully!</h2>";
        echo "<a href='Login.html'>Click here to login</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

