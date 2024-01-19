<?php
include('config.php');
$username = $_POST['user'];
$password = $_POST['pass'];




$IP = gcip2();

$browserName =  $_SERVER['HTTP_USER_AGENT'];
$browser = get_browser();
$session  = array($browserName, $browser, $IP);
$browser = serialize($session);
print_r($browser);

// $sqli = "INSERT INTO `activity`(`username`, `session_details`, `ip`,`activity`) VALUES ('$username','$browser','$IP','Login')";
// $con->query($sqli);


//to prevent from mysqli injection  
$username = stripcslashes($username);
$password = stripcslashes($password);
$username = mysqli_real_escape_string($con, $username);
$password = mysqli_real_escape_string($con, $password);

$sql = "select * from admin where name = '$username' and password = '$password'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = mysqli_num_rows($result);

if ($count == 1) {
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["id"] = $row['id'];
    $_SESSION["username"] = $username;
    header("location: /admin-dashboard");
} else {
    echo "<h1> Login failed. Invalid username or password.</h1>";
}
