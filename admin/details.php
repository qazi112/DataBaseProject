<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<!-- <style>
table {
  width: 100%;
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid black;
  padding: 5px;
}

th {text-align: left;}
</style> -->
</head>
<body>

<?php 
require 'includes/dbcon.inc.php';

$sql = 'SELECT * from admin';
$result = $conn->query($sql);

echo "

<table class='table table-dark table-bordered table-hover'>
<tr>
<th>Id</th>
<th>Email</th>
<th>password</th>
<th>Action</th>

</tr>";
 while($row = $result->fetch_assoc())
 {
 echo "<tr>";
  echo "<td>" . $row['admin_id'] . "</td>";
  
  echo "<td>" . $row['mail'] . "</td>";
  echo "<td>" . $row['password'] . "</td>";
  echo "<td>" . '<a href="delete.php?id='.$row['admin_id']. '"> Delete </a>' . "</td>";
  echo "</tr>";
}
echo "</table>";

?>

</body>
</html>