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
						<table class="table table bordered">
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
						<input type="button" id="'.$row["id"].'" value="Изпрати" class="btn btn-success" onClick="sentFunc(this.id)">
					</td>
				</tr>';
			
		}
		
		echo $output;
	
	} else {
		// Error connection
	}
	
	//Chaneged for send value to work we have to add about value in GET request
	if ($status == "sent") {
		// make connection
		//include "connect.php";
		
		//initialize vars
		//$id = $_GET['id'];
		$firstName = $_GET['firstName'];
		$secondName = $_GET['secondName'];
		$lastName = $_GET['lastName'];
		$patientId = $_GET['patientId'];
		$department = $_GET['department'];
		$exception = $_GET['exception'];
		$about = $_GET['about'];
		$date = $_GET['date'];
	
		
		$firstName = trim($firstName);
		$secondName = trim($secondName);
		$lastName = trim($lastName);
		$patientId = trim($patientId);
		$department = trim($department);
		$exception = trim($exception);
		$about = trim($about);
		//$newDate = trim($newDate);
		
		//mysql_query("SET names utf8");
		//$q = "UPDATE patients set sent='ДА' where id='$id'";
		//$r = mysql_query($q);
		
		
		//sending email
		ini_set('SMTP','192.168.1.202');
		ini_set('smtp_port','25');
		$to = 'borislav.koprinski@hospitalruse.org, briz@hospitalruse.org';
		$subject = 'Пациенти Бриз';
		$body = 'ДО'."\r\n"
				.'ЕКИПА ЗА ВЪЗНИКНАЛИ'."\r\n"
				.'ЗАТРУДНЕНИЯ ПРИ АВТЕНТИФИКАЦИЯ'."\r\n"
				.'НА ПАЦИЕНТИ НА МБАЛ – РУСЕ АД'."\r\n"
				.'РАЙОННА ЗДРАВНООСИГУРИТЕЛНА КАСА – РУСЕ'."\r\n"."\r\n"
				.'	Във връзка с Инструкция за работа с „Регистрационната система на здравноосигурителни събития при изпълнители на медицинска помощ” и реда за осъществяване на контрол от РЗОК на изпълнителите на болнична медицинска помощ по прилагане на разпоредбите на чл. 2, ал. 5 от Наредба за осъществяване правото на достъп до медицинска помощ и чл. 38 от Решение № РД-НС-04-24-1/29.03.2016 г. по чл. 54, ал. 9 и чл. 59а, ал. 6 от ЗЗО на НС на НЗОК,'."\r\n"
				.'	Ви уведомявам незабавно, че при автентификацията на пациент: '.$firstName.' '.$secondName.' '.$lastName.' ,'."\r\n"
				.'ЕГН: '.$patientId.', в Отделение: '.$department.', постъпил/а за лечение на: '.$date."\r\n"
				.'възникна затруднение от следния характер: '.$exception."\r\n"
				.'Причина: '.$about."\r\n"."\r\n"
				.'МБАЛ Русе АД'."\r\n"
				.'тел. 082/887 292'."\r\n"
				.'hospital@hospitalruse.org'."\r\n";
		
		//$headers = 'From: briz@hospitalruse.org';
		
		// To send HTML mail, the Content-type header must be set
		$CONFIG_MAIL_FROM = 'briz@hospitalruse.org';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";

		// Additional headers
		$headers .= 'From: ' . $CONFIG_MAIL_FROM . "\r\n";
		$headers .= 'Content-Transfer-Encoding: 7bit' . "\r\n";
	
		if (mail($to, $subject, $body, $headers)) {
			echo 'Email has been send to '.$to;
		} else {
			echo 'There was an error sending';
		}
		
	} else {
		// Error connection
	}
	
	if ($status == "sentAll") {
		// make connection
		include "connect.php";
		
		mysql_query("SET names utf8");
		$q = "SELECT * from patients";
		$r = mysql_query($q);
		
		$outputEmail = '';
		
		while($row = mysql_fetch_array($r)) {
			
			//initialize vars
			$id = $row["id"];
			$firstName = $row["firstName"];
			$secondName = $row["secondName"];
			$lastName = $row["lastName"];
			$patientId = $row["patientId"];
			$department = $row["department"];
			$exception = $row["exception"];
			//$date = date("d-m-Y", strtotime($row["date"]);
			$sendId = $row["sent"];
			
			if ($sendId != 'ДА') {
				
				$q2 = "UPDATE patients set sent='ДА' where id='$id'";
				$r2 = mysql_query($q2);

				$outputEmail .= 'Име - '.$firstName."\r\n"
							 .'Презиме - '.$secondName."\r\n"
							 .'Фамилия - '.$lastName."\r\n"
							 .'--------------------------------------------------------------'."\r\n";
				
				//sending email
				//ini_set('SMTP','192.168.1.202');
				//ini_set('smtp_port','25');
				//$to = 'borislav.koprinski@hospitalruse.org';
				//$subject = 'Пациенти Бриз';
				//$body = 'Име - '.$firstName."\r\n"
				//		.'Презиме - '.$secondName."\r\n"
				//		.'Фамилия - '.$lastName."\r\n";
		
			
				// To send HTML mail, the Content-type header must be set
				//$CONFIG_MAIL_FROM = 'briz@hospitalruse.org';
				//$headers  = 'MIME-Version: 1.0' . "\r\n";
				//$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";

				// Additional headers
				//$headers .= 'From: ' . $CONFIG_MAIL_FROM . "\r\n";
				//$headers .= 'Content-Transfer-Encoding: 7bit' . "\r\n";
	
				//if (mail($to, $subject, $body, $headers)) {
				//	echo 'Email has been send to '.$to;
				//} else {
				//	echo 'There was an error sending';
				//}
				
			} else {
				// message already sent
			}
			
		}
		
		if ($outputEmail != '') {
			
			//sending email
			ini_set('SMTP','192.168.1.202');
			ini_set('smtp_port','25');
			$to = 'borislav.koprinski@hospitalruse.org';
			$subject = 'Пациенти Бриз';
			$body = 'Име - '.$firstName."\r\n"
					.'Презиме - '.$secondName."\r\n"
					.'Фамилия - '.$lastName."\r\n";
		
			
			// To send HTML mail, the Content-type header must be set
			$CONFIG_MAIL_FROM = 'briz@hospitalruse.org';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";

			// Additional headers
			$headers .= 'From: ' . $CONFIG_MAIL_FROM . "\r\n";
			$headers .= 'Content-Transfer-Encoding: 7bit' . "\r\n";
	
			if (mail($to, $subject, $outputEmail, $headers)) {
				echo 'Email has been send to '.$to;
			} else {
				echo 'There was an error sending';
			}

		}
			
	}
	
	
?> 