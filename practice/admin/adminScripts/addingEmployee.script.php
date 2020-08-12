<?php 
// reached here from adminoptions/addEmployee.php
// Checking for Admin Login
session_start();
if(!isset($_SESSION['email']))
{
	header("Location: ../login.php?msg=notLoggedIn");
	exit();
}
 
if(!isset($_POST['emp-sub']))
{
	header("Location: ../adminoptions/addEmployee.php?msg=notSubmitted");
	exit();
}else{
	function test_input($data)
	{
		$data = trim($data);
	  	$data = stripslashes($data);
	 	$data = htmlspecialchars($data);
	  return $data;
	}
	// Validate Date
	function validateDate($data)
	{
		$actual = strtotime($data);
		if($actual)
		{
			$data = date('Y-m-d', $actual);
			return $data;
		}else{
			return -1;
	}
	// -------------------------
}

$emp_name = test_input($_POST['emp_name']);
$adress = test_input($_POST['adress']);
$ph_no = test_input($_POST['ph_no']);
$email = test_input($_POST['email']);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$id_card = test_input($_POST['id_card']);
$dep_id = test_input($_POST['dep_id']);
$grade_id = test_input($_POST['grade_id']);
$city = test_input($_POST['city']);
$dateBirth = test_input($_POST['dob']);
$join_date = test_input($_POST['join_date']);
$to_date = test_input($_POST['to_date']);
$emp_id = "";
$status = 0;

// Checking For Status
// if employee leaving date < Joining Date (invalid return back to form)
// if employee Leaving date > Joining Date (Valid and status = 1)
// if employee Leaving date = Joining Date (Valid But status = 0)
if($to_date > $join_date )
{
	$status = 1;
	echo "Status 1";
}else{
	$status = 0;
	echo "Status 0";
}
// ==================




if(empty($emp_name) || empty($adress) || empty($ph_no) || empty($email) || 
	empty($id_card) ||empty($dep_id) || empty($grade_id) || empty($dateBirth) || empty($join_date) || empty($to_date) || empty($city))
	{
		header("Location: ../adminoptions/addEmployee.php?error=emptyFields");
		exit();
	}else if(!preg_match("/^[a-zA-Z ]*$/",$emp_name)){
		header("Location: ../adminoptions/addEmployee.php?error=invalidName");
		exit();
	}else if(!preg_match('/^[a-zA-Z ]*$/',$city)){
		header("Location: ../adminoptions/addEmployee.php?error=cityNameInvalid");
		exit();
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		header("Location: ../adminoptions/addEmployee.php?error=invalidEmail");
		exit();
	}else if(!preg_match('/^[0-9]*$/',$ph_no))
	{
		header("Location: ../adminoptions/addEmployee.php?error=invalidPhno");
		exit();
	}else if($to_date < $join_date){
		header("Location: ../adminoptions/addEmployee.php?error=leaveDateinvalid");
		exit();
	}else{
		$dateBirth = validateDate($dateBirth);
		$join_date = validateDate($join_date);
		$to_date = validateDate($join_date);
		if($dateBirth== -1 || $join_date == -1 || $to_date == -1)
		{
			header("Location: ../adminoptions/addEmployee.php?error=invalidDates");
			exit();
		}
		echo "I am oki, go ahead";
		// acquring connection
		require '../includes/dbcon.inc.php';
		// All Set, connection acquired, Now here is actual game

		$sql = "SELECT idcard_no FROM EMPLOYEE_MAIN WHERE idcard_no = ?";
		$stmt = $conn->prepare($sql);
		if($stmt){
			if($stmt->bind_param("i",$id_card))
			{
				$stmt->execute();
				$result = $stmt->store_result();
				if($stmt->num_rows > 0)
				{
					header("Location: ../adminoptions/addEmployee.php?error=employeeExists&idcard=".$id_card);
					$stmt->close();
					exit();
				}else{
					$stmt->close();
					echo "Ok, lets go";
					// Ok, move ahead, from here i know this user doesnt exist

					// Now Inserting in EMPLOYEE_MAIN
					$sql = "INSERT INTO EMPLOYEE_MAIN (emp_name,birth_date,join_date,adress,city,phone_no,email_id,idcard_no)
						VALUES(?,?,?,?,?,?,?,?);
					";
					$stmt = $conn->prepare($sql);
					if($stmt)
					{
						echo "prepared";
						// insert query prepared / go ahead
						if($stmt->bind_param("sssssiss",$emp_name,$dateBirth,$join_date,$adress,$city,$ph_no,$email,$id_card))
						{
							echo "<br>Binded insert.";
							// Binded Sucess, go ahead
							if($stmt->execute())
							{
								echo "Employee Added Successfully In Main Table <br>";
								// getting emp_id i.e last_id
								$last_id = $conn->insert_id;
								echo "id is :";
								echo $last_id."<br>";
								$stmt->close(); //insert done in emp_main
								// Now inserting in emp_grade_dep_details

								$sql = "INSERT INTO emp_grade_dep_details (emp_id,dep_id,grade_id,from_date,to_date,status)
									VALUES(?,?,?,?,?,?);";
									$stmt = $conn->prepare($sql);
									if($stmt)
									{
										echo "Prepared";
										if($stmt->bind_param("iiissi",$last_id,$dep_id,$grade_id,$join_date,$to_date,$status)){
											echo "Binded Insert emp_grade_dep_details<br>";
											// Binding done , go ahead for execution
											if($stmt->execute())
											{	
												echo "Record Inserted In emp_grade_dep_details<br>";
												header("Location: ../adminoptions/addEmployee.php?success=employeeAdded");
												$stmt->close();
												exit();

											}else{
												echo "Error Execution Insert emp_grade_dep_details<br>";
												exit();
											}

										}else{
											echo "SQL ERROR BIND PARAM emp_grade_dep_details<br>";
											exit();
										}
									}else{
										echo "SQL ERROR PREPARE OF INSERT IN emp_grade_dep_details<br>";
										exit();
									}







								
							}else{
								echo "Error In SQL execute Of Insering in employee main <br>";
								echo $stmt->error;
								exit();
							}

						}else{
							echo "<BR>SQL INSERT BIND PARAM ERROR <BR>";
							exit();
						}
					}else{
						echo "<br>Not Prepared SQL INSERT QUERY EMPLOYEE_MAIN<br>";
						$stmt->error;
						exit();
					}

				}
			}else{
				$stmt->error;
				echo "SQL BIND PARAM ERROR IN FIRST SELECT .<br>";
				exit();
			}
		}else{
			echo "SQL ERROR IN 1st SELECT Prepare <br> ";
			exit();
		}

	}



$stmt->close();





// ========================




}