<?php 
session_start();
if(!isset($_SESSION['email']))
{
	header("Location: ../login.php?error=NotLoggedIn");
	exit();
} 
function test_input($data) 
	{
		$data = trim($data);
	  	$data = stripslashes($data);
	 	$data = htmlspecialchars($data);
	  return $data;
	}
	if (isset($_GET['id'])) {
		$emp_id = test_input($_GET['id']);
		$emp_id = intval($emp_id);
		if(empty($emp_id))
		{
			header("Location: ../adminoptions/addEmployee.php?error=emptyId");
			exit();
			
		}else
		{
			// All set, go
			require '../includes/dbcon.inc.php';
			$sql = "DELETE FROM Employee_main where emp_id = ?";
			$stmt = $conn->prepare($sql);

			$stmt->bind_param("i",$emp_id);
			$stmt->execute();
			$stmt->close();
			header("Location: ../adminoptions/addEmployee.php?success=Deleted");
			exit();

		}
	}
