<?php
require "includes/mysql/mysql_connect.php";
require "includes/session/session_start.php";
DeleteSession();
header('Location: /login');
exit;
