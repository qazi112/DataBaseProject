<?php 
session_start();

if (!isset($_POST['logout-sub'])) {
	header("Location: ../index.php");
	exit();
}else{
	print_r($_SESSION);
	
	unset($_SESSION['email']);
	session_destroy();
	header("Location: ../../index.php?loggedOut=success");
	exit();


}