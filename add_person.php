<?php
session_start();
session_regenerate_id();

include_once('/var/www/html/project/project-lib.php');
include_once('/var/www/html/project/header.php');

connect($db);

check_login($db);
if(!isset($_SESSION['authenticated'])){
	authenticate($db, $user_name, $user_paswd);
} 

switch($s) {
	
	case 0:
	default:
		echo"<center><h2> Add person</h2> </center>";
		echo "<form method=post action=add_person.php?s=1>
		<center>
		First name: <input type=\"text\" name=\"p_first_name\"><br>
		Last name:  <input type=\"text\" name=\"p_last_name\"><br>
		Gender:     <input type=\"radio\" name=\"p_gender\" value=\"Male\">Male
			        <input  type=\"radio\" name=\"p_gender\" value=\"Female\">Female<br>
		Details: 	<input type=\"text\" name=\"p_details\"><br>
		Picture_url:<input type=\"text\" name=\"p_url\"><br>					
		<br><input type=\"submit\" value=\"Submit\"/></p>
		</center>
		</form>";
		break;
	
	case 1:
		icheck($s);
		$a =  person_exists($p_first_name, $p_last_name);
		if($a==0){

			$p_first_name = mysqli_real_escape_string($db, $p_first_name);
			$p_last_name = mysqli_real_escape_string($db, $p_last_name);
			$p_gender = mysqli_real_escape_string($db, $p_gender);
			$p_details = mysqli_real_escape_string($db, $p_details);
			$p_url = mysqli_real_escape_string($db, $p_url);
			
			if($stmt = mysqli_prepare($db, "INSERT INTO person set idperson='', first_name=?, last_name=?, gender=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $p_first_name, $p_last_name, $p_gender);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "select idperson from person where first_name=? and last_name =? and gender =?")) {
				mysqli_stmt_bind_param($stmt, "sss", $p_first_name, $p_last_name, $p_gender);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $p_id);
				while(mysqli_stmt_fetch($stmt)) {
				$p_id = htmlspecialchars($p_id);
				$p_id = $p_id;
				}
			}	
			
			if($stmt = mysqli_prepare($db, "INSERT INTO person_details set idperson_details='', idperson=?, details=?, picture=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $p_id, $p_details, $p_url);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
		
		echo"<br> $p_first_name $p_last_name is successfully updated into Database";
	} else {
		echo "<br> $p_first_name $p_last_name already exists in Database"
	}
	break;
}

echo "<center> <a href=logout.php?logout=0> logout </a> </center>"; 
?>		