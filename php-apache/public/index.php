<?php
require "includes/mysql/mysql_connect.php";
require "includes/session/session_start.php";
CheckBanAndLogoutIfTrue();

$title = "Главная";
include_once "includes/head.php";
?>
<?php
$menu_button = 1;
include_once "includes/header.php";
?>
    <div id="error_404">
        Добро пожаловать на Nikolai's Forum!
    </div>
<?php
include_once "includes/footer.php";
require "includes/mysql/mysql_disconnect.php";
?>