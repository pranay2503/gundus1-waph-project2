<?php
session_start();
$mysqli = new mysqli("localhost", "pranay2503", "Saipranay@2503", "project2");

$username = trim($_REQUEST["username"]);
$password = $_REQUEST["password"];

$stmt = $mysqli->prepare("SELECT username FROM users WHERE username=? AND password=md5(?)");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

$stmt->bind_result($fetched_username);
if ($stmt->fetch()) {
    $_SESSION["authenticated"] = true;
    $_SESSION["username"] = $fetched_username;
    $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];

    header("Location: profile.php");
    exit();
} else {
    echo "<script>alert('Login failed.');</script>";
    echo "<script>window.location.href='login.php';</script>";
}
$stmt->close();
?>
