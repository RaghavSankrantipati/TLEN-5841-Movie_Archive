<?php
session_start();
session_regenerate_id();

include_once('/var/www/html/project/project-lib.php');

connect($db);

check_login($db);
if(!isset($_SESSION['authenticated'])){
	authenticate($db, $user_name, $user_paswd);
} 
isset ( $_REQUEST['s'] ) ? $s =strip_tags($_REQUEST['s']) : $s = "";

?>

<html>
<body>
<center>
<a href = index.php?s=0> Movies </a>  <br>
<a href = register.php?s=0> Register </a>   <br>
<a href = comment.php?s=0> Comment </a> <br>
<a href = rate.php?s=0> Rate </a> <br>
<a href = add_movie.php?s=0> Add Movie </a> <br>
<a href = add_person.php?s=0> Add Person </a> <br>
<?php	
	if($_SESSION['userid']==1) {
		echo " <center>
		<a href = admin.php?s=1> List of Users </a><br>
		<a href = admin.php?s=2> Failed logins </a><br>
		<a href = admin.php?s=3> Delete User </a><br>
		<a href = admin.php?s=5> Delete Movie </a><br>
		</center>";
	}
?>
</center>
</body>
</html>
