<?php
session_start();

// Let mysqli throw exceptions so we can catch them nicely
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: registrationform.php');
        exit;
    }

    // DB connect
    $db = new mysqli('localhost', 'pranay2503', 'Saipranay@2503', 'project2');
    $db->set_charset('utf8mb4');

    // Read + validate
    $username = trim($_POST['username'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['repassword'] ?? $_POST['confirm'] ?? '';

    if ($username === '' || $fullname === '' || $email === '' || $password === '') {
        throw new Exception('All fields are required.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email address.');
    }
    if ($password !== $confirm) {
        throw new Exception('Passwords do not match.');
    }

    // Insert (your schema stores MD5 hashes)
    $hash = md5($password);
    $stmt = $db->prepare("INSERT INTO users (username, password, fullname, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hash, $fullname, $email);
    $stmt->execute();

    // Success
    header("Location: login.php?registered=1");
    exit;

} catch (mysqli_sql_exception $e) {
    // 1062 = duplicate key
    $msg = ($e->getCode() == 1062)
        ? 'Username or email already exists.'
        : 'Database error: ' . htmlspecialchars($e->getMessage());
    echo "<h3>$msg</h3><p><a href='registrationform.php'>Back to registration</a></p>";
} catch (Exception $e) {
    echo "<h3>" . htmlspecialchars($e->getMessage()) . "</h3><p><a href='registrationform.php'>Back to registration</a></p>";
}

