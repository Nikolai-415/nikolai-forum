<?php
	$path = "/var/www/html";
	require $path."/includes/mysql/mysql_connect.php";
	
	require $path."/includes/session/session_start.php";
	CheckBanAndLogoutIfTrue();
	
	$title = "Главная";
	include_once $path."/includes/head.php";
?>
<?php
	$menu_button = 1;
	include_once $path."/includes/header.php";
?>
					<div id="error_404">
						Добро пожаловать на Nikolai's Forum!
					</div>
<?php
	include_once $path."/includes/footer.php";
	require $path."/includes/mysql/mysql_disconnect.php";
?>