<?php
require "session_auth.php";

$mysqli = new mysqli("localhost", "pranay2503", "Saipranay@2503", "project2");
$rand = bin2hex(openssl_random_pseudo_bytes(16));
$_SESSION["nocsrftoken"] = $rand;

$username = $_SESSION["username"];
$fullname = "";
$email = "";

$stmt = $mysqli->prepare("SELECT fullname, email FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($fullname, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .profile-form {
            width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .profile-form h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .profile-form .welcome {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .profile-form input[type="text"],
        .profile-form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border-radius: 6px;
            background: #fefefe;
            text-align: center;
        }
        .profile-form button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }
        .profile-form a {
            display: block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
     </style>
     <script type="text/javascript">
    function displayTime() {
      const options = {
        month: 'short',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
      };
      const formattedTime = new Date().toLocaleString('en-US', options).replace(/,/g, '');
      document.getElementById('digit-clock').innerHTML = "Current time: " + formattedTime;
    }
    setInterval(displayTime, 500);
</script>
</head>
<body>
    <div class="profile-form">
        <small>By Sai Pranay Gundu<br>
        <div id="digit-clock"></div >      
        <div style="margin-top: 20px;"></div>
        <div class="welcome">Welcome <?php echo htmlentities($username); ?>!</div>
        <form method="post" action="updateprofile.php">
            <h1>My Profile</h1>
            <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
            <p>Full Name:</p>
            <input type="text" name="fullname" required value="<?php echo htmlentities($fullname); ?>" />
            <p>User Name:</p>
            <input type="text" name="username" required value="<?php echo htmlentities($username); ?>" />
            <p>Email:</p>
            <input type="email" name="email" required value="<?php echo htmlentities($email); ?>" />
            <button type="submit">Update Profile</button>
            <a href="changepasswordform.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </form>
    </div>
</body>
</html>
<?php
require "session_auth.php";

$mysqli = new mysqli("localhost", "pranay2503", "Saipranay@2503", "project2");
$rand = bin2hex(openssl_random_pseudo_bytes(16));
$_SESSION["nocsrftoken"] = $rand;

$username = $_SESSION["username"];
$fullname = "";
$email = "";

$stmt = $mysqli->prepare("SELECT fullname, email FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($fullname, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .profile-form {
            width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .profile-form h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .profile-form .welcome {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .profile-form input[type="text"],
        .profile-form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border-radius: 6px;
            background: #fefefe;
            text-align: center;
        }
        .profile-form button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }
        .profile-form a {
            display: block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
    <script type="text/javascript">
        function displayTime() {
            const options = {
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            };
            const formattedTime = new Date().toLocaleString('en-US', options).replace(/,/g, '');
            document.getElementById('digit-clock').innerHTML = "Current time: " + formattedTime;
        }
        setInterval(displayTime, 500);
    </script>
</head>
<body>
    <div class="profile-form">
        <small>By Sai Pranay Gundu<br></small>
        <div id="digit-clock"></div>      
        <div style="margin-top: 20px;"></div>
        <div class="welcome">Welcome <?php echo htmlentities($username); ?>!</div>
        <form method="post" action="updateprofile.php">
            <h1>My Profile</h1>
            <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>

            <label for="fullname">Full Name:</label>
            <input id="fullname" type="text" name="fullname" required value="<?php echo htmlentities($fullname); ?>" />

            <label for="username">User Name:</label>
            <input id="username" type="text" name="username" required value="<?php echo htmlentities($username); ?>" readonly />

            <label for="email">Email:</label>
            <input id="email" type="email" name="email" required value="<?php echo htmlentities($email); ?>" />

            <button type="submit">Update Profile</button>
            <a href="changepasswordform.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </form>
    </div>
</body>
</html>
