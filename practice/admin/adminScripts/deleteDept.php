<?php 
session_start();
require '../includes/dbcon.inc.php';

$id=$_GET['id'];
$sql = "DELETE FROM DEPARTMENT where dep_id = ?";
$stmt = $conn->prepare($sql);

	$stmt->bind_param("i",$id);
	$stmt->execute();
	$stmt->close();
	header("Location: ../adminoptions/addDept.php?success=Deleted");
	exit();

 ?>