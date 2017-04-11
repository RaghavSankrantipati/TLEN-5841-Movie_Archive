<?php
session_start();
session_regenerate_id();

include_once('/var/www/html/project/project-lib.php');
include_once('/var/www/html/project/header.php');

connect($db);

switch($s){
	case 0:
	default:
        echo"<center><h2> Add user to database</h2> </center>";
        echo "<form method=post action=register.php?s=1>
			  <center>
              User name: <input type=\"text\" name=\"u_name\"><br>
              Password:  <input type=\"password\" name=\"u_paswd1\"><br>
			  Re-enter Password:  <input type=\"password\" name=\"u_paswd2\"><br>
              Email:     <input type=\"text\" name=\"u_email\">
              <br><input type=\"submit\" value=\"Submit\"/></p>
              </center>
              </form>";
    break;
	
	case 1:
	    $u_name = mysqli_real_escape_string($db, $u_name);
        $u_paswd1 = mysqli_real_escape_string($db, $u_paswd1);
        $u_email = mysqli_real_escape_string($db, $u_email);
		$u_paswd2 = mysqli_real_escape_string($db, $u_paswd2);
		
		$salt = hash('sha256', "secureweb");
      	$password = hash('sha256', $u_paswd1.$salt);
		
		if($u_paswd1 == $u_paswd2) {		
			if($stmt = mysqli_prepare($db, "insert into users set userid='', username=?, password=?, salt=?, email=?")) {
				mysqli_stmt_bind_param($stmt, "ssss", $u_name, $password, $salt, $u_email);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			} else { echo "unable to prepare"; }
			echo "<center>$u_name is added to database</center>";
		} else {
				echo "<center> Passwords doesn't match
				<a href = register.php?s=0> Re-enter details </a>
				</center>";
		}
              
		break;
}
?>