<?php
// Так как этот файл встраивается в PHP-файлы в корне, то пути к файлам тут идут относительно тех файлов, а не этого
/** @noinspection PhpIncludeInspection */
require "includes/functions/session_functions.php";
require "includes/functions/warn_and_ban_functions.php";
require "includes/functions/forum_functions.php";
require "includes/functions/IsUserExist.php";
require "includes/functions/EchoPageNavigation.php";
require "includes/functions/GetLocalTime.php";
session_start();
