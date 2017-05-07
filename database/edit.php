<!-- db edit -->
<?php 
	// make connection
	include "connect.php";

	$status = $_GET["status"];
	
	//initialize vars
	$patientId = $_GET['patientId']; //POST
	$datePatient2 = $_GET['datePatient2']; //POST
	$datePatient3 = $_GET['datePatient3']; // POST
		
		
		
	if ($patientId == '' && $datePatient2 == '' && $datePatient3 == '') {
			
		$q = "SELECT * from patients";
			
	} else if ($patientId != '' && $datePatient2 == '' && $datePatient3 == '') {
			
		$q = "SELECT * from patients where patientId='$patientId'";
			
	} else if ($patientId != '' && $datePatient2 != '' && $datePatient3 == '') {
			
		$newDatePatient2 = date("Y-m-d", strtotime($datePatient2));
		$todayDate = date("Y-m-d");
		$q = "SELECT * from patients where patientId='$patientId' AND date >= '$newDatePatient2' AND date <= '$todayDate'";
			
	} else if ($patientId != '' && $datePatient2 != '' && $datePatient3 != '') {
			
		$newDatePatient2 = date("Y-m-d", strtotime($datePatient2));
		$newDatePatient3 = date("Y-m-d", strtotime($datePatient3));
		$q = "SELECT * from patients where patientId='$patientId' AND date >= '$newDatePatient2' AND date <= '$newDatePatient3'";
		
	} else if ($patientId == '' && $datePatient2 != '' && $datePatient3 != '') {
			
		$newDatePatient2 = date("Y-m-d", strtotime($datePatient2));
		$newDatePatient3 = date("Y-m-d", strtotime($datePatient3));
		$q = "SELECT * from patients where date >= '$newDatePatient2' AND date <= '$newDatePatient3'";
		
	}  else if ($patientId == '' && $datePatient2 != '' && $datePatient3 == '') {
			
		$newDatePatient2 = date("Y-m-d", strtotime($datePatient2));
		$todayDate = date("Y-m-d");
		$q = "SELECT * from patients where date >= '$newDatePatient2' AND date <= '$todayDate'";
		
	}
	
	
	if($status == "disp") {
		
		$output .= '<div class = "table-responsive">
						<table id="editTable" class="table table bordered">
							<tr>
								<th>Име</th>
								<th>Презиме</th>
								<th>Фамилия</th>
								<th>ЕГН</th>
								<th>Отделение</th>
								<th>Изключение</th>
								<th>Дата</th>
								<th>Изпратено</th>
							</tr>';
		

		mysql_query("SET names utf8");
		$r = mysql_query($q);
		
		while($row = mysql_fetch_array($r)) {
			
			$output .= '
				<tr>
					<td align="left" class="col-md-2"><div id="name'.$row["id"].'">'.$row["firstName"].'</div></td>
					<td align="left" class="col-md-2"><div id="secondName'.$row["id"].'">'.$row["secondName"].'</div></td>
					<td align="left" class="col-md-2"><div id="lastName'.$row["id"].'">'.$row["lastName"].'</div></td>
					<td align="left" class="col-md-2"><div id="patientId'.$row["id"].'">'.$row["patientId"].'</div></td>
					<td align="left" class="col-md-2"><div id="department'.$row["id"].'">'.$row["department"].'</div></td>
					<td align="left" class="col-md-2"><div id="exception'.$row["id"].'">'.$row["exception"].'</div></td>
					<td align="left" class="col-md-2"><div id="date'.$row["id"].'">'.date("d-m-Y", strtotime($row["date"])).'</div></td>
					<td align="left" class="col-md-2"><div id="sent'.$row["id"].'">'.$row["sent"].'</div></td>
					<td align="left">
						<!-- <input type="button" id="'.$row["id"].'" value="Редакция" class="btn btn-success" onClick="editFunc(this.id)"> Disabled -->
						<input type="button" id="update'.$row["id"].'" name="'.$row["id"].'" value="Запази" style="visibility:hidden" class="btn btn-info" onClick="updateFunc(this.id)">
					</td>
				</tr>';
			
		}
		
		echo $output;
	
	} else {
		// Error connection
	}
	
	if ($status == "update") {
		// make connection
		include "connect.php";
		
		//initialize vars
		$id = $_GET['id'];
		$firstName = $_GET['firstName'];
		$secondName = $_GET['secondName'];
		$lastName = $_GET['lastName'];
		$patientId = $_GET['patientId'];
		$department = $_GET['department'];
		$exception = $_GET['exception'];
		$date = $_GET['date'];
		$newDate = date("Y-m-d", strtotime($date));
		
		$firstName = trim($firstName);
		$secondName = trim($secondName);
		$lastName = trim($lastName);
		$patientId = trim($patientId);
		$department = trim($department);
		$exception = trim($exception);
		$newDate = trim($newDate);
		
		mysql_query("SET names utf8");
		$q = "UPDATE patients set firstName='$firstName', secondName='$secondName', lastName='$lastName', patientId='$patientId', department='$department',
			exception='$exception', date='$newDate' where id='$id'";
		$r = mysql_query($q);
		
	} else {
		// Error connection
	}
	
?> 