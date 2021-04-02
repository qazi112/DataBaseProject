<?php 
session_start();
require 'includes/dbcon.inc.php';

$id=$_GET['id'];
$sql = "DELETE FROM ADMIN where admin_id = ?";
$stmt = $conn->prepare($sql);

	$stmt->bind_param("i",$id);
	$stmt->execute();
	$stmt->close();
	header("Location: index.php?success=Deleted");
	exit();

 ?>