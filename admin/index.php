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
<body onload="checkEmp()">
	<script type="text/javascript">
		function reload()
		{
			document.getElementById("txtHint").style.display='none';
			document.getElementById("hide").style.display='none';
			document.getElementById("disp").style.display='block';
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
    document.getElementById("disp").style.display='none';

    document.getElementById("hide").style.display='block';
	}
	function checkEmp()
	{
		var xmlhttp = new XMLHttpRequest();
   		 xmlhttp.onreadystatechange = function() {
      	if (this.readyState == 4 && this.status == 200) {
        document.getElementById("empChk").innerHTML = this.responseText;
     	 }
    	};
    	xmlhttp.open("POST","adminScripts/checkEmp.php",true);
    	xmlhttp.send();
	}
</script>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
		<a class="navbar-brand border btn" href="index.php">Refresh</a>
		<a class="navbar-brand border btn" href="../index.php">Main Home Page</a>
		<ul class="navbar-nav justify-content-end">
			<li class="navbar-item ">
				<form action="includes/logout.inc.php" method="post">
					<button class="navbar-link text-white btn border" type="submit" name="logout-sub">Logout</button>
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
	
	<div class="row justify-content-center">
	<button  id="disp" class="btn btn-primary mb-3" type="submit" onclick="myfunction()">Display Users</button>


	<button class="btn btn-primary float-right mb-3" id="hide" style="display:none;" type="submit" onclick="reload()">Hide Users</button>
	</div>
	<div class="row d-block" style="display:block;">
		<div  id="txtHint"></div>
	</div>

		<div class=" jumbotron ">
			<h2>Admin Options</h2>
			<div class="list-group">
  <a href="adminoptions/addDept.php" class="list-group-item list-group-item-action flex-column align-items-start active">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Departments</h5>
      <small></small>
    </div>
    <p class="mb-1">You Can View , Add And Delete Departments From Here.</p>
    <small>Click On It.</small>
  </a>

  <a href="adminoptions/addEmployee.php" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Employees</h5>
      <small class="text-muted"></small>
    </div>
    <p class="mb-1">You Can View , Add And Delete Employees From Here.</p>
    <small class="text-muted">Click On it.</small>
  </a>
  <a href="adminoptions/addGrade.php" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Pay Grades</h5>
      <small class="text-muted"></small>
    </div>
    <p class="mb-1">You Can View , Add And Delete Pay Grades From Here.</p>
    <small class="text-muted">Click on it.</small>
  </a>

  <a href="adminoptions/payroll.php" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Pay Slips</h5>
      <small class="text-muted"></small>
    </div>
    <p class="mb-1">You Can Generate Pay Slips For active Employess From Here.</p>
    <small class="text-muted">Click on it.</small>
  </a>
</div>
				
				
				<!-- <div class="row justify-content-center mt-2">
					<a class="btn btn-primary" href="adminoptions/addGrade.php">Add Pay Grade</a>	
				</div>
				<div class="row justify-content-center mt-2">
					<a class="btn btn-primary" href="adminoptions/addEmployee.php">Add Employee</a>	
				</div>
				<div class="row justify-content-center mt-2">
					<a class="btn btn-primary" href="adminoptions/payroll.php">Generate Pay Slip</a>	
				</div> -->
				
				
	
		</div>
		<div id="empChk"></div>
</div>


</body>
</html>