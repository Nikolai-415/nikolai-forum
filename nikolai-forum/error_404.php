<?php
	$path = "";
	require $path."/includes/mysql/mysql_connect.php";
	
	require $path."/includes/session/session_start.php";
	CheckBanAndLogoutIfTrue();
	
	$title = "Страница не найдена!";
	include_once $path."/includes/head.php";
?>
<?php
	$menu_button = 0;
	include_once $path."/includes/header.php";
?>
					<div id="error_404">
						Ошибка #404<br/>
						Страница не найдена!
					</div>
<?php
	include_once $path."/includes/footer.php";
	require $path."/includes/mysql/mysql_disconnect.php";
?>