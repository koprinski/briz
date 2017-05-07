<!-- db connection -->
<?php 
	//MySql settings
	define('mysql_host','localhost');
	define('mysql_name','briz');
	define('mysql_user','root');
	define('mysql_password','');
   
	//connection
	$db = mysql_connect (mysql_host, mysql_user, mysql_password); 
	
	if($db) {
		$select_db = mysql_select_db (mysql_name);
		if($select_db) {
			//echo "Database connected!";
		} else {
			echo mysql_error();
		}
	}
	else {
		echo mysql_error();
	}
	
?> 
