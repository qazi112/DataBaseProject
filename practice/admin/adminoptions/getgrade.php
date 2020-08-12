<?php 
session_start();
if(!isset($_SESSION['email']))
{
	header("Location: ../login.php?msg=notLoggedIn");
	exit();
}
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

</head>
<body>

<?php 
require '../includes/dbcon.inc.php';

$sql = 'SELECT * from GRADE_MAIN';
$result = $conn->query($sql);

echo "
<div class='table-responsive-sm'>
<table class='table table-dark table-bordered table-hover'>
<tr>
<th>Id</th>
<th>Grade Name</th>
<th>Grade Basic</th>
<th>Travel Allowance</th>
<th>Medical Allowance</th>
<th>House Rent</th>
<th>Bonus</th>
<th>Tax</th>
<th>Action</th>

</tr>";
 while($row = $result->fetch_assoc())
 {
 echo "<tr>";
  echo "<td>" . $row['grade_id'] . "</td>";
  
  echo "<td>" . $row['grade_name'] . "</td>";
  echo "<td>" . $row['basic'] . "</td>";
  echo "<td>" . $row['grade_ta'] . "</td>";
  echo "<td>" . $row['grade_ma'] . "</td>";
  echo "<td>" . $row['grade_hr'] . "</td>";
  echo "<td>" . $row['bonus'] . "</td>";
  echo "<td>" . $row['grade_ptax'] . "</td>";
  echo "<td>" . '<a href="../adminScripts/deleteGrade.php?id='.$row['grade_id']. '"> Delete </a>' . "</td>";
  echo "</tr>";
}
echo "</table>";
echo "</div>";

?>

</body>
</html>