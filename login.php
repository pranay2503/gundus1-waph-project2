<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>WAPH - Login Page</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      width: 400px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    h1, h2 {
      text-align: center;
      color: #333;
      margin-bottom: 10px;
    }
    #digit-clock {
      text-align: center;
      margin-bottom: 10px;
      font-weight: bold;
      color: #666;
    }
    p { text-align: center; font-size: 14px; color: #888; }
    form { display: flex; flex-direction: column; }
    label { margin-bottom: 6px; font-weight: 500; color: #555; }
    input[type="text"], input[type="password"] {
      padding: 12px; border: 1px solid #ccc; border-radius: 8px;
      margin-bottom: 18px; font-size: 14px;
    }
    button {
      padding: 12px; background-color: #007bff; color: #fff;
      font-weight: bold; border: none; border-radius: 8px;
      cursor: pointer; transition: 0.3s;
    }
    button:hover { background-color: #0056b3; }
    .switch-link { text-align: center; margin-top: 12px; }
    .switch-link a {
      color: #007bff; text-decoration: none; font-weight: 500;
    }
    .switch-link a:hover { text-decoration: underline; }
  </style>

  <script>
    function displayTime() {
      const options = {
        month: 'short', day: '2-digit',
        hour: '2-digit', minute: '2-digit', second: '2-digit',
        hour12: true
      };
      const formatted = new Date().toLocaleString('en-US', options).replace(/,/g, '');
      const el = document.getElementById('digit-clock');
      if (el) el.textContent = "Current time: " + formatted;
    }
    document.addEventListener('DOMContentLoaded', () => {
      displayTime();
      setInterval(displayTime, 500);
    });
  </script>
</head>
<body>
  <div class="container">
    <h1>A Simple login form, WAPH</h1>
    <h2>Sai Pranay Gundu</h2>
    <div id="digit-clock"></div>

    <!-- Change action to your actual auth handler if needed -->
    <form action="index.php" method="POST" autocomplete="off">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required minlength="3" maxlength="32" pattern="[A-Za-z0-9_]+">

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required minlength="8">

      <button type="submit">Login</button>
    </form>

    <div class="switch-link">
      <p>Didn't register? <a href="registrationform.php">Register now</a></p>
    </div>
  </div>
</body>
</html>

