<?php 
$grade_error= "";
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
    xmlhttp.open("POST","getgrade.php",true);
    xmlhttp.send();
	</script>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
		<a class="navbar-brand" href="/practice/admin/">LOGO</a>
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
  	<h1 class="text-center">Add New Grade</h1>
    <label for="grade">Grade Name:</label>
    <input type="Text" class="form-control text-center" placeholder="Enter Grade Name Only Capital Letters e.g ABC.." id="grade" name="grade_name">
    <label for="grade">Grade Basic Amount:</label>
    <input type="Text" class="text-center form-control" placeholder="Enter Grade Basic Only Numbers e.g 2232" id="grade" name="basic">
    <label for="grade">Grade Travel Allowance:</label>
    <input type="Text" class="form-control text-center" placeholder="Enter Grade Travel Allowance Only Numbers e.g 2232" id="grade" name="grade_ta">
    <label for="grade">Grade Medical Allowance:</label>
    <input type="Text" class="form-control text-center" placeholder="Enter Grade Medical Allowance Only Numbers e.g 2232" id="grade" name="grade_ma">
    <label for="grade">Grade House Rent:</label>
    <input type="Text" class="text-center form-control" placeholder="Enter Grade House Rent Only Numbers e.g 2232 " id="grade" name="grade_hr">
    <label for="grade">Grade Bonus:</label>
    <input type="Text" class="form-control text-center" placeholder="Enter Grade Bonus Only Numbers e.g 2232" id="grade" name="grade_bonus">
    <label for="grade">Grade Professional Tax:</label>
    <input type="Text" class="form-control text-center" placeholder="Enter Grade Professional Tax Only Numbers e.g 2232" id="grade" name="grade_ptax">
  </div>
  <div class="row justify-content-center">
  	<button type="submit" name="grade-sub" class="btn btn-primary text-center pl-5 pr-5">ADD</button>
  </div>
  
</form>
		<div id="message">
			<?php if (isset($_GET['success'])) {
				if($_GET['success'] == "gradeAdded")
				{
					echo "<h3>Grade Added Successfully !! </h3><br>";
				}
			} ?>
		</div>
		</div>

		<div class="jumbotron">
			<div class="row  d-block" style="display:block;">
				<h2 class="text-center">Grades</h2>
				<p onload="myFunction()"></p>
				<div id="details"></div>
			</div>
		</div>

</div>
</body>
</html>
<?php 
	// code for validating and inserting in database

	if(isset($_POST['grade-sub']))
	{
		function test_input($data)
		{
			$data = trim($data);
		  	$data = stripslashes($data);
		 	$data = htmlspecialchars($data);
	  	return $data;
		}

	$grade_name = test_input($_POST['grade_name']);
	$basic = test_input($_POST['basic']);
	$grade_ta = test_input($_POST['grade_ta']);
	$grade_ma = test_input($_POST['grade_ma']);
	$grade_bonus = test_input($_POST['grade_bonus']);
	$grade_hr = test_input($_POST['grade_hr']);
	$grade_ptax = test_input($_POST['grade_ptax']);

	if(empty($grade_name) || empty($basic)||empty($grade_ta)||empty($grade_ma)||empty($grade_bonus)||empty($grade_hr)||empty($grade_ptax))
	{
		header("Location: addGrade.php?error=emptyFields");
		exit();
	}else if(!preg_match('/^[A-Z]*$/',$grade_name))
	{
		header("Location: addGrade.php?error=invalidName");
		$grade_error = "Only Capital letters Allowed";
		exit();
	}else if(!preg_match('/^[0-9]*$/',$basic) || !preg_match('/^[0-9]*$/',$grade_ptax) || !preg_match('/^[0-9]*$/',$grade_hr) || !preg_match('/^[0-9]*$/',$grade_bonus) || !preg_match('/^[0-9]*$/',$grade_ma) || !preg_match('/^[0-9]*$/',$grade_ta) ){
		header("Location: addGrade.php?error=intergerAllowed");
		exit();
	}else{
		$grade_ta = intval($grade_ta);
		$grade_ma = intval($grade_ma);
		$grade_bonus = intval($grade_bonus);
		$grade_hr = intval($grade_hr);
		$grade_ptax = intval($grade_ptax);
		$basic = intval($basic);
		//var_dump($grade_ta);
		require '../includes/dbcon.inc.php';

		// Checking if record already exist

		$sql = "SELECT grade_name FROM GRADE_MAIN where grade_name = ?";
		$stmt = $conn->prepare($sql);
		if($stmt){
			if($stmt->bind_param("s",$grade_name))
			{
				$stmt->execute();
				$result = $stmt->store_result();
				if($stmt->num_rows > 0)
				{
					header("Location: addGrade.php?error=GradeNameTaken");
					echo "Named Already Taken";
					exit();
				}else{ //name not taken, i am ok with it
					echo "Go ahead<br>";
					// Now Inserting Grade in Grade Table
					$sql = "INSERT INTO GRADE_MAIN (grade_name,basic,grade_ta,grade_ma,grade_hr,bonus,grade_ptax)
						VALUES(?,?,?,?,?,?,?);
					";
					$stmt = $conn->prepare($sql);
					if($stmt)
					{ //prepared
						if($stmt->bind_param("siiiiii",$grade_name,$basic,$grade_ta,$grade_ma,$grade_hr,$grade_bonus,$grade_ptax)){
							echo "binded , go ahead"; 

							if($stmt->execute())
							{
								echo "Grade Added Successfully <br>";
								$stmt->close();
								header("Location: addGrade.php?success=gradeAdded");
								exit();
							}else{
								echo "Error In SQL execute <br>";
								echo $grade_hr;
								echo $stmt->error;
								exit();
							}

						}else{
							echo "SQL BIND_PARAM ERROR <BR>";
							header("Location: addGrade.php?error=sqlError");
							exit();
						}
					}else{
						echo "SQL PREPARE ERROR<BR>";
						header("Location: addGrade.php?error=sqlError");
						exit();
					}
				}
			}else{
				echo "SQL ERROR , Bind param in SELECT Statement.";
			exit();

			}

		}else{
			echo "SQL ERROR , Prepare error in SELECT Statement.";
			exit();

		}

	}






	}

 ?>