<?php
session_start();

include_once('/var/www/html/project/project-lib.php');
include_once('/var/www/html/project/header.php');

connect($db);

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
			<td> <a href = comment.php?s=1&movie_id=$row[0]> $row[1] </td> </center> </tr> \n";
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
			echo"<center><h2> Review $title</h2> </center>";
			}
		mysqli_stmt_close($stmt);
		}
		
		echo "<form method=post action=comment.php?s=2&movie_id=$movie_id>
		<center>
		Review: <textarea name=\"comment\" rows=\"5\" cols=\"40\"></textarea><<br>
		<br><input type=\"submit\" value=\"Submit\"/></p>
		</center>
		</form>";
		break;
		
	case 2:
		icheck($s);
		icheck($movie_id);
		icheck($comment);
		$movie_id = mysqli_real_escape_string($db, $movie_id);
		$comment = mysqli_real_escape_string($db, $comment);
		
		if($stmt = mysqli_prepare($db, "UPDATE comment set comment=?, movie_id=?")) {
			mysqli_stmt_bind_param($stmt, "sss", $comment, $movie_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		
		echo " <center> User Review updated</center>";
	break;
}
echo "<center> <a href=logout.php?logout=0> logout </a> </center>"; 
?>