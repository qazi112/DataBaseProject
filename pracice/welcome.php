<?php session_start();
	include "connection.php";
	// print_r($_POST);
	
	function testinput($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
	}
	$name = testinput($_POST['name']);
	$url  = testinput($_POST['url']);
	$email  = testinput($_POST['email']);
	$password = testinput($_POST['pass']);
	$GLOBALS['success'] = "Success";

	setcookie('user',time()-3600);
	
	// if(!preg_match("/^[a-zA-Z ]*$/", $name))
	// {
	// 	header("Location: prac.php?error=invalid_name");
	// }else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	// {
	// 	header("Location: prac.php?error=invalid_email");
	// }else if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)){
	// 	header("Location: prac.php?error=invalid_url");
	// }else
	// {
	// 	$GLOBALS['success'] = "Success";
	// }

$date = strtotime("Saturday");


if (isset($_POST['submit'])) {
	$filename = $_FILES['fileToUpload']['name'];
	$fileSize = $_FILES['fileToUpload']['size'];
	$fileTmp = $_FILES['fileToUpload']['tmp_name'];
	$fileType = $_FILES['fileToUpload']['type'];
	$fileExt = explode('.',$filename);
	$fileExtActual = strtolower(end($fileExt));
	$allowedTypes = array('pdf','jpg','jpeg','png');
	if (in_array($fileExtActual, $allowedTypes)) {
		if ($_FILES['fileToUpload']['error'] === 0) {
			if ($fileSize < 1000000) {
				$fileNewName = uniqid('',true).".".$fileExtActual;
				$fileDestination = 'uploads/'.$fileNewName;
				move_uploaded_file($fileTmp, $fileDestination);
				$uploadMessage = 'success';

			}else{
				echo "File is too big";
			}
		}else{
			echo "There was an error in uploading File";
		}
	}else{
		echo "This Format is not allowed";
	}
	
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
</head>
<body>
	<h1><?php echo $_POST['name'] ?></h1><br>
	<h1><?php echo $_POST['url'] ?></h1><br>

	<h1><?php echo $_POST['email'] ?></h1><br>
	<h1><?php echo $GLOBALS['success'] ?></h1>
	
	<h1><?php echo date('Y-m-d h:i:sa',$date); ?></h1>
		<?php if (isset($_SESSION['user'])){
			echo $_SESSION['user'];
		}else{
			echo $_SESSION['user'];
		} ?>
			
		
	
</body>
</html>