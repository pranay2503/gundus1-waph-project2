<?php
// updateprofile.php  — simple edit (no CSRF), shows form + saves
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
$me = $_SESSION['username'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $db = new mysqli('localhost','pranay2503','Saipranay@2503','project2');
  $db->set_charset('utf8mb4');
} catch (Exception $e) {
  http_response_code(500); echo "<h3>Database error.</h3>"; exit;
}

$msg = ""; $ok = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = trim($_POST['fullname'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  if ($fullname === '' || $email === '') {
    $msg = "Both fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $msg = "Please enter a valid email.";
  } else {
    $stmt = $db->prepare("UPDATE users SET fullname=?, email=? WHERE username=?");
    $stmt->bind_param("sss", $fullname, $email, $me);
    $stmt->execute();
    $ok = true;
  }
}

/* Always load latest values to display */
$stmt = $db->prepare("SELECT fullname, email FROM users WHERE username=?");
$stmt->bind_param("s", $me);
$stmt->execute();
$stmt->bind_result($fullname_cur, $email_cur);
$stmt->fetch();
$stmt->close();

/* If just saved, reflect posted values */
if ($ok) { $fullname_cur = trim($_POST['fullname']); $email_cur = trim($_POST['email']); }
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Update Profile</title>
<style>
  body{margin:0;padding:0;font-family:"Segoe UI",sans-serif;background:#f0f2f5;display:flex;align-items:center;justify-content:center;min-height:100vh}
  .card{background:#fff;width:480px;max-width:92vw;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,.1);padding:28px}
  h1{margin:0 0 12px;text-align:center;color:#333}
  .meta{text-align:center;color:#666;margin-bottom:14px}
  .ok{background:#e7f7ed;border:1px solid #b6e6c7;color:#11683a;padding:10px 12px;border-radius:8px;margin-bottom:10px}
  .err{background:#fde8e8;border:1px solid #f5b5b5;color:#8a1f1f;padding:10px 12px;border-radius:8px;margin-bottom:10px}
  form{display:flex;flex-direction:column;gap:12px}
  label{font-weight:600;color:#444}
  input{padding:10px;border:1px solid #ddd;border-radius:8px;font-size:14px}
  input:focus{outline:none;border-color:#0d6efd}
  .btn{padding:12px;background:#0d6efd;color:#fff;border:0;border-radius:8px;font-weight:700;cursor:pointer}
  .btn:hover{background:#0b5ed7}
  .links{text-align:center;margin-top:12px}
  .links a{text-decoration:none}
</style>
<script>
  function tick(){
    const o={month:'short',day:'2-digit',hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:true};
    document.getElementById('clock').textContent = new Date().toLocaleString('en-US',o).replace(/,/g,'');
  }
  document.addEventListener('DOMContentLoaded',()=>{tick(); setInterval(tick,500);});
</script>
</head>
<body>
  <div class="card">
    <h1>Update Profile</h1>
    <div class="meta">Current time: <span id="clock"></span></div>
    <div class="meta">Editing: <strong><?= htmlspecialchars($me) ?></strong></div>

    <?php if ($ok): ?>
      <div class="ok">Profile updated successfully.</div>
    <?php elseif ($msg): ?>
      <div class="err"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form method="POST" action="updateprofile.php" autocomplete="off">
      <label for="fullname">Full Name</label>
      <input id="fullname" name="fullname" type="text" required maxlength="64"
             value="<?= htmlspecialchars($fullname_cur ?? '') ?>">
      <label for="email">Email</label>
      <input id="email" name="email" type="email" required maxlength="96"
             value="<?= htmlspecialchars($email_cur ?? '') ?>">
      <button class="btn" type="submit">Save Changes</button>
    </form>

    <div class="links">
      <a href="profile.php">Back to Profile</a> · <a href="logout.php">Logout</a>
    </div>
  </div>
</body>
</html>

