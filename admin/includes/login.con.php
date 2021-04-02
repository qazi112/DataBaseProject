<?php 
session_start();

if(!isset($_POST['login-sub']))
{
	header("Location: ../login.php?error=notloggedIn");
}else
{
require 'dbcon.inc.php';
function test_input($data)
	{
		$data = trim($data);
	  	$data = stripslashes($data);
	 	$data = htmlspecialchars($data);
	  return $data;
	}
	$email = test_input($_POST['email']);
	$password =test_input($_POST['pass']);
	//$passclean = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	if(empty($email) || empty($password))
	{
		header("Location: ../login.php?error=emptyFields");
		exit();

	}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

		header("Location: ../login.php?error=invalidEmail");
		exit();
	}else {

	$sql = "SELECT * from `admin` where mail=?";
	$stmt= $conn->prepare($sql);
	$stmt->bind_param("s",$email);
	$stmt->execute();
	$result = $stmt->get_result();

	if($result->num_rows <= 0)
	{

		header("Location: ../login.php?error=noUser ");
		exit();
	}
	
	$user = $result->fetch_assoc();
	if($password == $user['password'])
	{
		echo "matched";
		$_SESSION['email']= $email;
		$stmt->close();
		header("Location: ../index.php?login=success");
		exit();
	}else{
		echo "Not Matched";
		$stmt->close();
		header("Location: ../login.php?error=Wrongpassword&mail=".$email);
		exit();
	}
	// $pwdCheck = (password_verify($password,$user['password']));
	// if($pwdCheck)
	// {
	// 	echo "correct";
	// 	exit();
	// }else{
	// 	echo "wrong";
	// 	exit();
	// }
	
	


	
	

	}





}


