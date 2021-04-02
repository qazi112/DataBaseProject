<?php 
if(!isset($_POST['signup']))
{
	// if not pressed signup button, redirect to register page
	header("Location: ../register.php?error=notregistered");
	exit();
}else{
	function test_input($data)
	{
		$data = trim($data);
	  	$data = stripslashes($data);
	 	$data = htmlspecialchars($data);
	  return $data;
	}

require "dbcon.inc.php";



$email = test_input($_POST['email']);
$password = test_input($_POST['pass']);
$passRepeat = test_input($_POST['repeat_pass']);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$hashedPass = password_hash($password,PASSWORD_DEFAULT);

if(empty($email) || empty($password) || empty($passRepeat))
{
	header("Location: ../register.php?error=emptyFields");
	exit();

}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	echo("$email is not a valid email address");
	  header("Location: ../register.php?error=invalidEmail&mail=".$email);
	  exit();
}else if($password !== $passRepeat)
{
	header("Location: ../register.php?error=passNotMatched&mail=".$email);
	exit();
}else{
	$sql = "SELECT mail from `admin` where mail = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s",$email);
	$stmt->execute();
	$result = $stmt->store_result(); // store the mysqli result
	if($stmt->num_rows > 0)
	{
		echo var_dump($result);
		header("Location: ../register.php?error=userExists");
		exit();
	}

	$sql = "INSERT INTO `admin` (mail,password) VALUES (?,?)";
	$stmt= $conn->prepare($sql);
	$stmt->bind_param("ss", $email,$password);
	$stmt->execute();
	echo "New records created successfully";
	$stmt->close();
	header("Location: ../login.php?sucess=userCreated");
	exit();

}


}




