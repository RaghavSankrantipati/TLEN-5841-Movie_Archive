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
		echo"<center><h2> Add movie</h2> </center>";
		echo "<form method=post action=add_movie.php?s=1>
		<center>
		Title:     <input type=\"text\" name=\"m_title\"><br>
		Language:  <input type=\"text\" name=\"m_language\"><br>
		Genre:     <input type=\"text\" name=\"m_genre\"><br>
		Year of Release:   <input type=\"number\" name=\"m_year\"><br>
		Picture url:       <input type=\"text\" name=\"m_url\"><br>
		Plot:      <textarea name=\"m_plot\" rows=\"5\" cols=\"40\"></textarea><br>
		Rate:      <input type=\"radio\" name=\"m_rate\" value=\"1\">1
			       <input type=\"radio\" name=\"m_rate\" value=\"2\">2
				   <input type=\"radio\" name=\"m_rate\" value=\"3\">3
				   <input type=\"radio\" name=\"m_rate\" value=\"4\">4
				   <input type=\"radio\" name=\"m_rate\" value=\"5\">5
		Review:    <textarea name=\"m_comment\" rows=\"5\" cols=\"40\"></textarea><br>
					<br> <br> <br>
					Enter Cast
		Name: <input type=\"text\" name=\"m_first_name1\"> <input type=\"text\" name=\"m_last_name1\"> Character: <input type=\"text\" name=\"m_character1\"><br>
		Name: <input type=\"text\" name=\"m_first_name2\"> <input type=\"text\" name=\"m_last_name2\"> Character: <input type=\"text\" name=\"m_character2\"><br>
		Name: <input type=\"text\" name=\"m_first_name3\"> <input type=\"text\" name=\"m_last_name3\"> Character: <input type=\"text\" name=\"m_character3\"><br>
					Enter Crew
		Director Name: <input type=\"text\" name=\"m_director_first\"> <input type=\"text\" name=\"m_director_last\"> <br>
		Writer Name: <input type=\"text\" name=\"m_writer_first\"> <input type=\"text\" name=\"m_writer_last\"> <br>
		Music Director Name: <input type=\"text\" name=\"m_music_first\"> <input type=\"text\" name=\"m_music_last\"> <br>		
		<br><input type=\"submit\" value=\"Submit\"/></p>
		</center>
		</form>";
		break;
		
	case 1:
		$a =  person_exists($m_first_name1, $m_last_name1);
		$b =  person_exists($m_first_name2, $m_last_name2);
		$c =  person_exists($m_first_name3, $m_last_name3);
		$d =  person_exists($m_director_first, $m_director_last);
		$e =  person_exists($m_writer_first, $m_writer_last);
		$f =  person_exists($m_music_first, $m_music_last);
		if($a==0 && $b==0 && $c==0 && $d==0 && $e==0 && $f==0){
			echo "<center>Information of these guys aren't available in database. Please add the person and then add movies <br>
				  <a href = add_person.php?s=0> Add Person </a> <center>";
		}else{
			icheck($s);

			$m_title = mysqli_real_escape_string($db, $m_title);
			$m_language = mysqli_real_escape_string($db, $m_language);
			$m_genre = mysqli_real_escape_string($db, $m_genre);
			$m_year = mysqli_real_escape_string($db, $m_year);
			$m_url = mysqli_real_escape_string($db, $m_url);
			$m_plot = mysqli_real_escape_string($db, $m_plot);
			$m_rate = mysqli_real_escape_string($db, $m_rate);
			$m_comment = mysqli_real_escape_string($db, $m_comment);
			$m_character1 = mysqli_real_escape_string($db, $m_character1);
			$m_character2 = mysqli_real_escape_string($db, $m_character2);
			$m_character3 = mysqli_real_escape_string($db, $m_character3);
			
			if($stmt = mysqli_prepare($db, "INSERT INTO movies set idmovies='', title=?, year=?, language=?, picture=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_title, $m_year, $m_language, $m_url);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "select idmovies from movies where title=? order by idmovies desc limit 1")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_title);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $m_id);
				while(mysqli_stmt_fetch($stmt)) {
				$m_id = htmlspecialchars($m_id);
				$m_id = $m_id;
				}
			}
			
			if($stmt = mysqli_prepare($db, "INSERT INTO cast set idcast='', idmovies=?, idperson=?, character=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_id, $a, $m_character1);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "INSERT INTO cast set idcast='', idmovies=?, idperson=?, character=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_id, $b, $m_character2);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "INSERT INTO cast set idcast='', idmovies=?, idperson=?, character=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_id, $c, $m_character3);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "INSERT INTO crew set idcrew='', idmovies=?, idperson=?, position=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_id, $d, Director);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "INSERT INTO crew set idcrew='', idmovies=?, idperson=?, position=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_id, $e, Writer);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "INSERT INTO crew set idcrew='', idmovies=?, idperson=?, position=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_id, $f, Music Director);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "INSERT INTO comment set idcomment='', idmovies=?, comment=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_id, $m_comment);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "INSERT INTO movie_plot set idmovie_plot='', idmovies=?, plot=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_id, $m_plot);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "INSERT INTO movies_genre set idmovies_genre='', idmovies=?, genre=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_id, $m_genre);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			if($stmt = mysqli_prepare($db, "INSERT INTO rate set idrate='', idmovies=?, rate=?")) {
				mysqli_stmt_bind_param($stmt, "sss", $m_id, $m_rate);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			
			echo " $m_title is updated into databse";
		}
		break;
}

echo "<center> <a href=logout.php?logout=0> logout </a> </center>"; 
?>