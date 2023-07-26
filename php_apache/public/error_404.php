<?php
require "includes/mysql/mysql_connect.php";
require "includes/session/session_start.php";
CheckBanAndLogoutIfTrue();

$title = "Страница не найдена!";
include_once "includes/head.php";
?>
<?php
$menu_button = 0;
include_once "includes/header.php";
?>
    <div id="error_404">
        Ошибка #404<br/>
        Страница не найдена!
    </div>
<?php
include_once "includes/footer.php";
require "includes/mysql/mysql_disconnect.php";
?>