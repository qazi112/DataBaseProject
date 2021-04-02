
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
	<!-- <script type="text/javascript">
		var xmlhttp = new XMLHttpRequest();
   		 xmlhttp.onreadystatechange = function() {
     	 if (this.readyState == 4 && this.status == 200) {
        document.getElementById("details").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","getdepartment.php",true);
    xmlhttp.send();
	</script> -->
<script type="">
 		printing(){
 			window.print();
 		}
 	</script>

	<nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
		<a class="navbar-brand" href="http://localhost:81/practice/admin/">Go To Home Page</a>
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
  	<h1 class="text-center">Generating Salary</h1>
  		
    <label for="dept">Salary Month:</label>
    <input type="Text" class="form-control" placeholder="Enter Salary Month e.g February or Feb" id="dept" name="sal_mon">
    <label for="dept">Salary Year:</label>
    <input type="Text" class="form-control" placeholder="Enter Salary Year e.g (2014)" id="dept" name="sal_year">
    <label for="dept">Embursment Date:</label>
    <input type="Text" class="form-control" value="<?php echo(date('Y-m-d')) ?>" id="dept" name="emb_date">
  </div>

  <button type="submit" name="slip-sub" class="btn btn-primary">Get Slip</button>
</form>
		<div id="message"></div>
		</div>

		

	</div>
	
</body>
</html>

<?php 
if(isset($_POST['slip-sub'])){
	
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
}

	$sal_mon = test_input($_POST['sal_mon']);
	$sal_year = test_input($_POST['sal_year']);
	$emb_date = test_input($_POST['emb_date']);
	$emb_date = validateDate($emb_date);
	if($emb_date == -1)
	{
		echo "Invalid Date<br>";
		header("Location: finalSlipPage.php?error=invalidDate");
		exit();
	}
	// $sal_year_chk = '2019';
	// $sal = strtotime($sal_year_chk);
	// $sal_year_chk = date('Y', $sal);

	// $emb_date_chk = strtotime($emb_date);
	// $emb_date_chk = date('Y', $emb_date_chk);
	// echo $sal_year_chk;
	// if($sal_year_chk >= $emb_date_chk)
	// {
	// 	echo "Year is greater than current date";

	// }
	if(empty($sal_mon) || empty($sal_year) || empty($emb_date))
	{
		header("Location: finalSlipPage.php?error=emptyFields");
		exit();
	}else if(!preg_match("/^[a-zA-Z ]*$/",$sal_mon))
	{
		header("Location: finalSlipPage.php?error=invalidMonthName");
		exit();
	}else if(!preg_match("/^[0-9 ]*$/",$sal_year))
	{
		header("Location: finalSlipPage.php?error=invalidYearName");
		exit();
	}else{
		$sal_mon = strtolower($sal_mon);
		$sql = "SELECT * FROM emp_salary_details WHERE emp_id = ? AND sal_year = ? AND sal_month = ? ;"; 
		$stmt = $conn->prepare($sql);
		if($stmt){
			echo "Prepared";
			$stmt->bind_param("iss",$emp_id,$sal_year,$sal_mon);
			$stmt->error;
			$stmt->execute();
			$stmt->error;
			$result = $stmt->get_result();
			if($result->num_rows > 0)
			{
				// If user record of salary of this specific month in year is already there , so dont
				// insert in emp_salary_details , only show to user
				$message = "This Slip Is Already Generated , Here Is Copy";
				echo "Salary Of this This Month in year is already Generated";
				$row = $result->fetch_assoc();
				$sal_mon = $row['sal_month'];
				$sal_year = $row['sal_year'];
				$emb_date = $row['emburt_date'];
				$emp_gross = $row['emp_gross'];
				$emp_total = $row['emp_total'];
				require 'slipformat.php';
				echo '<script type="text/JavaScript">  
     				alert("Slip Copy Generated As This Slip is already taken! Scroll Down"); 
    				 </script>' ; 

				// require_once 'C:\Users\Qazi Arsalan\vendor\autoload.php';
				// $mpdf = new \Mpdf\Mpdf();
				// $mpdf->WriteHTML('<html><h1>Hello world!</h1></html>');
				// ob_clean();
				// $mpdf->Output(); 
								
			

								
				
				
			}else{
				$stmt->close();
				$emp_gross = $grade_basic + $grade_ta + $grade_ma + $grade_bonus;
				$emp_total = $emp_gross - ($grade_hr + $grade_ptax);
				$sql = "INSERT INTO emp_salary_details (emp_id,dep_id,grade_id,sal_month,sal_year,emburt_date,emp_gross,emp_total)
					VALUES(?,?,?,?,?,?,?,?)";
					$message = "";
				$stmt = $conn->prepare($sql);
				if($stmt){
					$stmt->bind_param("iiisssii",$emp_id,$dep_id,$grade_id,$sal_mon,$sal_year,$emb_date,$emp_gross,$emp_total);
					$stmt->error;
					$stmt->execute();
					$stmt->error;
					require 'slipformat.php';
					echo '<script type="text/JavaScript">  
     				alert("Original Slip Generated (New record)"); 
    				 </script>' ; 

					

				}else{
					echo "Error SQL INSERT ";
					$conn->error;
					exit();
				}

			}
			
		}else{
			var_dump($stmt);
			echo "Not Prepared Select For Check";
			
			exit();
		}	
	}

}
	// -------------------------
