<?php
session_start();

$conn = new mysqli("localhost", "root", "", "hive");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email    = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare(
    "SELECT userID, name, email, password, user_type 
     FROM users WHERE email = ?"
);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Invalid email or password.");
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    die("Invalid email or password.");
}

// Save session data
$_SESSION['userID'] = $user['userID'];
$_SESSION['name'] = $user['name'];
$_SESSION['user_type'] = $user['user_type'];

// Redirect based on user type
if ($user['user_type'] === 'volunteer') {
    header("Location: sanstaVolunteerStats.html");
} elseif ($user['user_type'] === 'organization') {
    header("Location: OrgProfilePage.html");
} else {
    header("Location: student_dashboard.php");
}
exit();
?>
