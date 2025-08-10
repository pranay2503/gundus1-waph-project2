<?php
$mysqli = new mysqli('localhost','pranay2503','Saipranay@2503','project2');
echo $mysqli->connect_errno ? "CONNECT ERROR: ".$mysqli->connect_error : "DB CONNECT OK";
