<?php
$lifetime = 15 * 60;
$path = "/";
$domain = "localhost";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();

// --- Handle login attempt ---
if (isset($_POST["username"]) && isset($_POST["password"])) {
    if (checklogin_mysql($_POST["username"], $_POST["password"])) {
        $_SESSION["authenticated"] = TRUE;
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["browser"] = $_SERVER['HTTP_USER_AGENT'];  // Bind session to browser
    } else {
        session_destroy();
        echo "<script>alert('Invalid username/password'); window.location='login.php';</script>";
        exit();
    }
}

// --- Enforce login on all secure pages ---
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== TRUE) {
    session_destroy();
    echo "<script>alert('You have not logged in. Please login first'); window.location='login.php';</script>";
    exit();
}

// --- Prevent session hijacking ---
if (isset($_SESSION['browser']) && $_SESSION['browser'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_destroy();
    echo "<script>alert('Session hijacking is detected!!!'); window.location='login.php';</script>";
    exit();
}

// --- Prevent function redeclaration ---
if (!function_exists('checklogin_mysql')) {
    function checklogin_mysql($username, $password) {
        $mysqli = new mysqli('localhost', 'pranay2503', 'Saipranay@2503', 'project2');
        if ($mysqli->connect_errno) {
            printf("Database connection failed: %s\n", $mysqli->connect_error);
            exit();
        }
        // Secure query with prepared statement
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND password = md5(?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows == 1) return TRUE;
        return FALSE;
    }
}
?>
