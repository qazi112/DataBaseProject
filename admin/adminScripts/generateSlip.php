<!DOCTYPE html>
<html>
<head>
	<title>	</title>
</head>
<body>
		<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php 
// related to getPayrollActiveEmployee , this page will get emp_id from GET['id'] , take from user salary month , Salary Year
// 
session_start();
if(!isset($_SESSION['email']))
{
	header("Location: ../login.php?msg=notLoggedIn");
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
			header("Location: ../adminoptions/payroll.php?error=emptyId");
			exit();
		}else
		{
			require '../includes/dbcon.inc.php';
			// Checking whether valid employee or not
			$sql = "SELECT * FROM EMPLOYEE_MAIN WHERE emp_id = ?";
			$stmt = $conn->prepare($sql);
			if($stmt){
				if($stmt->bind_param("i",$emp_id))
				{
					echo "Ok Now Execute";
					if($stmt->execute()){
						$result = $stmt->get_result();
						if($result->num_rows >= 1)
						{
							$row = $result->fetch_assoc();
							$emp_name = $row['emp_name'];
							$emp_email = $row['email_id'];
							$emp_idCard = $row['idcard_no'];
							$join_date = $row['join_date'];

							// So i have now valid employee Id , now i will get emp_grade_id and dep id from emp_grade_dep_details_table
							$sql = "SELECT grade_id , dep_id from emp_grade_dep_details WHERE
							emp_id = ?;";
							$stmt = $conn->prepare($sql);
							$stmt->bind_param("i",$emp_id); 
							$stmt->execute();
							$result = $stmt->get_result();
							if($result->num_rows <= 0) // checking whether it exist in emp_grade_dep
							{	
								echo "No Grade table";
								exit();
								header("Location: ../adminoptions/payroll.php?error=noGradeRecord");
								exit();
							}else{
								// Now get grade_id and dep_id
								$row = $result->fetch_assoc();
								$dep_id = $row['dep_id'];
								$grade_id = $row['grade_id'];
								// Got dep_id and grade_id
								// Now i want to get that grade's payment details from GRADE_MAIN
								// --------------------------
								require 'gradeDetail.slip.php';
								// --------------------------
								// this gradeDetail.slip.php will get me all required details of grade i.e ,
								// $grade_basic;
								// $grade_ta ;
								// $grade_ma ;
								// $grade_bonus ;
								// $grade_hr ;
								// $grade_ptax ;
								require 'finalSlipPage.php';
								echo "
									<div class='container'>
									<div class='row justify-content-center mb-4'>
								<button type='button' class='btn btn-primary' onClick= window.print();>Print Salary</button>
								</div>	</div>";	
								

	
								
							}

						}else{
							header("Location: ../adminoptions/payroll.php?error=idNotExist");
							exit();
						}
					}else{
						echo "Error Execute Select For Check emp";
						$stmt->error;
						exit();
					}
				}else{
					$stmt->error;
					echo "Select Bind Param Error";
					exit();
				}
			}else{
				$$conn->error;
				exit();
			}
		}
	}
	else{
		header("Location: ../adminoptions/payroll.php?error=emptyId");
			exit();
	}

	

?>