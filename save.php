<?php
// Database connection details
$server = "localhost";
$username = "root";
$password = "";
$database = "mini project";

// Create connection
$conn = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Collect form data
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$phone = htmlspecialchars($_POST['phone']);
$address = htmlspecialchars($_POST['address']);

// Validate form data
if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($address)) {
    die("All fields are required!");
}

// Check for duplicate entries
$checkQuery = "SELECT * FROM `test` WHERE `Email` = '$email' OR `Phone Number` = '$phone'";
$checkResult = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($checkResult) > 0) {
    die("Error: A user with the same email or phone number already exists!");
}

// Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert data into the database
$sql = "INSERT INTO `test` (`Name`, `Email`, `Password`, `Phone Number`, `Address`) 
        VALUES ('$name', '$email', '$hashedPassword', '$phone', '$address')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>