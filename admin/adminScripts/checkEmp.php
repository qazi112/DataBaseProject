<?php 
session_start();
if(!isset($_SESSION['email']))
{
	header("Location: ../login.php?msg=notLoggedIn");
	exit();
}
require '../includes/dbcon.inc.php';
$currentDate = date('Y-m-d');
echo $currentDate;

$sql= "UPDATE emp_grade_dep_details
SET status = 0
WHERE to_date < ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s",$currentDate);
$stmt->execute();

echo "Employees Checked !";





?>