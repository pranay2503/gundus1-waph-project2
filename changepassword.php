<?php
// changepassword.php
session_start();

function csrf_logout_alert() {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time()-42000, $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
    }
    session_destroy();
    ?>
    <!doctype html>
    <html lang="en">
    <head>
      <meta charset="utf-8" />
      <title>Security Alert</title>
      <meta http-equiv="refresh" content="2; url=login.php">
      <style>
        body{margin:0;padding:0;background:#ffe5e5;display:flex;justify-content:center;align-items:center;height:100vh;font-family:"Segoe UI",sans-serif}
        .card{background:#fff;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,.1);padding:26px 34px;text-align:center}
        h1{margin:0 0 8px;color:#d90429}
        p{margin:0;color:#333}
      </style>
      <script>
        alert("CSRF Attack Detected!");
        setTimeout(()=>alert("Logged out for security"), 400);
      </script>
    </head>
    <body>
      <div class="card">
        <h1>CSRF Attack Detected!</h1>
        <p>Logging out for security...</p>
      </div>
    </body>
    </html>
    <?php
    exit;
}

if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }

// Only POST + valid token allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { csrf_logout_alert(); }
if (empty($_POST['csrf']) || empty($_SESSION['csrf_change']) || !hash_equals($_SESSION['csrf_change'], $_POST['csrf'])) {
    csrf_logout_alert();
}

$me   = $_SESSION['username'];
$old  = $_POST['old']  ?? '';
$new1 = $_POST['new1'] ?? '';
$new2 = $_POST['new2'] ?? '';

if ($new1 === '' || $new1 !== $new2) {
    echo "<h3>Passwords do not match.</h3><p><a href='changepasswordform.php'>Try again</a></p>";
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $db = new mysqli('localhost','pranay2503','Saipranay@2503','project2');
    $db->set_charset('utf8mb4');

    // verify current password
    $stmt = $db->prepare("SELECT 1 FROM users WHERE username=? AND password=MD5(?)");
    $stmt->bind_param("ss", $me, $old);
    $stmt->execute();
    $ok = $stmt->get_result()->fetch_row();
    $stmt->close();

    if (!$ok) {
        echo "<h3>Current password is incorrect.</h3><p><a href='changepasswordform.php'>Try again</a></p>";
        exit;
    }

    // update to new password (MD5 to match your schema)
    $stmt = $db->prepare("UPDATE users SET password=MD5(?) WHERE username=?");
    $stmt->bind_param("ss", $new1, $me);
    $stmt->execute();

    // rotate CSRF token after successful change
    unset($_SESSION['csrf_change']);

} catch (Exception $e) {
    echo "<h3>Database error.</h3>";
    exit;
}

// success page
?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8" /><title>Password Changed</title>
<style>
  body{margin:0;padding:0;background:#f0f2f5;display:flex;justify-content:center;align-items:center;min-height:100vh;font-family:"Segoe UI",sans-serif}
  .card{background:#fff;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,.1);padding:28px;text-align:center}
  h2{margin:0 0 10px;color:#11683a}
  a{color:#0d6efd;text-decoration:none}
</style></head>
<body>
  <div class="card">
    <h2>Password changed successfully.</h2>
    <p><a href="profile.php">Back to profile</a></p>
  </div>
</body>
</html>

