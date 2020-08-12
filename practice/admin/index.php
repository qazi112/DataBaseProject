<?php 
session_start();
if(!isset($_SESSION['email']))
{
	header("Location: login.php?msg=notLoggedIn");
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

	<title></title>
</head>
<body>
	<script type="text/javascript">
		function reload()
		{
			document.getElementById("txtHint").style.display='none';
			document.getElementById("hide").style.display='none';
			// window.location.reload();
		}
	function myfunction()
	{

		var xmlhttp = new XMLHttpRequest();
   		 xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","details.php",true);
    xmlhttp.send();
    document.getElementById("txtHint").style.display='block';

    document.getElementById("hide").style.display='block';
	}

</script>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
		<a class="navbar-brand" href="index.php">LOGO</a>
		<ul class="navbar-nav justify-content-end">
			<li class="navbar-item ">
				<form action="includes/logout.inc.php" method="post">
					<button class="navbar-link text-white btn" type="submit" name="logout-sub">Logout</button>
				</form>
				
			</li>
		</ul>

	</nav>
	<div class="container">
	<div class="row mx-auto d-block">
	<?php if(isset($_SESSION['email']))
	{
		echo "<div class='jumbotron'><h2 class='text-center'>Hello : ".$_SESSION['email'].", You are logged in</h2></div>";
	} ?>
	</div>
	
	<div class="row justify-content-end">
	<button class="btn btn-primary " type="submit" onclick="myfunction()">Display Users</button>


	<button class="btn btn-primary float-right" id="hide" style="display:none;" type="submit" onclick="reload()">Hide Users</button>
	</div>
	<div class="row d-block" style="display:block;">
		<div  id="txtHint"></div>
	</div>

		<div class=" jumbotron ">
				<div class="row justify-content-center">
					<h2>Admin Options</h2>
				</div>
				<div class="row justify-content-center mt-2">
					<a class="btn btn-primary" href="adminoptions/addDept.php">Add Department</a>	
				</div>
				<div class="row justify-content-center mt-2">
					<a class="btn btn-primary" href="adminoptions/addGrade.php">Add Pay Grade</a>	
				</div>
				<div class="row justify-content-center mt-2">
					<a class="btn btn-primary" href="adminoptions/addEmployee.php">Add Employee</a>	
				</div>
				<div class="row justify-content-center mt-2">
					<a class="btn btn-primary" href="adminoptions/payroll.php">Generate Pay Slip</a>	
				</div>
				
				
	
		</div>
</div>


</body>
</html>