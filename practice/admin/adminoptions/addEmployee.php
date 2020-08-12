<!-- Its Php script is in adminScripts/addingEmployee.scripts.php -->
<?php 
// Checking for Admin Login
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

	<title>Employee</title>
</head>
<body onload="loadRequired() " >
	<!-- Script for loading data from database to site on load of page -->
	<script type="text/javascript">
		function loadRequired(){
			// Getting Grades Table
		var xmlhttp = new XMLHttpRequest();
   		 xmlhttp.onreadystatechange = function() {
     	 if (this.readyState == 4 && this.status == 200) {
        document.getElementById("details").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("POST","getgrade.php",true);
    xmlhttp.send();
    // Getting Department Table
    var xmlhttp = new XMLHttpRequest();
   		 xmlhttp.onreadystatechange = function() {
     	 if (this.readyState == 4 && this.status == 200) {
        document.getElementById("depts").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("POST","getdepartment.php",true);
    xmlhttp.send();
    // Getting Employees Table
    var xmlhttp = new XMLHttpRequest();
   		 xmlhttp.onreadystatechange = function() {
     	 if (this.readyState == 4 && this.status == 200) {
        document.getElementById("employees").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("POST","getemployee.php",true);
    xmlhttp.send();


}
	</script>
	<!-- End Scripts -->
	<!-- nav bar -->
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


<!-- main container -->
	<div class="container">
		<!-- For Showing To Admin -->
		<div class="jumbotron">
			<h1 class="text-center">Page For Adding Employee</h1>
			<hr>
			<div class="row  d-block" style="display:block;">
				<h2 class="text-center">Grades Record</h2>
				
				<div id="details"></div>
			</div>
			<div class="row  d-block" style="display:block;">
				<h2 class="text-center">Departments Record</h2>
				
				<div id="depts"></div>
			</div>
			<div class="row  d-block mt-3" style="display:block;">
				<h2 class="text-center">Employees Record</h2>
				
				<div id="employees"></div>
			</div>

		</div>
		<!-- Showcase ended -->

		<!-- Main Form for admin to write inputs -->
		<div class="jumbotron">
	<form action="../adminScripts/addingEmployee.script.php" method="post">
				
  <div class="form-group">
  	<div class="row">
  		<h4 id="errorMessage" class="text-danger">
  			<?php if (isset($_GET['error'])) {
  				if($_GET['error'] == "emptyFields"){
  					echo "Please Fill All Fields!.";
  				}else if($_GET['error']=="invalidName"){
  					echo "Invalid Name!.";
  				}else if($_GET['error']=="cityNameInvalid"){
  					echo "Invalid City Name!.";
  				}else if($_GET['error']=="invalidEmail"){
  					echo "Invalid Email!.";
  				}else if($_GET['error']=="invalidPhno"){
  					echo "Invalid Phone Number ! (Please Use Numbers Only).";
  				}else if($_GET['error']=="leaveDateinvalid"){
  					echo "Invalid Department Leaving Date, It must must be greater than Or equal to 
  					Join Date.";
  				}else if($_GET['error']=="invalidDates"){
  					echo "Invalid Dates Or Date Error.";
  				}else if($_GET['error']=="employeeExists"){
  					echo "This Employee Already Exits...! Similar Id Card Numbers !!";
  				}

  			}else if(isset($_GET['success'])){
  				if($_GET['success']=="employeeAdded"){
  					echo "Employee Added Successfully.!! Thank You Admin";
  				}
  			} 
  			?>
  		</h4>
  	</div>
  	
  	<h1 class="text-center">Add Employee</h1>
    <label for="grade">Employee Name:</label>
    <input type="Text" class="form-control text-center" placeholder="Enter Employee Name" id="grade" name="emp_name">
    <label for="grade">Date Of Birth:</label>
    <input type="Date" class="text-center form-control" placeholder="Enter Date Of Birth e.g (Y-m-d) in this format)" id="grade" name="dob">
    <label for="grade">Join Date:</label>
    <input type="Date" class="form-control text-center"  id="grade" name="join_date">
    <label for="grade">Adress:</label>
    <input type="text" class="form-control text-center" placeholder="Enter Employee Adress" id="grade" name="adress">
    <label for="grade">City:</label>
    <input type="text" class="form-control text-center" placeholder="Enter Employee City" id="grade" name="city">
    <label for="grade">Mobile Number:</label>
    <input type="Text" class="text-center form-control" placeholder="Enter Mobile Number e.g 03458576666 " id="grade" name="ph_no">
    <label for="grade">Email:</label>
    <input type="Text" class="form-control text-center" placeholder="Enter Email adress e.g xyz123@gmail.com" id="grade" name="email">
    <label for="grade">National Id Card Number:</label>
    <input type="Text" class="form-control text-center" placeholder="Enter Id Card Number" id="grade" name="id_card">
    <h4 class="mt-4 mb-3 text-success">Please See Departments and Grades From Above and write their id's below,
    	e.g if department in which employee has to be enrolled has id 2 , so write 2 in the block, similarly if grade which employee will get has id 4 , so write 4 in grade id block.

    </h4>
    <label for="grade">Department Id:</label>
    <input type="Text" class="form-control text-center" placeholder="Enter Department Id" id="grade" name="dep_id">
    <label for="grade">Grade Id:</label>
    <input type="Text" class="form-control text-center" placeholder="Enter Grade Id" id="grade" name="grade_id">
    <label for="grade">Date Of Join Of Department:</label>
    <input type="Date" class="form-control text-center" id="grade" name="from_date">
    <label for="grade">Date Of Leaving Department:</label>
    <input type="Date" class="form-control text-center" id="grade" name="to_date">
  </div>
  <div class="row justify-content-center">
  	<button type="submit" name="emp-sub" class="btn btn-primary text-center pl-5 pr-5">ADD</button>
  </div>
  
</form>
	<!-- Success Message -->
		<div id="message">
			<?php if (isset($_GET['success'])) {
				if($_GET['success'] == "employeeAdded")
				{
					echo "<h3>Employee Added Successfully !! </h3><br>";
				}
			} ?>
		</div>
		</div>

		

</div>
</body>
</html>


