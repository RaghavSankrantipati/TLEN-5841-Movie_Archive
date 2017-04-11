<html>
<head>
<title> Movie Archive </title>
</head>

<body>
<center>
<a href = index.php?s=0> Movies </a>    
<a href = comment.php?s=0> Comment </a> 
<a href = rate.php?s=0> Rate </a> 
<a href = add_movie.php?s=0> Add Movie </a> 
<a href = add_person.php?s=0> Add Person </a> 
<a href = dash_board.php> Dash Board</a>
<a href = login.php> Login</a>
<a href = register.php?s=0> Register </a> 
</center>
</body>
</html>

<?php

isset ( $_REQUEST['s'] ) ? $s =strip_tags($_REQUEST['s']) : $s = "";

isset ( $_REQUEST['m_title'] ) ? $m_title = strip_tags($_REQUEST['m_title']) : $m_title = "";
isset ( $_REQUEST['m_language'] ) ? $m_language =strip_tags($_REQUEST['m_language']) : $m_language = "";
isset ( $_REQUEST['m_genre'] ) ? $m_genre =strip_tags($_REQUEST['m_genre']) : $m_genre = "";
isset ( $_REQUEST['m_year'] ) ? $m_year =strip_tags($_REQUEST['m_year']) : $m_year = "";
isset ( $_REQUEST['m_url'] ) ? $m_url =strip_tags($_REQUEST['m_url']) : $m_url = "";
isset ( $_REQUEST['m_plot'] ) ? $m_plot =strip_tags($_REQUEST['m_plot']) : $m_plot = "";
isset ( $_REQUEST['m_rate'] ) ? $m_rate =strip_tags($_REQUEST['m_rate']) : $m_rate = "";
isset ( $_REQUEST['m_comment'] ) ? $m_comment =strip_tags($_REQUEST['m_comment']) : $m_comment = "";
isset ( $_REQUEST['m_character1'] ) ? $m_character1 =strip_tags($_REQUEST['m_character1']) : $m_character1 = "";
isset ( $_REQUEST['m_character2'] ) ? $m_character2 =strip_tags($_REQUEST['m_character2']) : $m_character2 = "";
isset ( $_REQUEST['m_character3'] ) ? $m_character3 =strip_tags($_REQUEST['m_character3']) : $m_character3 = "";
isset ( $_REQUEST['m_first_name1'] ) ? $m_first_name1 =$_REQUEST['m_first_name1'] : $m_first_name1 = "";
isset ( $_REQUEST['m_last_name1'] ) ? $m_last_name1 = strip_tags($_REQUEST['m_last_name1']) : $m_last_name1 = "";
isset ( $_REQUEST['m_first_name2'] ) ? $m_first_name2 =strip_tags($_REQUEST['m_first_name2']) : $m_first_name2 = "";
isset ( $_REQUEST['m_last_name2'] ) ? $m_last_name2 =strip_tags($_REQUEST['m_last_name2']) : $m_last_name2 = "";
isset ( $_REQUEST['m_first_name3'] ) ? $m_first_name3 =strip_tags($_REQUEST['m_first_name3']) : $m_first_name3 = "";
isset ( $_REQUEST['m_last_name3'] ) ? $m_last_name3 =strip_tags($_REQUEST['m_last_name3']) : $m_last_name3 = "";
isset ( $_REQUEST['m_director_first'] ) ? $m_director_first =strip_tags($_REQUEST['m_director_first']) : $m_director_first = "";
isset ( $_REQUEST['m_director_last'] ) ? $m_director_last =strip_tags($_REQUEST['m_director_last']) : $m_director_last = "";
isset ( $_REQUEST['m_writer_first'] ) ? $m_writer_first =strip_tags($_REQUEST['m_writer_first']) : $m_writer_first = "";
isset ( $_REQUEST['m_writer_last'] ) ? $m_writer_last =strip_tags($_REQUEST['m_writer_last']) : $m_writer_last = "";
isset ( $_REQUEST['m_music_first'] ) ? $m_music_first =strip_tags($_REQUEST['m_music_first']) : $m_music_first = "";
isset ( $_REQUEST['m_music_last'] ) ? $m_music_last =strip_tags($_REQUEST['m_music_last']) : $m_music_last = "";

isset ( $_REQUEST['p_first_name'] ) ? $p_first_name =strip_tags($_REQUEST['p_first_name']) : $p_first_name = "";
isset ( $_REQUEST['p_last_name'] ) ? $p_last_name =strip_tags($_REQUEST['p_last_name']) : $p_last_name = "";
isset ( $_REQUEST['p_gender'] ) ? $p_gender =strip_tags($_REQUEST['p_gender']) : $p_gender = "";
isset ( $_REQUEST['p_details'] ) ? $p_details =strip_tags($_REQUEST['p_details']) : $p_details = "";
isset ( $_REQUEST['p_url'] ) ? $p_url =strip_tags($_REQUEST['p_url']) : $p_url = "";

isset ( $_REQUEST['u_name'] ) ? $u_name =$_REQUEST['u_name'] : $u_name = "";
isset ( $_REQUEST['u_paswd1'] ) ? $u_paswd1 =$_REQUEST['u_paswd1'] : $u_paswd1 = "";
isset($_REQUEST['u_email']) ? $u_email = $_REQUEST['u_email'] : $u_email = "";
isset($_REQUEST['u_paswd2']) ? $u_paswd2 = $_REQUEST['u_paswd2'] : $u_paswd2 = "";

isset($_REQUEST['au_name']) ? $au_name = $_REQUEST['au_name'] : $au_name = "";
isset($_REQUEST['am_name']) ? $am_name = $_REQUEST['am_name'] : $am_name = "";
isset($_REQUEST['au_name1']) ? $au_name1 = $_REQUEST['au_name1'] : $au_name1 = "";
isset($_REQUEST['am_name1']) ? $am_name1 = $_REQUEST['am_name1'] : $am_name1 = "";

isset ( $_REQUEST['movie_id'] ) ? $movie_id =$_REQUEST['movie_id'] : $movie_id = "";
isset ( $_REQUEST['comment'] ) ? $comment =$_REQUEST['comment'] : $comment = "";
isset($_REQUEST['cast_id']) ? $cast_id = $_REQUEST['cast_id'] : $cast_id = "";
isset($_REQUEST['crew_id']) ? $crew_id = $_REQUEST['crew_id'] : $crew_id = "";

isset($_REQUEST['user_name']) ? $user_name = $_REQUEST['user_name'] : $user_name = "";
isset($_REQUEST['user_paswd']) ? $user_paswd = $_REQUEST['user_paswd'] : $user_paswd = "";

isset($_REQUEST['rate']) ? $rate = $_REQUEST['rate'] : $rate = "";

isset($_REQUEST['logout']) ? $logout = $_REQUEST['logout'] : $logout = "";


?>

