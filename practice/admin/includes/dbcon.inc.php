<?php 
 $serverName = "localhost";
 $dbName = "DBPROJECT";
 $dbUsername = "root";
 $dbPassword = "";

$conn = new mysqli($serverName,$dbUsername,$dbPassword,$dbName);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "<br>Connected To Database<br>";
