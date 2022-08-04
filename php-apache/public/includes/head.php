<?php
$site_name = "Nikolai's Forum";
$title = htmlspecialchars($title); // Преобразует специальные символы в HTML-сущности
?>

<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/all.css">
    <link rel="stylesheet" href="/css/phone.css">
    <link rel="stylesheet" href="/css/tablet.css">
    <link rel="stylesheet" href="/css/monitor.css">
    <link rel="stylesheet" href="/css/full_monitor.css">
    <link rel="icon" href="/img/favicon.png">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <title>
        <?php echo $title . " - " . $site_name; ?>
    </title>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="/js/scrollup.js"></script>