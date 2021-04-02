
<?php 
// related to payroll.php , called from payroll and this page is acting as AJAX responce
// Will Get Those Users which have Status = 1 (Active)
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

</head>
<body>

<?php 
require '../includes/dbcon.inc.php';

$sql = "SELECT * from employee_main , emp_grade_dep_details  
	WHERE employee_main.emp_id = emp_grade_dep_details.emp_id AND emp_grade_dep_details.status = ?;
";
$stmt = $conn->prepare($sql);
$status= intval(1);
if($stmt)
{
	// echo "Good";
	if($stmt->bind_param("i",$status))
	{
		// echo "Binded";
		if($stmt->execute())
		{
			$result = $stmt->get_result();
			echo "
			<div class='table-responsive-sm'>
			<table class='table table-dark table-bordered table-hover'>
			<thead class='table-dark'>
			<tr>
			<th>Id</th>
			<th>Name</th>
			<th>DOJ</th>
			<th>City</th>
			<th>PhNo</th>
			<th>Email</th>
			<th>idcard</th>
			<th>Action</th>
			</thead>
			</tr>";
			while ($row = $result->fetch_assoc()) {
    			echo "<tr>";
  				echo "<td>" . $row['emp_id'] . "</td>";
  				echo "<td>" . $row['emp_name'] . "</td>";
			 	
			  	echo "<td>" . $row['join_date'] . "</td>";
			  	
			  	echo "<td>" . $row['city'] . "</td>";
			  	echo "<td>" . $row['phone_no'] . "</td>";
			  	echo "<td>" . $row['email_id'] . "</td>";
			  	echo "<td>" . $row['idcard_no'] . "</td>";
			  	echo "<td>" . '<a href="../adminScripts/generateSlip.php?id='.$row['emp_id']. '"> Generate Slip </a>' . "</td>";
			  	echo "</tr>";
				}
				echo "</table>";
				echo "</div>";
				
				
		}else{
			// echo "Error Execute";
			$stmt->error;
			exit();
		}

	}else{
		// echo "Error Bind";
		$stmt->error;
		exit();
	}
	
}else{
	echo $conn->error;
	// echo "Bad";
	exit();
}

?>

</body>
</html>