<!-- db insert -->
<?php 
	// make connection
	include "connect.php";

	//initialize vars
	$firstName = $_POST['firstName'];
	$secondName = $_POST['secondName'];
	$lastName = $_POST['lastName'];
	$patientId = $_POST['patientId'];
	//$patientId = intval($patientId1);
	$department = $_POST['department'];
	$exception = $_POST['exception'];
	$datePatient = date($_POST['datePatient']);
	$newDate = date("Y-m-d", strtotime($datePatient));
	$about = $_POST['about'];
	
	mysql_query("SET names utf8");
	
	// INSERT set sent to 'ДА', because we dont have sentReport.html active...
	$q = "INSERT INTO 
		  patients(firstName, secondName, lastName, patientId, department, exception, date, about, sent)
		  VALUES
		  ('$firstName','$secondName','$lastName','$patientId','$department','$exception','$newDate','$about','ДА')";
		  
	$r = mysql_query($q);
	
	if($r) {
		//echo '<h1>insert success</h1>'; 
		
	}
	else {
		echo mysql_error();
	}
?> 