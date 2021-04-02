<?php 
session_start();
if(!isset($_SESSION['email']))
{
	header("Location: ../login.php?msg=notLoggedIn");
	exit();
} 
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Bootstrap -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

	<title>Payroll</title>
</head>
<body onload="loadRequired()">
	<script type="text/javascript">
		function loadRequired(){
			// Getting Grades Table
			

		var xmlhttp = new XMLHttpRequest();
   		 xmlhttp.onreadystatechange = function() {
     	 if (this.readyState == 4 && this.status == 200) {
        document.getElementById("activeEmp").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("POST","getPayrollActiveEmployee.php",true);
    xmlhttp.send();
}
</script>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
		<a class="navbar-brand" href="/practice/admin/">Home page</a>
		
		<ul class="navbar-nav ">
			<li class="navbar-item  ">
				<form action="../includes/logout.inc.php" method="post">
					<button class="navbar-link text-white btn btn-outline-danger" type="submit" name="logout-sub">Logout</button>
				</form>
				
			</li>
		</ul>

	</nav>

	<div class="container">
		<!-- For Showing To Admin -->
		<div class="jumbotron">
			<h1 class="text-center">Pay Roll System</h1>
			<hr>
			<div class="row  d-block mt-3" style="display:block;">
				<h2 class="text-center">Displaying All Active Employees</h2>
				<div id="activeEmp"></div>
			</div>

		</div>
		<!-- Showcase ended -->

</div>
	
</body>
</html>
<?php 	
 
 ?>