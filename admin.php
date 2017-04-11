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

admin_check();

switch($s){
	case 1:
		icheck($s);
		echo "<center><h2> All Users</h2></center>";
		$query = "select username from users";
		$result = mysqli_query($db, $query);
		while($row = mysqli_fetch_row($result)) {
			$row[0] = htmlspecialchars($row[0]);
			echo "<center> <table> <td> $row[0] </td> </table> </center>"; 	
		}
	break;
	
	case 2:		
        echo " <center><h2> Failed Logins</h2> </center>";
        $query = "SELECT ip, date from login";
        $result = mysqli_query($db, $query);
        while($row = mysqli_fetch_row($result)) {
            $row[0] = htmlspecialchars($row[0]);
            $row[1] = htmlspecialchars($row[1]);
            echo" <br> <tr> <center>
            <td> $row[0] </td> <td> $row[1] </td> </center> </tr> \n";
 
        }
		break;
		
	case 3:
		echo"<center><h2> Delete user from database</h2> </center>";
        echo "<form method=post action=admin.php?s=4>
			  <center>
              User name: <input type=\"text\" name=\"au_name\"><br> 
			  Retype User name <input type=\"text\" name=\"au_name1\"><br> 
              <br><input type=\"submit\" value=\"Submit\"/></p>
              </center>
              </form>";
    break;
	
	case 4: 
		$au_name = mysqli_real_escape_string($db, $au_name);
		$au_name1 = mysqli_real_escape_string($db, $au_name1);
		if($au_name == $au_name1) {
		if($stmt = mysqli_prepare($db, "DELETE FROM users where username=?")) {
			mysqli_stmt_bind_param($stmt, "s", $au_name);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} 
		echo "$au_name is deleted from Database"; 
		}
		
	case 5:
		echo"<center><h2> Delete movie from database</h2> </center>";
        echo "<form method=post action=admin.php?s=6>
			  <center>
              Movie Name: <input type=\"text\" name=\"am_name\"><br>      
              Retype Movie Name: <input type=\"text\" name=\"am_name1\"><br> 			  
              <br><input type=\"submit\" value=\"Submit\"/></p>
              </center>
              </form>";
    break;
	
	case 6: 
		$am_name = mysqli_real_escape_string($db, $am_name);
		$am_name1 = mysqli_real_escape_string($db, $am_name1);
		if($am_name == $am_name1) {
		if($stmt = mysqli_prepare($db, "DELETE FROM movies where title=?")) {
			mysqli_stmt_bind_param($stmt, "s", $am_name);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		} 
		echo "$au_name is deleted from Movies"; 
		}
}
echo "<center> <a href=logout.php?logout=0> logout </a> </center>"; 
	
?>
		