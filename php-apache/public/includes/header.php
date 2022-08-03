<?
	$menu_title[0] = "Главная";
	$menu_title[1] = "Форум";
	$menu_title[2] = "Личный кабинет";
	$menu_title[3] = "Пользователи";
	
	$menu_link[0] = "index";
	$menu_link[1] = "forum";
	$menu_link[2] = "profile";
	$menu_link[3] = "users";
?>
	</head>
	<body>
		<div id="content">
			<header>
				<div id="head">
					<a href="/index">
						<img id="head_img" src="/img/head.png" alt="<?php echo $site_name; ?>">
					</a>
					<div id="head_text">
						В разработке...
					</div>
				</div>
				<div id="menu_bar">
					<?php
						for($i = 0; $i < sizeof($menu_title); $i++){
							$is_active = false;
							if(($menu_button ?? null) - 1 == $i)
							{
								if($i == 1){
									$is_active = true;
								}
								else if($i == 2){
									if(($_GET['id'] ?? null) === null || ($_GET['id'] ?? null) == GetSessionId()){
										$is_active = true;
									}
								}
								else $is_active = true;
							}
							
							echo "<a href='".$menu_link[$i]."'>";
							echo "<div class='menu_button";
							if($is_active == true) // если вкладка является активной
							{
								echo " active_menu_button";
							}
							echo "'>";
							echo $menu_title[$i];
							echo "</div>";
							echo "</a>";
						}
					?>
				</div>
				<div class="clear"></div>
			</header>
			<article>
				<h2 hidden><?php echo $title; ?></h2>