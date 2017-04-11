<?php

function connect(&$db) {
	$mycnf="/etc/project-mysql.conf";
	if(!file_exists($mycnf)) {
        echo "ERROR:DB Config file not found: $mycnf";
        exit;
	}

	$mysql_ini_array = parse_ini_file($mycnf);
	$db_host = $mysql_ini_array["host"];
	$db_user = $mysql_ini_array["user"];
	$db_pass = $mysql_ini_array["pass"];
	$db_port = $mysql_ini_array["port"];
	$db_name = $mysql_ini_array["dbName"];

	$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);
	if(!$db) {
        print "Error connecting to DB: " . mysqli_connect_error();
        exit;
    }
}


function authenticate($db, $user_name, $user_paswd) {
    $query = "select userid, email, password, salt from users where username=?";
    if($stmt = mysqli_prepare($db, $query)) {
        mysqli_stmt_bind_param($stmt,"s",$user_name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userid, $email, $password, $salt);
        while(mysqli_stmt_fetch($stmt)) {
                $userid = $userid;
                $password = $password;
                $salt = $salt;
                $email= $email;
        }
        mysqli_stmt_close($stmt);
        $epass = hash('sha256', $user_paswd.$salt);

        if($epass == $password) {
			session_regenerate_id();
            $_SESSION['userid'] = $userid;
            $_SESSION['email'] = $email;
            $_SESSION['authenticated'] = "yes";
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
			$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT']);
			$_SESSION['created'] = time();
			checkAuth();
		} else {
			store_details($db, $user_name);
			error_log(" **ERROR**: Tolkien App has failed login from " . $_SERVER['REMOTE_ADDR'], 0);
            echo "Failed to Login";
			header("Location: /project/login.php");
		}
	}
}

function admin_check() {
	if($_SESSION['userid']!=1) {
		header("Location: /project/add.php");
	}	
}

function icheck(&$variable) {
if($variable != null) {
if(!is_numeric($variable)) {
	echo "<center>ERROR: not a numeric</center>";
	exit;
}
}
}


function check_login($db){
    $ip = $_SERVER['REMOTE_ADDR'];
    if($stmt = mysqli_prepare($db, "SELECT count(*) from login where (date > DATE_SUB(NOW(), INTERVAL 60 MINUTE)) and ip=?")) {
        mysqli_stmt_bind_param($stmt, "s", $ip);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        while(mysqli_stmt_fetch($stmt)) {
            $count = $count;
        }
        mysqli_stmt_close($stmt);
    }
	if($count > 4) {
		header("Location: /project/fail_login.php");
		break;
	}
}

function store_details($db, $user_name) {
	$ip = $_SERVER['REMOTE_ADDR'];
	$user = $user_name;
	$action = 1;
	if($stmt = mysqli_prepare($db, "insert into login set loginid='', ip=?, user=?, date=now(), action=?" )){
	    mysqli_stmt_bind_param($stmt, "sss", $ip, $user, $action);
	    mysqli_stmt_execute($stmt);
	    mysqli_stmt_close($stmt);
	}
} 

function checkAuth() {
	if(isset($_SESSION['HTTP_USER_AGENT'])) {
		if($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {
			logout();
		}
	} else {
			logout();
	}
	

	if(isset($_SESSION['ip'])) {
		if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
			logout();
		}
	} else {
		logout();
	}

	if(isset($_SESSION['created'])) {
		if( time() - $_SESSION['created'] > 1800) {
			logout();
		}
	} else {
		logout();
	}

	if("POST" == $_SERVER["REQUEST_METHOD"]) {
		if(isset($_SERVER["HTTP_ORIGIN"])) {
			if($_SERVER["HTTP_ORIGIN"] != "https://100.66.1.33") {
				logout();
			}
		} else {
			logout();	
		}	
	}
}

function logout() {
	session_destroy();
	header ("Location: /project/login.php");
}

function person_exits($first_name, $last_name) {
	$first_name = mysqli_real_escape_string($db, $first_name);
	$last_name = mysqli_real_escape_string($db, $last_name);
	if($stmt = mysqli_prepare($db, "select idperson from person where first_name=? and last_name =?")) {
	mysqli_stmt_bind_param($stmt, "sss", $first_name, $last_name);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $pid);
	while(mysqli_stmt_fetch($stmt)) {
		$pid = htmlspecialchars($pid);
		$pid = $pid;
		}
	}	
	if($pid != null) {
		return $pid;
	} else {
		echo" <center><h3>Information of $first_name $last_name doesn't exist in database</h3></center>";
		return 0;
	}
}


?>
