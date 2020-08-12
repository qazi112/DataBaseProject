<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>
		
	</title>
</head>
<body>
<?php 

	$mypass = "arsalan123";
	$hashed = password_hash($mypass, PASSWORD_DEFAULT);
	
	echo password_verify($mypass, $hashed);

	$_SESSION['user']="qazi123";
	if (isset($_SESSION['user'])) {
		echo $_SESSION['user'];
	}
 ?>
<br>
 <a href="prac.php" >Prac</a>
</body>
</html>


