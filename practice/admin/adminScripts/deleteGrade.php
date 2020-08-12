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
		$grade_id = test_input($_GET['id']);
		$grade_id = intval($grade_id);
		if(empty($grade_id))
		{
			header("Location: ../adminoptions/addGrade.php?error=emptyId");
			exit();
			
		}else
		{
			// All set, go
			require '../includes/dbcon.inc.php';
			$sql = "DELETE FROM Grade_main where grade_id = ?";
			$stmt = $conn->prepare($sql);

			$stmt->bind_param("i",$grade_id);
			$stmt->execute();
			$stmt->close();
			header("Location: ../adminoptions/addGrade.php?success=Deleted");
			exit();

		}
	}
