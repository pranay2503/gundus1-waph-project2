<?php
// changepasswordform.php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
$me = $_SESSION['username'];

function csrf_logout_alert() {
    // kill session first
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

// If someone tries to pass a password in the URL, treat as CSRF
if (isset($_GET['newpassword']) || isset($_GET['password']) || isset($_GET['pass'])) {
    csrf_logout_alert();
}

// Make a CSRF token for the POST form
if (empty($_SESSION['csrf_change'])) {
    $_SESSION['csrf_change'] = bin2hex(random_bytes(16));
}
$token = $_SESSION['csrf_change'];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Change Password</title>
<style>
  body{margin:0;padding:0;background:#f0f2f5;display:flex;justify-content:center;align-items:center;min-height:100vh;font-family:"Segoe UI",sans-serif}
  .card{background:#fff;width:420px;max-width:92vw;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,.1);padding:28px}
  h1{margin:0 0 10px;text-align:center;color:#333}
  .meta{text-align:center;color:#666;margin-bottom:14px}
  form{display:flex;flex-direction:column;gap:12px}
  label{font-weight:600;color:#444}
  input{padding:10px;border:1px solid #ddd;border-radius:8px;font-size:14px}
  input:focus{outline:none;border-color:#0d6efd}
  .btn{padding:12px;background:#0d6efd;color:#fff;border:0;border-radius:8px;font-weight:700;cursor:pointer}
  .btn:hover{background:#0b5ed7}
  .links{text-align:center;margin-top:12px}
</style>
</head>
<body>
  <div class="card">
    <h1>Change Password</h1>
    <div class="meta">User: <strong><?= htmlspecialchars($me) ?></strong></div>

    <form method="POST" action="changepassword.php" autocomplete="off">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($token) ?>">
      <label for="old">Current Password</label>
      <input id="old" name="old" type="password" required minlength="8">

      <label for="new1">New Password</label>
      <input id="new1" name="new1" type="password" required minlength="8"
             pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
             title="Min 8 chars with A–Z, a–z, 0–9 and one of !@#$%^&">

      <label for="new2">Confirm New Password</label>
      <input id="new2" name="new2" type="password" required minlength="8">
      <button class="btn" type="submit">Update Password</button>
    </form>

    <div class="links">
      <a href="profile.php">Back to Profile</a>
    </div>
  </div>
</body>
</html>

