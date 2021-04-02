<?php 
// Called from generate Slip to get Grade payment details.
// Here i received dep_id and grade_id
$grade_id = intval($grade_id);
$sql = "SELECT * from GRADE_MAIN WHERE grade_id = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$grade_id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows <=0)
{
	header("Location: ../adminoptions/payroll.php?error=inValidGradeId");
	exit();
}else{
	// All set , now get All Data
	$row = $result->fetch_assoc();
	//var_dump($row);
	$grade_basic = $row['basic'] ;
	$grade_ta = $row['grade_ta'];
	$grade_ma = $row['grade_ma'];
	$grade_bonus = $row['bonus'];
	$grade_hr = $row['grade_hr'];
	$grade_ptax = $row['grade_ptax'];
	// Now idea is , gross = basic+ta+da+bonus
	// Total_salary = gross - (hr+ptax); Idea taken from Papa's salary slip

}
