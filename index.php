<?php

include_once('/var/www/html/project/project-lib.php');
include_once('/var/www/html/project/header.php');

connect($db);

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
			<td> <a href = index.php?s=1&movie_id=$row[0]> $row[1] </td> </center> </tr> \n";
		}	
	break;
	
	case 1:
		icheck($s);
		icheck($movie_id);
		$movie_id = mysqli_real_escape_string($db, $movie_id);
		if($stmt = mysqli_prepare($db, "select a.title, a.picture,a.year, a.language, b.plot, c.genre, d.rate, e.comment from movies a, movie_plot b, movies_genre c, rate d, comment e where a.idmovies = b.idmovies and a.idmovies = c.idmovies and a.idmovies = d.idmovies and a.idmovies = e.idmovies and a.idmovies=?")) {
			mysqli_stmt_bind_param($stmt, "s", $movie_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $title, $picture, $year, $language, $plot, $genre, $rate, $comment);
		while(mysqli_stmt_fetch($stmt)) {
			$picture = htmlspecialchars($picture);
			$title = htmlspecialchars($title);
			$plot = htmlspecialchars($plot);
			$language = htmlspecialchars($language);
			$year = htmlspecialchars($year);
			$genre = htmlspecialchars($genre);
			$rate = htmlspecialchars($rate);
			$comment = htmlspecialchars($comment);
			echo " <center><h2> $title</h2> </center>
			<br><p>
			<img src=\"$picture\" alt="Smiley face" style="float:left;width:300px;height:200px;">
			$plot
			</p>
			<center> Release Year: $year<br>
					 Language: $language<br>
					 Genre: $Genre<br>
					 Rating: $rate<br>
					 User Review: $comment<br></center>";
		}
		mysqli_stmt_close($stmt);
		}

		if($stmt = mysqli_prepare($db, "select a.idperson, a.character, b.first_name, b.last_name from cast a, person b where a.idperson = b.idperson and a.idmovies =?")) {
			mysqli_stmt_bind_param($stmt, "s", $movie_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $cast_id, $character, $first_name, $last_name);
		while(mysqli_stmt_fetch($stmt)) {
			$cast_id = htmlspecialchars($cast_id);
			$character = htmlspecialchars($character);
			$first_name = htmlspecialchars($first_name);
			$last_name = htmlspecialchars($last_name);
			echo " <br>";
            echo " <tr> <td> <a href = index.php?s=2&cast_id=$cast_id>$first_name $last_name</a> </td>
						<td> $character </td></tr> \n";
		}
		mysqli_stmt_close($stmt);
		}
		
		if($stmt = mysqli_prepare($db, "select a.idperson, a.position, b.first_name, b.last_name from crew a, person b where a.idperson = b.idperson and a.idmovies =?")) {
			mysqli_stmt_bind_param($stmt, "s", $movie_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $crew_id, $position, $first_name, $last_name);
		while(mysqli_stmt_fetch($stmt)) {
			$crew_id = htmlspecialchars($crew_id);
			$position = htmlspecialchars($position);
			$first_name = htmlspecialchars($first_name);
			$last_name = htmlspecialchars($last_name);
			echo " <br>";
            echo " <tr> <td> <a href = index.php?s=3&crew_id=$crew_id>$first_name $last_name</a> </td>
						<td> $position </td></tr> \n";
		}
		mysqli_stmt_close($stmt);
		}
	break;
	
	case 2:
		icheck($s);
		icheck($cast_id);
		$cast_id = mysqli_real_escape_string($db, $cast_id);
		
		if($stmt = mysqli_prepare($db, "select a.first_name, a.last_name, b.details, b.picture from person a, person_details b where a.idperson = b.idperson and a.idperson =?")) {
			mysqli_stmt_bind_param($stmt, "s", $cast_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $first_name, $last_name, $details, $picture);
		while(mysqli_stmt_fetch($stmt)) {
			$picture = htmlspecialchars($picture);
			$details = htmlspecialchars($details);
			$first_name = htmlspecialchars($first_name);
			$last_name = htmlspecialchars($last_name);
			echo " <center><h2> $first_name $last_name</h2> </center>
			<br><p>
			<img src=\"$picture\" alt="Smiley face" style="float:left;width:300px;height:200px;">
			$details
			</p>";
		}
		mysqli_stmt_close($stmt);
		}
		
		if($stmt = mysqli_prepare($db, "select a.idmovies,a.character, b.title from cast a, movies b where a.idmovies = b.idmovies and a.idperson=?")) {
			mysqli_stmt_bind_param($stmt, "s", $cast_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $movie_id, $character, $title);
		while(mysqli_stmt_fetch($stmt)) {
			$character = htmlspecialchars($character);
			$title = htmlspecialchars($title);
			$movie_id = htmlspecialchars($movie_id);
			echo " <br>";
            echo " <tr> <td> <a href = index.php?s=1&movie_id=$movie_id>$title</a> </td>
						<td> $character </td></tr> \n";

		}
		mysqli_stmt_close($stmt);
		}
	break;
	
	case 3:
		icheck($s);
		icheck($crew_id);
		$cast_id = mysqli_real_escape_string($db, $crew_id);
		
		if($stmt = mysqli_prepare($db, "select a.first_name, a.last_name, b.details, b.picture from person a, person_details b where a.idperson = b.idperson and a.idperson =?")) {
			mysqli_stmt_bind_param($stmt, "s", $crew_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $first_name, $last_name, $details, $picture);
		while(mysqli_stmt_fetch($stmt)) {
			$picture = htmlspecialchars($picture);
			$details = htmlspecialchars($details);
			$first_name = htmlspecialchars($first_name);
			$last_name = htmlspecialchars($last_name);
			echo " <center><h2> $first_name $last_name</h2> </center>
			<br><p>
			<img src=\"$picture\" alt="Smiley face" style="float:left;width:300px;height:200px;">
			$details
			</p>";
		}
		mysqli_stmt_close($stmt);
		}
		
		if($stmt = mysqli_prepare($db, "select a.idmovies,a.position, b.title from crew a, movies b where a.idmovies = b.idmovies and a.idperson=?")) {
			mysqli_stmt_bind_param($stmt, "s", $crew_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $movie_id, $position, $title);
		while(mysqli_stmt_fetch($stmt)) {
			$position = htmlspecialchars($position);
			$title = htmlspecialchars($title);
			$movie_id = htmlspecialchars($movie_id);
			echo " <br>";
            echo " <tr> <td> <a href = index.php?s=1&movie_id=$movie_id>$title</a> </td>
						<td> $position </td></tr> \n";
		}
		mysqli_stmt_close($stmt);
		}
	break;

	case 4:
	default:
		echo " <center><h2> Celebrities</h2> </center>";
		$query = "select idperson, first_name, last_name from person";
		$result = mysqli_query($db, $query);
		while($row = mysqli_fetch_row($result)) {
			$row[0] = htmlspecialchars($row[0]);
			$row[1] = htmlspecialchars($row[1]);
			$row[2] = htmlspecialchars($row[2]);
			echo" <br> <tr> <center> 
			<td> <a href = index.php?s=2&cast_id=$row[0]> $row[1] $row[2] </td> </center> </tr> \n";
		}	
	break;	
}
	
?>