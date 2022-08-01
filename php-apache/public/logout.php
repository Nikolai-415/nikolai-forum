<?php
    $path = "/var/www/html";
	require $path."/includes/mysql/mysql_connect.php";
	require $path."/includes/session/session_start.php";
	DeleteSession();
	header ('Location: /login');
	exit;
?>