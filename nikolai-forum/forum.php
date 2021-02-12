<?php
	$path = "";
	require $path."/includes/mysql/mysql_connect.php";
	
	require $path."/includes/session/session_start.php";
	CheckBanAndLogoutIfTrue();
	
	$forum_id = 0;
	if($_GET['id'] !== null)
	{
		$forum_id = $_GET['id'];
	}
	if(!(IsForumExist($forum_id)))
	{
		header ('Location: /error_404'); // перенаправляем на страницу ошибки
		exit;
	}
	
	$user_id = GetSessionId();
	$user_permissions = GetUserForumPermissions($user_id, $forum_id);
	
	$can_see_this_forum = $user_permissions['can_see_this_forum'];
	
	$can_edit_this_forum = $user_permissions['can_edit_this_forum'];
	$can_delete_this_forum = $user_permissions['can_delete_this_forum'];
	$can_create_forums = $user_permissions['can_create_forums'];
	$can_create_topics = $user_permissions['can_create_topics'];
	
	if($can_see_this_forum == 0)
	{
		header ('Location: /error_404'); // перенаправляем на страницу ошибки
		exit;
	}
	
	$action = $_GET['action'];
	$errors_text = array(); // название каждой ошибки
	$errors_number = 0;
	if($action === null) // если запрос пустой
	{
		$action = 'view';
	}
	else if($action == 'delete')
	{
		if($can_delete_this_forum == 0) // если пользователь не имеет соответствующих прав
		{
			header ("Location: /forum?id=$forum_id"); // перенаправляем на форум
			exit;
		}
		else if($_POST['button_submit'] != '') //если пользователь подтвердил действие
		{
			$stmt = $mysqli->prepare("SELECT forum_id FROM forums WHERE (id = ?);");
			$stmt->bind_param("i", $forum_id);
			$stmt->execute();
			$result_set = $stmt->get_result();
			$row = $result_set->fetch_assoc();
			$parent_forum_id = 0;
			if($row)
			{
				$parent_forum_id = $row['forum_id'];
			}
			$stmt = $mysqli->prepare("DELETE FROM forums WHERE (id = ?);");
			$stmt->bind_param("i", $forum_id);
			if($stmt->execute())
			{
				header ("Location: /forum?id=$parent_forum_id"); // перенаправляем на форум
			}
			else
			{
				$errors_text[$errors_number++] = "Невозможно удалить этот форум, так как он содержит другие форумы или темы!";
			}
		}
	}
	else if($action == 'create-forum')
	{
		if($can_create_forums == 0) // если пользователь не имеет соответствующих прав
		{
			header ("Location: /forum?id=$forum_id"); // перенаправляем на форум
			exit;
		}
		else if($_POST['button_submit'] !== null)
		{
			// проверка на то, что пользователь имеет доступ для создания форумов в выбранном форуме
			$user_permissions_2 = GetUserForumPermissions($user_id, $_POST['forums_tree']);
			$can_see_this_forum = $user_permissions_2['can_see_this_forum'];
			$can_create_forums = $user_permissions_2['can_create_forums'];
			if($can_see_this_forum == 1 && $can_create_forums == 1)
			{
				// проверка на правильность значений
				CheckValue01AndSetToDefaultIfWrong($_POST['forum_is_category']);
				CheckValue012AndSetToDefaultIfWrong($_POST['forum_is_description_hided']);
						
				$stmt = $mysqli->prepare("
					INSERT INTO forums(name, description, user_from_id, forum_id, is_category, is_description_hided) values(?, ?, ?, ?, ?, ?);
				");
				$stmt->bind_param("ssiiii", $_POST['forum_name'], $_POST['forum_description'], $user_id, $_POST['forums_tree'], $_POST['forum_is_category'], $_POST['forum_is_description_hided']);
				if($stmt->execute())
				{
					$created_forum_id = $stmt->insert_id;
					
					$was_error = 0;
					
					$stmt = $mysqli->prepare("SELECT id, rank FROM groups ORDER BY rank;");
					$stmt->execute();
					$result_set = $stmt->get_result();
					
					$groups_ids = array();
					$groups_ranks = array();
					$groups_number = 0;
					while($row = $result_set->fetch_assoc())
					{		
						$groups_ids[$groups_number] = $row['id'];
						$groups_ranks[$groups_number] = $row['rank'];
						$groups_number++;
					}
					
					// находим максимальный ранг группы у пользователя
					$user_max_group_rank = GetUserMaxGroupRank($user_id);
					
					for($group_local_id = 0; $group_local_id < $groups_number; $group_local_id++) // для каждой группы
					{
						$group_id = $groups_ids[$group_local_id];
						$group_rank = $groups_ranks[$group_local_id];
						
						$select_values = array();
						for($permission_id = 0; $permission_id < $permissions_number; $permission_id++)
						{
							$name_of_select = "forum_permission_".$permissions_fields_names[$permission_id]."_for_group_with_id_".$group_id;
							$select_values[$permission_id] = $_POST[$name_of_select];
							if($user_max_group_rank > $group_rank)
							{
								$select_values[$permission_id] = "2"; // для групп, у которых ранг выше, чем максимальный ранг группы у пользователя
							}
							
							if($group_id == -1 || $group_id == 1) $select_values[$permission_id] = "1"; // для супервизоров разрешено всё
								
							if($group_id == 3 && $permissions_fields_names[$permission_id] != 'can_see_this_forum') $select_values[$permission_id] = "0"; // для гостей всё запрещено
							
							CheckValue012AndSetToDefaultIfWrong($select_values[$permission_id]); // проверка на правильность значения
						}
						
						// добавление прав к форуму в таблицу groups_permissions_to_forums
						$stmt = $mysqli->prepare("
							INSERT INTO groups_permissions_to_forums(
								forum_id,
								group_id,
								can_see_this_forum,
								can_edit_this_forum,
								can_delete_this_forum,
								can_create_forums,
								can_create_topics,
								can_create_commentaries,
								can_edit_forums_from_him,
								can_edit_forums_from_users_in_lower_groups,
								can_edit_forums_from_users_in_groups_with_same_rank,
								can_delete_forums_from_him,
								can_delete_forums_from_users_in_lower_groups,
								can_delete_forums_from_users_in_groups_with_same_rank,
								can_edit_topics_from_him,
								can_edit_topics_from_users_in_lower_groups,
								can_edit_topics_from_users_in_groups_with_same_rank,
								can_delete_topics_from_him,
								can_delete_topics_from_users_in_lower_groups,
								can_delete_topics_from_users_in_groups_with_same_rank,
								can_edit_commentaries_from_him,
								can_edit_commentaries_from_users_in_lower_groups,
								can_edit_commentaries_from_users_in_groups_with_same_rank,
								can_delete_commentaries_from_him,
								can_delete_commentaries_from_users_in_lower_groups,
								can_delete_commentaries_from_users_in_groups_with_same_rank
							)
							values(
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?,
								?
							);
						");
						$stmt->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiii",
							$created_forum_id,
							$group_id,
							$select_values[0],
							$select_values[1],
							$select_values[2],
							$select_values[3],
							$select_values[4],
							$select_values[5],
							$select_values[6],
							$select_values[7],
							$select_values[8],
							$select_values[9],
							$select_values[10],
							$select_values[11],
							$select_values[12],
							$select_values[13],
							$select_values[14],
							$select_values[15],
							$select_values[16],
							$select_values[17],
							$select_values[18],
							$select_values[19],
							$select_values[20],
							$select_values[21],
							$select_values[22],
							$select_values[23]
						);
						if($stmt->execute() == 0)
						{
							$was_error = 1;
							break;
						}
					}
					if($was_error == 0) // если были успешно выполнены все запросы
					{
						header ("Location: /forum?id=".$_POST['forums_tree']); // перенаправляем на форум
					}
					else
					{
						$errors_text[$errors_number++] = "Возникла ошибка при создании прав для форума!<br/>".$stmt->error;
					}
				}
				else
				{
					$errors_text[$errors_number++] = "Возникла ошибка при создании форума!";
				}
			}
			else
			{
				$errors_text[$errors_number++] = "Вы не можете создавать форумы в выбранном форуме!";
			}
		}
	}
	else if($action == 'edit')
	{
		if($can_edit_this_forum == 0) // если пользователь не имеет соответствующих прав
		{
			header ("Location: /forum?id=$forum_id"); // перенаправляем на форум
			exit;
		}
		
		$stmt = $mysqli->prepare("SELECT name, description, is_description_hided, is_category, forum_id FROM forums WHERE (id = ?);");
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
				
		$row = $result_set->fetch_assoc();
		
		$loaded_permissions = array();
		
		if($row)
		{		
			if($_POST['button_submit'] === null)
			{
				$_POST['forum_name'] = $row['name'];
				CheckStringValue($_POST['forum_name']);
				$_POST['forum_description'] = $row['description'];
				CheckStringValue($_POST['forum_description']);
				$_POST['forum_is_description_hided'] = "".$row['is_description_hided'];
				$_POST['forum_is_category'] = "".$row['is_category'];
				$_POST['forum_tree'] = "".$row['forum_id'];
			}
				
			$stmt = $mysqli->prepare("SELECT id FROM groups WHERE id >= 1 ORDER BY rank;");
			$stmt->execute();
			$result_set = $stmt->get_result();
			
			$groups_ids = array();
			$groups_number = 0;
			while($row = $result_set->fetch_assoc())
			{		
				$groups_ids[$groups_number] = $row['id'];
				$groups_number++;
			}
		
			for($group_local_id = 0; $group_local_id < $groups_number; $group_local_id++) // для каждой группы
			{
				$group_id = $groups_ids[$group_local_id];
				
				$stmt = $mysqli->prepare("SELECT * FROM groups_permissions_to_forums WHERE (forum_id = ?) AND (group_id = ?);");
				$stmt->bind_param("ii", $forum_id, $group_id);
				$stmt->execute();
				$result_set = $stmt->get_result();
						
				$row = $result_set->fetch_assoc();
				
				if($row)
				{		
					$select_values = array();
					for($permission_id = 0; $permission_id < $permissions_number; $permission_id++)
					{
						$name_of_select = "forum_permission_".$permissions_fields_names[$permission_id]."_for_group_with_id_".$group_id;
						
						if($_POST['button_submit'] === null)
						{
							$_POST[$name_of_select] = "".$row[$permissions_fields_names[$permission_id]];
						}
						
						$loaded_permissions[$name_of_select] = "".$row[$permissions_fields_names[$permission_id]];
					}
				}
			}
		}
	
		if($_POST['button_submit'] !== null)
		{
			// проверка на то, что пользователь имеет доступ для изменения выбранного форума
			$user_permissions_2 = GetUserForumPermissions($user_id, $forum_id);
			$can_see_this_forum = $user_permissions_2['can_see_this_forum'];
			$can_edit_this_forum = $user_permissions_2['can_edit_this_forum'];
			if($can_see_this_forum == 1 && $can_edit_this_forum == 1)
			{
				// проверка на правильность значений
				CheckValue01AndSetToDefaultIfWrong($_POST['forum_is_category']);
				CheckValue012AndSetToDefaultIfWrong($_POST['forum_is_description_hided']);
				
				if($forum_id === "0") // если изменяется главный форум
				{
					$_POST['forum_is_category'] = 0; // он не может быть категорией
					$_POST['forums_tree'] = 0; // он лежит "внутри себя" - у него нет родителя
				}
				
				// проверка на то, чтобы форум не был помещён сам в себя
				$parent_forum_id = $_POST['forums_tree'];
				$is_ok = 1;
				while($parent_forum_id != 0)
				{
					if($parent_forum_id == $forum_id) {
						$is_ok = 0;
						break;
					}
					
					$stmt = $mysqli->prepare("SELECT forum_id FROM forums WHERE (id = ?) LIMIT 1;");
					$stmt->bind_param("i", $parent_forum_id);
					$stmt->execute();
					$result_set = $stmt->get_result();
					
					if($row = $result_set->fetch_assoc())
					{	
						$parent_forum_id = $row['forum_id'];
					}
				}
				
				if($is_ok)
				{
					$stmt = $mysqli->prepare("
						UPDATE forums SET name = ?, description = ?, forum_id = ?, is_category = ?, is_description_hided = ? WHERE (id = ?);
					");
					$stmt->bind_param("ssiiii", $_POST['forum_name'], $_POST['forum_description'], $_POST['forums_tree'], $_POST['forum_is_category'], $_POST['forum_is_description_hided'], $forum_id);
					if($stmt->execute())
					{
						$was_error = 0;
						
						$stmt = $mysqli->prepare("SELECT id, rank FROM groups ORDER BY rank;");
						$stmt->execute();
						$result_set = $stmt->get_result();
						
						$groups_ids = array();
						$groups_ranks = array();
						$groups_number = 0;
						while($row = $result_set->fetch_assoc())
						{		
							$groups_ids[$groups_number] = $row['id'];
							$groups_ranks[$groups_number] = $row['rank'];
							$groups_number++;
						}
						
						// находим максимальный ранг группы у пользователя
						$user_max_group_rank = GetUserMaxGroupRank($user_id);
						
						for($group_local_id = 0; $group_local_id < $groups_number; $group_local_id++) // для каждой группы
						{
							$group_id = $groups_ids[$group_local_id];
							$group_rank = $groups_ranks[$group_local_id];
							
							$select_values = array();
							for($permission_id = 0; $permission_id < $permissions_number; $permission_id++)
							{
								$name_of_select = "forum_permission_".$permissions_fields_names[$permission_id]."_for_group_with_id_".$group_id;
								$select_values[$permission_id] = $_POST[$name_of_select];
								
								$cant_delete = 0;
								if(($forum_id === "0") && ($permissions_fields_names[$permission_id] === "can_delete_this_forum")){
									$cant_delete = 1;
								}
								
								if(($user_max_group_rank > $group_rank))
								{
									$select_values[$permission_id] = "".$loaded_permissions[$name_of_select]; // для групп, у которых ранг выше, чем максимальный ранг группы у пользователя
								}
								
								if($cant_delete)
								{
									$select_values[$permission_id] = "0";
								}
								
								if($group_id == -1 || $group_id == 1) $select_values[$permission_id] = "1"; // для супервизоров разрешено всё
								
								if($group_id == 3 && $permissions_fields_names[$permission_id] != 'can_see_this_forum') $select_values[$permission_id] = "0"; // для гостей всё запрещено
								
								if($permissions_fields_names[$permission_id] == 'can_delete_this_forum' && $forum_id == 0) // удалять главный форум не может никто
								{
									$select_values[$permission_id] = "0";
								}
								
								CheckValue012AndSetToDefaultIfWrong($select_values[$permission_id]); // проверка на правильность значения
							}
							
							
							// изменение прав к форуму в таблице groups_permissions_to_forums
							$stmt = $mysqli->prepare("
								UPDATE groups_permissions_to_forums SET 
									can_see_this_forum = ?,
									can_edit_this_forum = ?,
									can_delete_this_forum = ?,
									can_create_forums = ?,
									can_create_topics = ?,
									can_create_commentaries = ?,
									can_edit_forums_from_him = ?,
									can_edit_forums_from_users_in_lower_groups = ?,
									can_edit_forums_from_users_in_groups_with_same_rank = ?,
									can_delete_forums_from_him = ?,
									can_delete_forums_from_users_in_lower_groups = ?,
									can_delete_forums_from_users_in_groups_with_same_rank = ?,
									can_edit_topics_from_him = ?,
									can_edit_topics_from_users_in_lower_groups = ?,
									can_edit_topics_from_users_in_groups_with_same_rank = ?,
									can_delete_topics_from_him = ?,
									can_delete_topics_from_users_in_lower_groups = ?,
									can_delete_topics_from_users_in_groups_with_same_rank = ?,
									can_edit_commentaries_from_him = ?,
									can_edit_commentaries_from_users_in_lower_groups = ?,
									can_edit_commentaries_from_users_in_groups_with_same_rank = ?,
									can_delete_commentaries_from_him = ?,
									can_delete_commentaries_from_users_in_lower_groups = ?,
									can_delete_commentaries_from_users_in_groups_with_same_rank = ?
								WHERE (forum_id = ?) AND (group_id = ?);
							");
							$stmt->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiii",
								$select_values[0],
								$select_values[1],
								$select_values[2],
								$select_values[3],
								$select_values[4],
								$select_values[5],
								$select_values[6],
								$select_values[7],
								$select_values[8],
								$select_values[9],
								$select_values[10],
								$select_values[11],
								$select_values[12],
								$select_values[13],
								$select_values[14],
								$select_values[15],
								$select_values[16],
								$select_values[17],
								$select_values[18],
								$select_values[19],
								$select_values[20],
								$select_values[21],
								$select_values[22],
								$select_values[23],
								$forum_id,
								$group_id
							);
							if($stmt->execute() == 0)
							{
								$was_error = 1;
								break;
							}
						}
						if($was_error == 0) // если были успешно выполнены все запросы
						{
							header ("Location: /forum?id=".$forum_id); // перенаправляем на форум
						}
						else
						{
							$errors_text[$errors_number++] = "Возникла ошибка при изменении прав для форума!<br/>".$stmt->error;
						}
					}
					else
					{
						$errors_text[$errors_number++] = "Возникла ошибка при изменении форума!";
					}
				}
				else
				{
					$errors_text[$errors_number++] = "Невозможно поместить форум внутрь его самого!";
				}
			}
			else
			{
				$errors_text[$errors_number++] = "Вы не можете изменять этот форум!";
			}
		}
	}
	else if($action == 'create-topic')
	{
		if($can_create_topics == 0) // если пользователь не имеет соответствующих прав
		{
			header ("Location: /forum?id=$forum_id"); // перенаправляем на форум
			exit;
		}
		else if($_POST['button_submit'] !== null)
		{
			// проверка на то, что пользователь имеет доступ для создания тем в выбранном форуме
			$user_permissions_2 = GetUserForumPermissions($user_id, $_POST['forums_tree']);
			$can_see_this_forum = $user_permissions_2['can_see_this_forum'];
			$can_create_topics = $user_permissions_2['can_create_topics'];
			if($can_see_this_forum == 1 && $can_create_topics == 1)
			{
				// проверка на правильность значений
				CheckValue01AndSetToDefaultIfWrong($_POST['topic_is_closed']);
				CheckValue012AndSetToDefaultIfWrong($_POST['topic_is_description_hided']);
				
				$stmt = $mysqli->prepare("
					INSERT INTO topics(name, description, user_from_id, forum_id, is_closed, is_description_hided) values(?, ?, ?, ?, ?, ?);
				");
				$stmt->bind_param("ssiiii", $_POST['topic_name'], $_POST['topic_description'], $user_id, $_POST['forums_tree'], $_POST['topic_is_closed'], $_POST['topic_is_description_hided']);
				if($stmt->execute())
				{
					$created_topic_id = $stmt->insert_id;
					
					$stmt = $mysqli->prepare("
						INSERT INTO commentaries(topic_id, user_from_id, text, creation_datetime_int) values(?, ?, ?, ?);
					");
					$stmt->bind_param("iisi", $created_topic_id, $user_id, $_POST['topic-commentary'], GetLocalTime(time()));
					if($stmt->execute())
					{
						header ("Location: /topic?id=".$created_topic_id); // перенаправляем на созданную тему
					}
					else
					{
						$errors_text[$errors_number++] = "Возникла ошибка при создании текста темы!";
					}
				}
				else
				{
					$errors_text[$errors_number++] = "Возникла ошибка при создании темы!";
				}
			}
			else
			{
				$errors_text[$errors_number++] = "Вы не можете создавать темы в выбранном форуме!";
			}
		}
	}
	else // если действие не опознано
	{
		header ("Location: /forum?id=$forum_id"); // перенаправляем на форум
		exit;
	}
	
	$stmt = $mysqli->prepare("SELECT name FROM forums WHERE id = ?");
	$stmt->bind_param("i", $forum_id);
	$stmt->execute();
	$result_set = $stmt->get_result();
	$row = $result_set->fetch_assoc();
	$title = "Форум";
	if($row)
	{	
		$title = $row['name'];
	}
	include_once $path."/includes/head.php";
?>
<?php
	$menu_button = 2;
	include_once $path."/includes/header.php";
?>
						<?php
							if($action == 'view')
							{			
								$can_do_something = 0;
								
								if($can_edit_this_forum == 1)
								{
									$can_do_something = 1;
								}
								if($can_delete_this_forum == 1)
								{
									$can_do_something = 1;
								}
								if($can_create_forums == 1)
								{
									$can_do_something = 1;
								}
								if($can_create_topics == 1)
								{
									$can_do_something = 1;
								}
								
								if($can_do_something){
									echo "<div id=\"article_menu\">";						
									if($can_edit_this_forum == 1)
									{
										echo "<a class='article_menu_button_blue' href='/forum?id=$forum_id&action=edit'>Изменить этот форум</a> ";
									}
									if($can_delete_this_forum == 1)
									{
										echo "<a class='article_menu_button_blue' href='/forum?id=$forum_id&action=delete'>Удалить этот форум</a> ";
									}
									if($can_create_forums == 1)
									{
										echo "<a class='article_menu_button_blue' href='/forum?id=$forum_id&action=create-forum'>Создать новый форум</a> ";
									}
									if($can_create_topics == 1)
									{
										echo "<a class='article_menu_button_blue' href='/forum?id=$forum_id&action=create-topic'>Создать новую тему</a> ";
									}
									echo "</div>";
								}
							}
							else
							{
								if($action == 'edit')
								{
									$legend = "Изменение форума";
									$submit_button_name = "Изменить";
								}
								else if($action == 'delete')
								{
									$legend = "Удаление форума";
									$submit_button_name = "Удалить";
								}
								else if($action == 'create-forum')
								{
									$legend = "Создание нового форума";
									$submit_button_name = "Создать";
								}
								else if($action == 'create-topic')
								{
									$legend = "Создание новой темы";
									$submit_button_name = "Создать";
								}
								
								echo "
									<form action=\"/forum?id=$forum_id&action=$action\" method=\"POST\" class=\"forum_form\">
										<fieldset>
											<legend><b>$legend</b></legend>
								";
								if($action == 'delete')
								{
									echo "
											<table class=\"settings\">
												<tr>
													<td colspan=\"2\">
														<label>
																Вы действительно хотите удалить форум?<br/>Отменить это действие будет невозможно.
														</label>
													</td>
												</tr>
											</table>
									";
								}
								else if($action == 'create-forum' || $action == 'edit')
								{
									echo "
											<table class=\"settings\">
												<tr>
													<td colspan=\"2\">
														<label>
																<b>Общие настройки</b>
														</label>
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"forum_name\">
																Название форума:
														</label>
													</td>
													<td>
														<input required type=\"text\" size=\"32\" maxlength=\"63\" name=\"forum_name\" id=\"forum_name\" value=\"".$_POST['forum_name']."\">
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"forum_description\">
																Описание форума:
														</label>
													</td>
													<td>
														<textarea rows=\"3\" cols=\"34\" maxlength=\"255\" name=\"forum_description\" id=\"forum_description\">".$_POST['forum_description']."</textarea>
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"forum_is_description_hided\">
																Скрыть описание форума:
														</label>
													</td>
													<td>
														<select name=\"forum_is_description_hided\">
															<option value=\"1\" "; if($_POST['forum_is_description_hided'] === null || $_POST['forum_is_description_hided'] === "1") echo "selected"; echo ">
																Да
															</option>
															<option value=\"0\" "; if($_POST['forum_is_description_hided'] === "0") echo "selected"; echo ">
																Нет
															</option>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"forum_is_category\">
																Является категорией:
														</label>
													</td>
													<td>
														<select name=\"forum_is_category\" "; if($forum_id === "0" && $action != 'create-forum'){ echo "disabled"; } echo ">
															<option value=\"1\" "; if($_POST['forum_is_category'] === "1") echo "selected"; echo ">
																Да
															</option>
															<option value=\"0\" "; if($_POST['forum_is_category'] === null || $_POST['forum_is_category'] === "0") echo "selected"; echo ">
																Нет
															</option>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"forum_tree\">
																Расположить в форуме:
														</label>
													</td>
													<td>";
									$selected_forum = $_POST['forum_tree'];
									if($selected_forum === null) // если запроса POST нет
									{
										$selected_forum = $forum_id;
									}
									EchoForumsTreeInSelectTag($user_id, $selected_forum, $forum_id, $action);
									echo "
													</td>
												</tr>
											</table>
											<table class=\"permissions\">
												<tr>
													<td colspan=\"4\">
														<label>
															<b>Права групп внутри создаваемого форума</b>
														</label>
													</td>
												</tr>";
									EchoGroupsPermissionsToForumsSettingsInTrTag($user_id, $forum_id, $action);
									echo "
											</table>
									";
								}
								else if($action == 'create-topic')
								{
									echo "
											<table class=\"settings\">
												<tr>
													<td colspan=\"2\">
														<label>
																<b>Общие настройки</b>
														</label>
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"topic_name\">
																Название темы:
														</label>
													</td>
													<td>
														<input required type=\"text\" size=\"32\" maxlength=\"63\" name=\"topic_name\" id=\"topic_name\" value=\"".$_POST['topic_name']."\">
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"topic_description\">
																Описание темы:
														</label>
													</td>
													<td>
														<textarea rows=\"3\" cols=\"34\" maxlength=\"255\" name=\"topic_description\" id=\"topic_description\">".$_POST['topic_description']."</textarea>
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"topic_is_description_hided\">
																Скрыть описание темы:
														</label>
													</td>
													<td>
														<select name=\"topic_is_description_hided\">
															<option value=\"1\" "; if($_POST['topic_is_description_hided'] === null || $_POST['topic_is_description_hided'] === "1") echo "selected"; echo ">
																Да
															</option>
															<option value=\"0\" "; if($_POST['topic_is_description_hided'] === "0") echo "selected"; echo ">
																Нет
															</option>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"topic_is_closed\">
																Тема закрыта:
														</label>
													</td>
													<td>
														<select name=\"topic_is_closed\">
															<option value=\"1\" "; if($_POST['topic_is_closed'] === "1") echo "selected"; echo ">
																Да
															</option>
															<option value=\"0\" "; if($_POST['topic_is_closed'] === null || $_POST['topic_is_closed'] === "0") echo "selected"; echo ">
																Нет
															</option>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"forum_tree\">
																Расположить в форуме:
														</label>
													</td>
													<td>";
									$selected_forum = $_POST['forum_tree'];
									if($selected_forum === null) // если запроса POST нет
									{
										$selected_forum = $forum_id;
									}
									EchoForumsTreeInSelectTag($user_id, $selected_forum, $forum_id, $action);
									echo "
													</td>
												</tr>
											</table>
											<table class=\"settings\">
												<tr>
													<td colspan=\"2\">
														<label for=\"topic-commentary\">
															<b>Текст</b>
														</label>
													</td>
												</tr>
												<tr>
													<td colspan=\"2\">
														<textarea required rows=\"7\" maxlength=\"8191\" name=\"topic-commentary\" id=\"topic-commentary\">".$_POST['topic-commentary']."</textarea>
													</td>
												</tr>
											</table>
									";
								}
								
								
								if(sizeof($errors_text) > 0)
								{
									echo "<div class=\"forum_form_errors\">";
										
									for($i = 0; $i < $errors_number; $i++){
										echo "<div class=\"error_text\">".$errors_text[$i]."</div>";
									}
										
									echo "</div>";
								}
								
								echo "
											<input type=\"submit\" value=\"$submit_button_name\" name=\"button_submit\">
											<a href='/forum?id=$forum_id'><input type=\"button\" value=\"Отмена\" name=\"button_cancel\"></a>
										</fieldset>
									</form>
								";
							}
							
							EchoForumTable($forum_id, $user_id);
							
							echo "
								<table class = \"info_table\">
									<tr>
										<td colspan=\"6\">
											Информация по иконкам
										</td>
									</tr>
									<tr>
										<td class=\"forum_table_td_icon forum_table_td_icon_forum\">										 
										</td>
										<td>
											Форум
										</td>
										<td class=\"forum_table_td_icon forum_table_td_icon_topic\">										 
										</td>
										<td>
											Открытая тема
										</td>
										<td class=\"forum_table_td_icon forum_table_td_icon_topic_closed\">										 
										</td>
										<td>
											Закрытая тема
										</td>
									</tr>
								</table>
							";
						?>
<?php
	include_once $path."/includes/footer.php";
	require $path."/includes/mysql/mysql_disconnect.php";
?>