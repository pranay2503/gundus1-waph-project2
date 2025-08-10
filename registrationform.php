<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>WAPH - Registration Page</title>

  <style>
    :root { color-scheme: light; }
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      width: 420px;
      box-shadow: 0 4px 15px rgba(0,0,0,.1);
    }
    h1, h2 {
      text-align: center;
      color: #333;
      margin: 0 0 10px;
    }
    #digit-clock {
      text-align: center;
      margin: 6px 0 14px;
      font-weight: 600;
      color: #666;
    }
    form { display: flex; flex-direction: column; gap: 10px; }
    label { font-weight: 600; color: #444; }
    input {
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
      outline: none;
    }
    input:focus { border-color: #0d6efd; }
    .hint { font-size: 12px; color: #888; margin-top: -6px; }
    button {
      margin-top: 8px;
      padding: 12px;
      background: #0d6efd;
      color: #fff;
      border: 0;
      border-radius: 8px;
      font-weight: 700;
      cursor: pointer;
    }
    button:hover { background: #0b5ed7; }
    .switch-link { text-align: center; margin-top: 12px; }
    .switch-link a { text-decoration: none; }
  </style>

  <script>
    // Live current time (no visited time)
    function displayTime() {
      const opts = { month:'short', day:'2-digit', hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:true };
      const t = new Date().toLocaleString('en-US', opts).replace(/,/g, '');
      const el = document.getElementById('digit-clock');
      if (el) el.textContent = "Current time: " + t;
    }
    document.addEventListener('DOMContentLoaded', () => {
      displayTime();
      setInterval(displayTime, 500);
    });

    // Confirm password must match
    function checkMatch() {
      const p = document.getElementById('password');
      const c = document.getElementById('confirm');
      if (!p || !c) return;
      c.setCustomValidity(c.value !== p.value ? 'Password does not match' : '');
    }
  </script>
</head>

<body>
  <div class="container">
    <h1>A Simple login form, WAPH</h1>
    <h2>Sai Pranay Gundu</h2>
    <div id="digit-clock" aria-live="polite"></div>

    <form action="addnewuser.php" method="POST" autocomplete="off">
      <label for="username">Username:</label>
      <input
        type="text" id="username" name="username"
        required minlength="3" maxlength="32" pattern="[A-Za-z0-9_]+"
        placeholder="Choose a username" />
      <div class="hint">Use letters, numbers, and underscore only.</div>

      <label for="fullname">Full Name:</label>
      <input
        type="text" id="fullname" name="fullname"
        required maxlength="64" placeholder="Your full name" />

      <label for="email">Email:</label>
      <input
        type="email" id="email" name="email"
        required maxlength="96" placeholder="your@email.com" />

      <label for="password">Password:</label>
      <input
        type="password" id="password" name="password"
        required minlength="8"
        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
        placeholder="At least 8 chars, A/z, 0-9, and !@#$%^&"
        oninput="checkMatch()" />

      <label for="confirm">Confirm Password:</label>
      <input
        type="password" id="confirm" name="confirm"
        required placeholder="Retype your password"
        oninput="checkMatch()" />

      <button type="submit">Register</button>
    </form>

    <div class="switch-link">
      Already registered? <a href="login.php">Login</a>
    </div>
  </div>
</body>
</html>

