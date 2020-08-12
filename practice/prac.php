<?php 
// require 'pdfcrowd.php';
// $client = new \Pdfcrowd\HtmlToPdfClient("arsalan_shah", "1044d39e2ad024ca2bfe444a5d538ebb");
// $pdf = $client->convertString('<b>bold</b>');
//  header("Content-Type: application/pdf");
//     header("Cache-Control: no-cache");
//     header("Accept-Ranges: none");
//     header("Content-Disposition: inline; filename=\"example.pdf\"");
// echo $pdf;
// exit();
session_start();
require 'connection.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <html>
<body>

<form method="post" action="" enctype="multipart/form-data">
Name: <input type="text" name="name" value=""><br>
E-mail: <input type="text" name="email"><br>
password: <input type="password" name="pass" value=""><br>
Site Name: <input type="text" name="url"><br>
File : <input type="file" name="fileToUpload" id="fileToUpload">
<input type="submit" name="submit"> <br>
<input type="submit" name="logout">
<button type="submit" name="reload" onClick="refreshPage()">Refresh Page</button>

</form>
<?php if (isset($_SESSION['user'])) {
		echo $_SESSION['user'];
	} 
	if (!isset($_SESSION['user'])) {
		header("Location: index.php?error=notloggedin");
	}else{
		if (isset($_POST['logout'])) {
			session_unset('user');
			session_destroy();
			echo "Unset";
			header("Location: welcome.php?sucess=sessionEnd");
		}
	}


?>
<script type="text/javascript">
	
	function refreshPage()
	{
		window.location.reload();
	}
</script>
</body>
</html>
</body>
</html>



