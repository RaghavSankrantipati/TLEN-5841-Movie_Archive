<?php
session_start();

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
		echo " <center><h2> Movies</h2> </center>";
		$query = "select idmovies, title from movies";
		$result = mysqli_query($db, $query);
		while($row = mysqli_fetch_row($result)) {
			$row[0] = htmlspecialchars($row[0]);
			$row[1] = htmlspecialchars($row[1]);
			echo" <br> <tr> <center> 
			<td> <a href = rate.php?s=1&movie_id=$row[0]> $row[1] </td> </center> </tr> \n";
		}	
	break;
	
	case 1:
		icheck($s);
		icheck($movie_id);
		$movie_id = mysqli_real_escape_string($db, $movie_id);
		if($stmt = mysqli_prepare($db, "select title from movies where idmovies=?")) {
			mysqli_stmt_bind_param($stmt, "s", $movie_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $title);
			while(mysqli_stmt_fetch($stmt)) {
			$title = htmlspecialchars($title);
			echo"<center><h2> Rate $title</h2> </center>";
			}
		mysqli_stmt_close($stmt);
		}
		
		echo "<form method=post action=rate.php?s=2&movie_id=$movie_id>
		<center>
		Rate:      <input type=\"radio\" name=\"rate\" value=\"1\">1
			       <input type=\"radio\" name=\"rate\" value=\"2\">2
				   <input type=\"radio\" name=\"rate\" value=\"3\">3
				   <input type=\"radio\" name=\"rate\" value=\"4\">4
				   <input type=\"radio\" name=\"rate\" value=\"5\">5
		<br><input type=\"submit\" value=\"Submit\"/></p>
		</center>
		</form>";
		break;
		
	case 2:
		icheck($s);
		icheck($movie_id);
		icheck($rate);
		$movie_id = mysqli_real_escape_string($db, $movie_id);
		$rate = mysqli_real_escape_string($db, $rate);
		if($stmt = mysqli_prepare($db, "select rate from rate where idmovies=?")) {
			mysqli_stmt_bind_param($stmt, "s", $movie_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $rate1);
			while(mysqli_stmt_fetch($stmt)) {
			$rate1 = htmlspecialchars($rate1);
			}
		mysqli_stmt_close($stmt);
		}	

		if($rate!=null) {
			$rate = ($rate1 + $rate)/2;
		} 
		
		if($stmt = mysqli_prepare($db, "UPDATE rate set rate=?, movie_id=?")) {
			mysqli_stmt_bind_param($stmt, "sss", $rate, $movie_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		
		echo " <center> Rating updated</center>";
	break;
}
echo "<center> <a href=logout.php?logout=0> logout </a> </center>"; 
	
?>