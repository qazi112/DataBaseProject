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
		var xmlhttp = new XMLHttpRequest();
   		 xmlhttp.onreadystatechange = function() {
     	 if (this.readyState == 4 && this.status == 200) {
        document.getElementById("details").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","getdepartment.php",true);
    xmlhttp.send();
	</script>


	<nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
		<a class="navbar-brand" href="">LOGO</a>
		<ul class="navbar-nav justify-content-end">
			<li class="navbar-item ">
				<form action="../includes/logout.inc.php" method="post">
					<button class="navbar-link text-white btn" type="submit" name="logout-sub">Logout</button>
				</form>
				
			</li>
		</ul>

	</nav>
	<div class="container">
		<div class="jumbotron">
			<form action="" method="post">
				
  <div class="form-group">
  	<h1 class="text-center">Add Department</h1>
  		<?php if (isset($_GET['error'])) {
					if ($_GET['error']== "empty") {
						echo "<h4>Empty Feilds!!</h4>"; 	
					}else if($_GET['error']=="invalidFormat")
					{
						echo "<h4>Only English Alphabets allowed!!</h4>";
					}
				} 
				?>
    <label for="dept">Department Name:</label>
    <input type="Text" class="form-control" placeholder="Enter Department" id="dept" name="dept_name">

  </div>

  <button type="submit" name="dept-sub" class="btn btn-primary">ADD</button>
</form>
		<div id="message"></div>
		</div>

		<div class="jumbotron">
			<div class="row  d-block" style="display:block;">
				<h2 class="text-center">Departments</h2>
				<p onload="myFunction()"></p>
				<div id="details"></div>
			</div>
		</div>

	</div>

</body>
</html>

<?php
  // Now backend work adding dept

if (isset($_POST['dept-sub'])) {
	$errname='';
	require '../includes/dbcon.inc.php';
	function test_input($data)
	{
		$data = trim($data);
	  	$data = stripslashes($data);
	 	$data = htmlspecialchars($data);
	  return $data;
	}
	$dept_name=test_input($_POST['dept_name']);
	if(empty($_POST['dept_name']))
	{
		$errname= "Department Name Required !!";
		header("Location: addDept.php?error=empty");
		exit();
	}else if(!preg_match('/^[a-zA-Z ]*$/',$dept_name))
	{
		$errname="Only letters and white space allowed";
		header("Location: addDept.php?error=invalidFormat");
		exit();
	}else{
		$sql = "SELECT dep_name FROM Department WHERE dep_name=?";
		$stmt = $conn->prepare($sql);
		if($stmt)
		{
			if($stmt->bind_param("s",$dept_name))
			{
				$stmt->execute();
				$result = $stmt->store_result();
				if($stmt->num_rows > 0){
					echo "Department Exits...!<br>";
					header("Location: addDept.php?error=NameTaken");
					exit();
				}else{

					// INSERTING IN DATABASE
					$sql= "INSERT INTO Department (dep_name) VALUES (?);";
					$stmt = $conn->prepare($sql);
					if($stmt){
						if($stmt->bind_param("s",$dept_name))
						{
							if($stmt->execute())
							{
								echo "Department Added <br>";
								$stmt->close();
								header("Location: addDept.php?success=dept_added");
								exit();
							}else{
								echo "SQL INSERT ERROR IN EXECUTION";
								$stmt->close();
								exit();
							}
						}else{
							echo "SQL ERROR IN INSERTING BIND PARAM <BR>";
						}

					}
					// ==================

				}
			}else{
			 	echo "SQL ERROR BIND PARAM";
			exit();
			}
		}else{
			echo "SQL ERROR IN CHECKING RECORD ALL READY EXIST OR NOT";
			exit();
		}
	}




}
