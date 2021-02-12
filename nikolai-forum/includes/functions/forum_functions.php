<?php
	$permissions_fields_names = array();
	$permissions_descriptions = array();
	$permissions_number = 0;
	
	$permissions_fields_names[$permissions_number] = 'can_see_this_forum';
	$permissions_descriptions[$permissions_number++] = "Может видеть форум";
	
	$permissions_fields_names[$permissions_number] = 'can_edit_this_forum';
	$permissions_descriptions[$permissions_number++] = "Может изменить форум";
	
	$permissions_fields_names[$permissions_number] = 'can_delete_this_forum';
	$permissions_descriptions[$permissions_number++] = "Может удалить форум";
	
	$permissions_fields_names[$permissions_number] = 'can_create_forums';
	$permissions_descriptions[$permissions_number++] = "Может создавать форумы";
	
	$permissions_fields_names[$permissions_number] = 'can_create_topics';
	$permissions_descriptions[$permissions_number++] = "Может создавать темы";
	
	$permissions_fields_names[$permissions_number] = 'can_create_commentaries';
	$permissions_descriptions[$permissions_number++] = "Может оставлять комментарии к темам";
	
	$permissions_fields_names[$permissions_number] = 'can_edit_forums_from_him';
	$permissions_descriptions[$permissions_number++] = "Может изменять свои форумы";
	
	$permissions_fields_names[$permissions_number] = 'can_edit_forums_from_users_in_lower_groups';
	$permissions_descriptions[$permissions_number++] = "Может изменять форумы от пользователей из групп с более низким рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_edit_forums_from_users_in_groups_with_same_rank';
	$permissions_descriptions[$permissions_number++] = "Может изменять форумы от пользователей из групп с таким же рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_delete_forums_from_him';
	$permissions_descriptions[$permissions_number++] = "Может удалять свои форумы";
	
	$permissions_fields_names[$permissions_number] = 'can_delete_forums_from_users_in_lower_groups';
	$permissions_descriptions[$permissions_number++] = "Может удалять форумы от пользователей из групп с более низким рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_delete_forums_from_users_in_groups_with_same_rank';
	$permissions_descriptions[$permissions_number++] = "Может удалять форумы от пользователей из групп с таким же рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_edit_topics_from_him';
	$permissions_descriptions[$permissions_number++] = "Может изменять свои темы";
	
	$permissions_fields_names[$permissions_number] = 'can_edit_topics_from_users_in_lower_groups';
	$permissions_descriptions[$permissions_number++] = "Может изменять темы от пользователей из групп с более низким рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_edit_topics_from_users_in_groups_with_same_rank';
	$permissions_descriptions[$permissions_number++] = "Может изменять темы от пользователей из групп с таким же рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_delete_topics_from_him';
	$permissions_descriptions[$permissions_number++] = "Может удалять свои темы";
	
	$permissions_fields_names[$permissions_number] = 'can_delete_topics_from_users_in_lower_groups';
	$permissions_descriptions[$permissions_number++] = "Может удалять темы от пользователей из групп с более низким рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_delete_topics_from_users_in_groups_with_same_rank';
	$permissions_descriptions[$permissions_number++] = "Может удалять темы от пользователей из групп с таким же рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_edit_commentaries_from_him';
	$permissions_descriptions[$permissions_number++] = "Может изменять свои комментарии";
			
	$permissions_fields_names[$permissions_number] = 'can_edit_commentaries_from_users_in_lower_groups';
	$permissions_descriptions[$permissions_number++] = "Может изменять комментарии от пользователей из групп с более низким рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_edit_commentaries_from_users_in_groups_with_same_rank';
	$permissions_descriptions[$permissions_number++] = "Может изменять комментарии от пользователей из групп с таким же рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_delete_commentaries_from_him';
	$permissions_descriptions[$permissions_number++] = "Может удалять свои комментарии";
	
	$permissions_fields_names[$permissions_number] = 'can_delete_commentaries_from_users_in_lower_groups';
	$permissions_descriptions[$permissions_number++] = "Может удалять комментарии от пользователей из групп с более низким рангом";
	
	$permissions_fields_names[$permissions_number] = 'can_delete_commentaries_from_users_in_groups_with_same_rank';
	$permissions_descriptions[$permissions_number++] = "Может удалять комментарии от пользователей из групп с таким же рангом";
	
	$permissions_fields_names2 = array();
	$permissions_descriptions2 = array();
	$permissions_number2 = 0;
	
	$permissions_fields_names2[$permissions_number2] = 'can_warn_users_in_lower_groups';
	$permissions_descriptions2[$permissions_number2++] = "Может выдавать предупреждения пользователям из групп с более низким рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_unwarn_warns_from_him';
	$permissions_descriptions2[$permissions_number2++] = "Может снимать выданные ими предупреждения";
	
	$permissions_fields_names2[$permissions_number2] = 'can_unwarn_warns_from_users_in_lower_groups';
	$permissions_descriptions2[$permissions_number2++] = "Может снимать предупреждения, выданные пользователями из групп с более низким рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_unwarn_warns_from_users_in_groups_with_same_rank';
	$permissions_descriptions2[$permissions_number2++] = "Может снимать предупреждения, выданные пользователями из групп с таким же рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_ban_users_in_lower_groups';
	$permissions_descriptions2[$permissions_number2++] = "Может выдавать баны пользователям из групп с более низким рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_unban_bans_from_him';
	$permissions_descriptions2[$permissions_number2++] = "Может снимать выданные ими баны";
	
	$permissions_fields_names2[$permissions_number2] = 'can_unban_bans_from_users_in_lower_groups';
	$permissions_descriptions2[$permissions_number2++] = "Может снимать баны, выданные пользователями из групп с более низким рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_unban_bans_from_users_in_groups_with_same_rank';
	$permissions_descriptions2[$permissions_number2++] = "Может снимать баны, выданные пользователями из групп с таким же рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_create_groups';
	$permissions_descriptions2[$permissions_number2++] = "Может создавать группы";
	
	$permissions_fields_names2[$permissions_number2] = 'can_edit_groups_from_him';
	$permissions_descriptions2[$permissions_number2++] = "Может изменять созданные ими группы";

	$permissions_fields_names2[$permissions_number2] = 'can_edit_groups_from_users_in_lower_groups';
	$permissions_descriptions2[$permissions_number2++] = "Может изменять группы, созданные пользователями из групп с более низким рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_edit_groups_from_users_in_groups_with_same_rank';
	$permissions_descriptions2[$permissions_number2++] = "Может изменять группы, созданные пользователями из групп с таким же рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_delete_groups_from_him';
	$permissions_descriptions2[$permissions_number2++] = "Может удалять созданные ими группы";
	
	$permissions_fields_names2[$permissions_number2] = 'can_delete_groups_from_users_in_lower_groups';
	$permissions_descriptions2[$permissions_number2++] = "Может удалять группы, созданные пользователями из групп с более низким рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_delete_groups_from_users_in_groups_with_same_rank';
	$permissions_descriptions2[$permissions_number2++] = "Может удалять группы, созданные пользователями из групп с таким же рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_edit_users_in_lower_groups';
	$permissions_descriptions2[$permissions_number2++] = "Может изменять профили пользователей из групп с более низким рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_change_users_in_lower_groups_attach_to_lower_groups';
	$permissions_descriptions2[$permissions_number2++] = "Может изменять привязку к группам пользователей из групп с более низким рангом";
	
	$permissions_fields_names2[$permissions_number2] = 'can_change_users_in_groups_with_same_rank_attach_to_lower_groups';
	$permissions_descriptions2[$permissions_number2++] = "Может изменять привязку к группам пользователей из групп с таким же рангом";

	/* Проверяет, имеет ли указанный пользователь доступ к странице "Управление группами". */
	function HasUserAccessToSpecialPanel($user_id) {
		$user_permissions = GetUserPermissions($user_id);
		if(
			$user_permissions['can_create_groups'] == 1 ||
			$user_permissions['can_edit_groups_from_him'] == 1 ||
			$user_permissions['can_edit_groups_from_users_in_lower_groups'] == 1 ||
			$user_permissions['can_edit_groups_from_users_in_groups_with_same_rank'] == 1 ||
			$user_permissions['can_delete_groups_from_him'] == 1 ||
			$user_permissions['can_delete_groups_from_users_in_lower_groups'] == 1 ||
			$user_permissions['can_delete_groups_from_users_in_groups_with_same_rank'] == 1
		)
		{
			return 1;
		}
		else return 0;
	}

	/* Возвращает максимальный ранг из всех групп указанного пользователя. */
	function GetUserMaxGroupRank($user_id) {
		global $mysqli;	
		
		$stmt = $mysqli->prepare("
			SELECT groups.rank
			FROM groups, users_to_groups
			WHERE (users_to_groups.user_id = ?)
			AND (users_to_groups.group_id = groups.id)
			ORDER BY groups.rank;
		");
		$stmt->bind_param("i", $user_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		$row = $result_set->fetch_assoc();
		$user_max_group_rank = 10000;
		if($row)
		{	
			$user_max_group_rank = $row['rank'];
		}
		return $user_max_group_rank;
	}
	
	/* Возвращает массив, содержащий значение прав от первого пользователя ко второму. Права:
			can_edit_user
			can_warn_user
			can_ban_user
			can_change_user_attach_to_lower_groups 
	*/
	function GetUserPermissionsToUser($user_id, $user_to_id) {
		$user_permissions = GetUserPermissions($user_id);
		
		$result_permissions = array();
		$result_permissions['can_edit_user'] = 0;
		$result_permissions['can_warn_user'] = 0;
		$result_permissions['can_ban_user'] = 0;
		$result_permissions['can_change_user_attach_to_lower_groups'] = 0;
		
		$user_max_group_rank = GetUserMaxGroupRank($user_id);
		$user_to_max_group_rank = GetUserMaxGroupRank($user_to_id);
		
		if($user_id == $user_to_id)
		{
			$result_permissions['can_edit_user'] = 1;
		}
		if($user_permissions['can_edit_users_in_lower_groups'] == 1)
		{
			if($user_max_group_rank < $user_to_max_group_rank)
			{
				$result_permissions['can_edit_user'] = 1;
			}
		}
		if($user_permissions['can_warn_users_in_lower_groups'] == 1)
		{
			if($user_max_group_rank < $user_to_max_group_rank)
			{
				$result_permissions['can_warn_user'] = 1;
			}
		}
		if($user_permissions['can_ban_users_in_lower_groups'] == 1)
		{
			if($user_max_group_rank < $user_to_max_group_rank)
			{
				$result_permissions['can_ban_user'] = 1;
			}
		}
		if($user_permissions['can_change_users_in_groups_with_same_rank_attach_to_lower_groups'] == 1)
		{
			if($user_max_group_rank == $user_to_max_group_rank)
			{
				$result_permissions['can_change_user_attach_to_lower_groups'] = 1;
			}
		}
		if($user_permissions['can_change_users_in_lower_groups_attach_to_lower_groups'] == 1)
		{
			if($user_max_group_rank < $user_to_max_group_rank)
			{
				$result_permissions['can_change_user_attach_to_lower_groups'] = 1;
			}
		}
		return $result_permissions;
	}
	
	/* Проверяет, может ли указанный пользователь снять указанный варн. */
	function CanUserUnwarnWarn($user_id, $warn_id) {
		global $mysqli;	
		
		$user_permissions = GetUserPermissions($user_id);
		
		$stmt = $mysqli->prepare("
			SELECT user_from_id
			FROM warns
			WHERE id = ?;
		");
		$stmt->bind_param("i", $warn_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		$row = $result_set->fetch_assoc();
		if($row)
		{	
			$user_from_id = $row['user_from_id'];
			
			if($user_permissions['can_unwarn_warns_from_him'] == 1)
			{
				if($user_from_id == $user_id)
				{
					return 1;
				}
			}
			
			$user_max_group_rank = GetUserMaxGroupRank($user_id);
			$user_from_max_group_rank = GetUserMaxGroupRank($user_from_id);
			
			if($user_permissions['can_unwarn_warns_from_users_in_lower_groups'] == 1)
			{
				if($user_max_group_rank < $user_from_max_group_rank)
				{
					return 1;
				}
			}
			
			if($user_permissions['can_unwarn_warns_from_users_in_groups_with_same_rank'] == 1)
			{
				if($user_max_group_rank == $user_from_max_group_rank)
				{
					return 1;
				}
			}
		}
		return 0;
	}
	
	/* Проверяет, может ли указанный пользователь снять указанный бан. */
	function CanUserUnbanBan($user_id, $ban_id) {
		global $mysqli;	
		
		$user_permissions = GetUserPermissions($user_id);
		
		$stmt = $mysqli->prepare("
			SELECT user_from_id
			FROM bans
			WHERE id = ?;
		");
		$stmt->bind_param("i", $ban_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		$row = $result_set->fetch_assoc();
		if($row)
		{	
			$user_from_id = $row['user_from_id'];
			
			if($user_permissions['can_unban_bans_from_him'] == 1)
			{
				if($user_from_id == $user_id)
				{
					return 1;
				}
			}
			
			$user_max_group_rank = GetUserMaxGroupRank($user_id);
			$user_from_max_group_rank = GetUserMaxGroupRank($user_from_id);
			
			if($user_permissions['can_unban_bans_from_users_in_lower_groups'] == 1)
			{
				if($user_max_group_rank < $user_from_max_group_rank)
				{
					return 1;
				}
			}
			
			if($user_permissions['can_unban_bans_from_users_in_groups_with_same_rank'] == 1)
			{
				if($user_max_group_rank == $user_from_max_group_rank)
				{
					return 1;
				}
			}
		}
		
		return 0;
	}
	
	/* Возвращает массив, содержащий значение прав от указанного пользователя к указанной группе. Права:
			"can_edit"
			"can_delete"
	*/
	function GetUserPermissionsToGroup($user_id, $group_id) {
		global $mysqli;	
		
		$result_permissions = array();
		$result_permissions['can_edit'] = 0;
		$result_permissions['can_delete'] = 0;
		
		$user_permissions = GetUserPermissions($user_id);
		
		$stmt = $mysqli->prepare("
			SELECT user_from_id
			FROM groups
			WHERE id = ?;
		");
		$stmt->bind_param("i", $group_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		$row = $result_set->fetch_assoc();
		if($row)
		{	
			$user_from_id = $row['user_from_id'];
			
			if($user_permissions['can_edit_groups_from_him'] == 1)
			{
				if($user_from_id == $user_id)
				{
					$result_permissions['can_edit'] = 1;
				}
			}
			
			$user_max_group_rank = GetUserMaxGroupRank($user_id);
			$user_from_max_group_rank = GetUserMaxGroupRank($user_from_id);
			
			if($user_permissions['can_edit_groups_from_users_in_lower_groups'] == 1)
			{
				if($user_max_group_rank < $user_from_max_group_rank)
				{
					$result_permissions['can_edit'] = 1;
				}
			}
			
			if($user_permissions['can_edit_groups_from_users_in_groups_with_same_rank'] == 1)
			{
				if($user_max_group_rank == $user_from_max_group_rank)
				{
					$result_permissions['can_edit'] = 1;
				}
			}
			
			if($group_id != -1 && $group_id != 1 && $group_id != 2 && $group_id != 3)
			{
				if($user_permissions['can_delete_groups_from_him'] == 1)
				{
					if($user_from_id == $user_id)
					{
						$result_permissions['can_delete'] = 1;
					}
				}
				
				$user_max_group_rank = GetUserMaxGroupRank($user_id);
				$user_from_max_group_rank = GetUserMaxGroupRank($user_from_id);
				
				if($user_permissions['can_delete_groups_from_users_in_lower_groups'] == 1)
				{
					if($user_max_group_rank < $user_from_max_group_rank)
					{
						$result_permissions['can_delete'] = 1;
					}
				}
				
				if($user_permissions['can_delete_groups_from_users_in_groups_with_same_rank'] == 1)
				{
					if($user_max_group_rank == $user_from_max_group_rank)
					{
						$result_permissions['can_delete'] = 1;
					}
				}
			}
		}
		
		return $result_permissions;
	}

	/* Возвращает массив, содержащий значение прав указанного пользователя. Права:
			"can_warn_users_in_lower_groups"
			"can_unwarn_warns_from_him"
			"can_unwarn_warns_from_users_in_lower_groups"
			"can_unwarn_warns_from_users_in_groups_with_same_rank"
			"can_ban_users_in_lower_groups"
			"can_unban_bans_from_him"
			"can_unban_bans_from_users_in_lower_groups"
			"can_unban_bans_from_users_in_groups_with_same_rank"
			"can_create_groups"
			"can_edit_groups_from_him"
			"can_edit_groups_from_users_in_lower_groups"
			"can_edit_groups_from_users_in_groups_with_same_rank"
			"can_delete_groups_from_him"
			"can_delete_groups_from_users_in_lower_groups"
			"can_delete_groups_from_users_in_groups_with_same_rank"
			"can_edit_users_in_lower_groups"
			"can_change_users_in_lower_groups_attach_to_lower_groups"
			"can_change_users_in_groups_with_same_rank_attach_to_lower_groups"
	*/
	function GetUserPermissions($user_id) {
		global $mysqli;	
						
		$group_id = 0;
		
		if($user_id == null) // если вход в аккаунт не выполнен - группа является группой guests (гости) (id = 2)
		{
			$stmt = $mysqli->prepare("SELECT groups.* FROM users_to_groups, groups WHERE (users_to_groups.user_id = 3) AND (users_to_groups.group_id = groups.id) ORDER BY groups.rank;"); // выборка по группам отсортирована по рангам
		}
		else
		{
			$stmt = $mysqli->prepare("SELECT groups.* FROM users_to_groups, groups WHERE (users_to_groups.user_id = ?) AND (users_to_groups.group_id = groups.id) ORDER BY groups.rank;"); // выборка по группам отсортирована по рангам
			$stmt->bind_param("i", $user_id);
		}
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$rows = $result_set->fetch_all();
		
		if($rows)
		{			
			$fields = $result_set->fetch_fields();
			$fields_count = sizeof($fields); // количество столбцов в выборке
			
			$first_permission_column_id = 5; // id первой привилегии
			$last_permission_column_id = $fields_count - 1; // id последней привилегии
			
			$result_fields_names = array(); // одномерный массив с правами (доступ как по id, так и по названию)
			
			for($i = $first_permission_column_id; $i <= $last_permission_column_id; $i++) // генерируем одномерный массив с названиями привилегий
			{
				$result_field_id = $i - $first_permission_column_id;
				$result_fields_names[$result_field_id] = $fields[$i]->name;
			}
			
			$result_permissions = array(); // одномерный массив с правами (доступ как по id, так и по названию)
				
			$result_permissions_number = $last_permission_column_id - $first_permission_column_id + 1;
				
			for($i = 0; $i < $result_permissions_number; $i++) // обнуление массива - разрешаем установку значений для каждой привигелии
			{
				$result_permissions[$i] = 2;
				// значение 0 запрещает привилегию, даже если она разрешена в более низких по рангу группах
				// значение 1 разрешает привилегию, даже если она запрещена в более низких по рангу группах
				// значение 2 будет изменено на 0, если не будет встречено значения 0 или 1 для этой привилегии в более изких по рангу группах
			}
				
			for($i = 0; $i < sizeof($rows); $i++) // так как пользователь может быть привязан к нескольким группам
			{
				for($i2 = $first_permission_column_id; $i2 <= $last_permission_column_id; $i2++){
					$result_permission_id = $i2 - $first_permission_column_id;
					$result_permission_name = $result_fields_names[$result_permission_id];
					if($result_permissions[$result_permission_id] == 2) // если для привилегии ещё не было установлено значение
					{
						$result_permissions[$result_permission_id] = $rows[$i][$i2]; // установка значения по id
						$result_permissions[$result_permission_name] = $rows[$i][$i2]; // установка значения по названию
					}
				}
			}
			
			for($i = 0; $i < $result_permissions_number; $i++) // обнуляем неустановленные привилегии
			{
				if($result_permissions[$i] == 2) // если для привилегии ещё не было установлено значение
				{
					$result_permissions[$i] = 0;
				}
			}
			return $result_permissions;
		}
		else return null;
	}
	
	/* Возвращает массив, содержащий значение прав от указанного пользователя к указанному форуму. Права:
			"can_see_this_forum"
			"can_edit_this_forum"
			"can_delete_this_forum"
			"can_create_forums"
			"can_create_topics"
			"can_create_commentaries"
			"can_edit_forums_from_him"
			"can_edit_forums_from_users_in_lower_groups"
			"can_edit_forums_from_users_in_groups_with_same_rank"
			"can_delete_forums_from_him"
			"can_delete_forums_from_users_in_lower_groups"
			"can_delete_forums_from_users_in_groups_with_same_rank"
			"can_edit_topics_from_him"
			"can_edit_topics_from_users_in_lower_groups"
			"can_edit_topics_from_users_in_groups_with_same_rank"
			"can_delete_topics_from_him"
			"can_delete_topics_from_users_in_lower_groups"
			"can_delete_topics_from_users_in_groups_with_same_rank"
			"can_edit_commentaries_from_him"
			"can_edit_commentaries_from_users_in_lower_groups"
			"can_edit_commentaries_from_users_in_groups_with_same_rank"
			"can_delete_commentaries_from_him"
			"can_delete_commentaries_from_users_in_lower_groups"
			"can_delete_commentaries_from_users_in_groups_with_same_rank"

	*/
	function GetUserForumPermissions($user_id, $forum_id, $set_2_to_0 = 1) {
		global $mysqli;	
						
		$group_id = 0;
		
		if($user_id == null) // если вход в аккаунт не выполнен - группа является группой guests (гости) (id = 2)
		{
			$stmt = $mysqli->prepare("SELECT * FROM groups_permissions_to_forums WHERE (group_id = 3) AND (forum_id = ?);");
			$stmt->bind_param("i", $forum_id);
		}
		else
		{
			$stmt = $mysqli->prepare("SELECT groups_permissions_to_forums.* FROM users_to_groups, groups_permissions_to_forums, groups WHERE (users_to_groups.user_id = ?) AND (users_to_groups.group_id = groups_permissions_to_forums.group_id) AND (groups_permissions_to_forums.forum_id = ?) AND (users_to_groups.group_id = groups.id) ORDER BY groups.rank;");
			$stmt->bind_param("ii", $user_id, $forum_id);
		}
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$rows = $result_set->fetch_all();
		
		if($rows)
		{			
			$fields = $result_set->fetch_fields();
			$fields_count = sizeof($fields); // количество столбцов в выборке
			
			$first_permission_column_id = 3; // id первой привилегии
			$last_permission_column_id = $fields_count - 1; // id последней привилегии
			
			$result_fields_names = array(); // одномерный массив с правами (доступ как по id, так и по названию)
			
			for($i = $first_permission_column_id; $i <= $last_permission_column_id; $i++) // генерируем одномерный массив с названиями привилегий
			{
				$result_field_id = $i - $first_permission_column_id;
				$result_fields_names[$result_field_id] = $fields[$i]->name;
			}
			
			$result_permissions = array(); // одномерный массив с правами (доступ как по id, так и по названию)
				
			$result_permissions_number = $last_permission_column_id - $first_permission_column_id + 1;
				
			for($i = 0; $i < $result_permissions_number; $i++) // обнуление массива - разрешаем установку значений для каждой привигелии
			{
				$result_permissions[$i] = 2;
				// значение 0 запрещает привилегию, даже если она разрешена в более низких по рангу группах
				// значение 1 разрешает привилегию, даже если она запрещена в более низких по рангу группах
				// значение 2 будет изменено на 0, если не будет встречено значения 0 или 1 для этой привилегии в более низких по рангу группах
			}
				
			for($i = 0; $i < sizeof($rows); $i++) // так как пользователь может быть привязан к нескольким группам
			{
				for($i2 = $first_permission_column_id; $i2 <= $last_permission_column_id; $i2++){
					$result_permission_id = $i2 - $first_permission_column_id;
					$result_permission_name = $result_fields_names[$result_permission_id];
					if($result_permissions[$result_permission_id] == 2) // если для привилегии ещё не было установлено значение
					{
						$result_permissions[$result_permission_id] = $rows[$i][$i2]; // установка значения по id
						$result_permissions[$result_permission_name] = $rows[$i][$i2]; // установка значения по названию
					}
				}
			}			
			
			// теперь, когда все принудительные права (0 или 1) установлены, нужно установить права со значением 2.
			if($forum_id != 0)
			{
				$is_all_permissions_set = 0;
				$parent_forum_id = $forum_id;
				$stmt = $mysqli->prepare("SELECT forum_id, user_from_id FROM forums WHERE (id = ?);");
				$stmt->bind_param("i", $forum_id);
				$stmt->execute();
				$result_set = $stmt->get_result();
					
				$row = $result_set->fetch_assoc();
					
				if($row)
				{		
					$parent_forum_id = $row['forum_id'];
					$user_permissions_to_parent_forum = GetUserForumPermissions($user_id, $parent_forum_id, 0);
					for($i = 0; $i < $result_permissions_number; $i++)
					{
						if($result_permissions[$i] == 2) // если для привилегии ещё не было установлено значение
						{
							$result_permission_name = $result_fields_names[$i];
							$result_permissions[$i] = $user_permissions_to_parent_forum[$i]; // установка значения по id
							$result_permissions[$result_permission_name] = $user_permissions_to_parent_forum[$i]; // установка значения по названию
							
							// устанавливаем неустановленные права согласно правам форума-родителя
							if($result_permissions[$i] != 1)
							{
								$user_from_id = $row['user_from_id']; // id создателя форума
									
								$is_user_and_user_from_same = 0; // текущий пользователь и создатель - один и тот же?
								if($user_from_id == $user_id)
								{
									$is_user_and_user_from_same = 1;
								}
									
								$is_user_rank_better_than_user_from_rank = 0; // ранг текущего пользователя лучше, чем у создателя форума?
								// находим наивысший ранг группы пользователя
								$user_rank = GetUserMaxGroupRank($user_id);
								// находим наивысший ранг группы пользователя, создавшего форум
								$user_from_rank = GetUserMaxGroupRank($user_from_id);
								if($user_from_rank > $user_rank) // если ранг создателя форума ниже, чем у текущего пользователя
								{	
									$is_user_rank_better_than_user_from_rank = 1;
								}	
									
								$is_user_rank_equally_user_from_rank = 0; // ранг текущего пользователя такой же, как у создателя форума?
								if($user_from_rank == $user_rank) // если ранг создателя форума такой же, как у текущего пользователя
								{	
									$is_user_rank_equally_user_from_rank = 1;
								}	
								
								$set_permission_to_true = 0;
								if($result_permission_name == 'can_edit_this_forum')
								{									
									if(($user_permissions_to_parent_forum['can_edit_forums_from_him'] == 1) &&
									($is_user_and_user_from_same))
									{
										$set_permission_to_true = 1;
									}
									if(($user_permissions_to_parent_forum['can_edit_forums_from_users_in_lower_groups'] == 1) &&
									($is_user_rank_better_than_user_from_rank))
									{		
										$set_permission_to_true = 1;
									}
									if(($user_permissions_to_parent_forum['can_edit_forums_from_users_in_groups_with_same_rank'] == 1) &&
									($is_user_rank_equally_user_from_rank))
									{			
										$set_permission_to_true = 1;
									}
								}
								else if($result_permission_name == 'can_delete_this_forum')
								{							
									if(($user_permissions_to_parent_forum['can_delete_forums_from_him'] == 1) &&
									($is_user_and_user_from_same))
									{
										$set_permission_to_true = 1;
									}
									if(($user_permissions_to_parent_forum['can_delete_forums_from_users_in_lower_groups'] == 1) &&
									($is_user_rank_better_than_user_from_rank))
									{		
										$set_permission_to_true = 1;
									}
									if(($user_permissions_to_parent_forum['can_delete_forums_from_users_in_groups_with_same_rank'] == 1) &&
									($is_user_rank_equally_user_from_rank))
									{			
										$set_permission_to_true = 1;
									}
								}
								
								if($set_permission_to_true)
								{
									$result_permissions[$i] = 1; // установка значения по id
									$result_permissions[$result_permission_name] = 1; // установка значения по названию
								}
							}
						}
					}
				}
			}
			
			if($set_2_to_0 == 1) // если выбрана настройка для замены всех значений 2 на значения 0
			{
				for($i = 0; $i < $result_permissions_number; $i++) // обнуляем неустановленные привилегии
				{
					if($result_permissions[$i] == 2) // если для привилегии ещё не было установлено значение
					{
						$result_permission_name = $result_fields_names[$i];
						$result_permissions[$i] = 0; // установка значения по id
						$result_permissions[$result_permission_name] = 0; // установка значения по названию
					}
				}
			}
			
			return $result_permissions;
		}
		else return null;
	}
	
	/* Возвращает массив, содержащий значение прав от указанного пользователя к указанной теме. Права:
			"can_see_this_topic"
			"can_edit_this_topic"
			"can_delete_this_topic"
			"can_create_commentaries"
			"can_edit_commentaries_from_him"
			"can_edit_commentaries_from_users_in_lower_groups"
			"can_edit_commentaries_from_users_in_groups_with_same_rank"
			"can_delete_commentaries_from_him"
			"can_delete_commentaries_from_users_in_lower_groups"
			"can_delete_commentaries_from_users_in_groups_with_same_rank"
	*/
	function GetUserTopicPermissions($user_id, $topic_id) {
		global $mysqli;	
		
		$stmt = $mysqli->prepare("SELECT forum_id, is_closed, user_from_id FROM topics WHERE (id = ?);");
		$stmt->bind_param("i", $topic_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$row = $result_set->fetch_assoc();
		
		if($row)
		{			
			$is_closed = $row['is_closed'];
			$forum_id = $row['forum_id'];
			$forum_permissions = GetUserForumPermissions($user_id, $forum_id);
						
			$result_permissions = array(); // одномерный массив с правами (доступ как по id, так и по названию)
			
			$result_permissions['can_see_this_topic'] = $forum_permissions['can_see_this_forum'];
			
			$user_from_id = $row['user_from_id'];
			
			$is_user_and_user_from_same = 0; // текущий пользователь и создатель - один и тот же?
			if($user_from_id == $user_id)
			{
				$is_user_and_user_from_same = 1;
			}
				
			$is_user_rank_better_than_user_from_rank = 0; // ранг текущего пользователя лучше, чем у создателя темы?
			// находим наивысший ранг группы пользователя
			$user_rank = GetUserMaxGroupRank($user_id);
			// находим наивысший ранг группы пользователя, создавшего тему
			$user_from_rank = GetUserMaxGroupRank($user_from_id);
			if($user_from_rank > $user_rank) // если ранг создателя темы ниже, чем у текущего пользователя
			{	
				$is_user_rank_better_than_user_from_rank = 1;
			}	
				
			$is_user_rank_equally_user_from_rank = 0; // ранг текущего пользователя такой же, как у создателя темы?
			if($user_from_rank == $user_rank) // если ранг создателя темы такой же, как у текущего пользователя
			{	
				$is_user_rank_equally_user_from_rank = 1;
			}	
			
			$set_permission_to_true = 0;	
			if(($forum_permissions['can_edit_topics_from_him'] == 1) &&
			($is_user_and_user_from_same))
			{
				$set_permission_to_true = 1;
			}
			if(($forum_permissions['can_edit_topics_from_users_in_lower_groups'] == 1) &&
			($is_user_rank_better_than_user_from_rank))
			{		
				$set_permission_to_true = 1;
			}
			if(($forum_permissions['can_edit_topics_from_users_in_groups_with_same_rank'] == 1) &&
			($is_user_rank_equally_user_from_rank))
			{			
				$set_permission_to_true = 1;
			}	
			if($set_permission_to_true)
			{
				$result_permissions['can_edit_this_topic'] = 1;
			}	
			
			$set_permission_to_true = 0;			
			if(($forum_permissions['can_delete_topics_from_him'] == 1) &&
			($is_user_and_user_from_same))
			{
				$set_permission_to_true = 1;
			}
			if(($forum_permissions['can_delete_topics_from_users_in_lower_groups'] == 1) &&
			($is_user_rank_better_than_user_from_rank))
			{		
				$set_permission_to_true = 1;
			}
			if(($forum_permissions['can_delete_topics_from_users_in_groups_with_same_rank'] == 1) &&
			($is_user_rank_equally_user_from_rank))
			{			
				$set_permission_to_true = 1;
			}
			if($set_permission_to_true)
			{
				$result_permissions['can_delete_this_topic'] = 1;
			}
			
			if($is_closed == 1) // если тема закрыта
			{
				$result_permissions['can_create_commentaries'] = 0;
			}
			else{
				$result_permissions['can_create_commentaries'] = $forum_permissions['can_create_commentaries'];
			}
			
			$result_permissions['can_edit_commentaries_from_him'] = $forum_permissions['can_edit_commentaries_from_him'];
			$result_permissions['can_edit_commentaries_from_users_in_lower_groups'] = $forum_permissions['can_edit_commentaries_from_users_in_lower_groups'];
			$result_permissions['can_edit_commentaries_from_users_in_groups_with_same_rank'] = $forum_permissions['can_edit_commentaries_from_users_in_groups_with_same_rank'];
			$result_permissions['can_delete_commentaries_from_him'] = $forum_permissions['can_delete_commentaries_from_him'];
			$result_permissions['can_delete_commentaries_from_users_in_lower_groups'] = $forum_permissions['can_delete_commentaries_from_users_in_lower_groups'];
			$result_permissions['can_delete_commentaries_from_users_in_groups_with_same_rank'] = $forum_permissions['can_delete_commentaries_from_users_in_groups_with_same_rank'];
			
			return $result_permissions;
		}
		else return null;
	}

	/* Возвращает массив, содержащий значение прав от указанного пользователя к указанному комментарию. Права:
			"can_edit_this_commentary"
			"can_delete_this_commentary"
	*/
	function GetUserCommentaryPermissions($user_id, $commentary_id) {
		global $mysqli;	
		
		$stmt = $mysqli->prepare("SELECT topic_id, user_from_id FROM commentaries WHERE (id = ?);");
		$stmt->bind_param("i", $commentary_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$row = $result_set->fetch_assoc();
		
		if($row)
		{			
			$topic_id = $row['topic_id'];
			$topic_permissions = GetUserTopicPermissions($user_id, $topic_id);
				
			$result_permissions = array(); // одномерный массив с правами (доступ как по id, так и по названию)
			
			$user_from_id = $row['user_from_id'];
			
			$is_user_and_user_from_same = 0; // текущий пользователь и создатель - один и тот же?
			if($user_from_id == $user_id)
			{
				$is_user_and_user_from_same = 1;
			}
				
			$is_user_rank_better_than_user_from_rank = 0; // ранг текущего пользователя лучше, чем у создателя темы?
			// находим наивысший ранг группы пользователя
			$user_rank = GetUserMaxGroupRank($user_id);	
			// находим наивысший ранг группы пользователя, создавшего тему
			$user_from_rank = GetUserMaxGroupRank($user_from_id);
			if($user_from_rank > $user_rank) // если ранг создателя темы ниже, чем у текущего пользователя
			{	
				$is_user_rank_better_than_user_from_rank = 1;
			}	
				
			$is_user_rank_equally_user_from_rank = 0; // ранг текущего пользователя такой же, как у создателя темы?
			if($user_from_rank == $user_rank) // если ранг создателя темы такой же, как у текущего пользователя
			{	
				$is_user_rank_equally_user_from_rank = 1;
			}	
			
			$set_permission_to_true = 0;	
			if(($topic_permissions['can_edit_commentaries_from_him_from_him'] == 1) &&
			($is_user_and_user_from_same))
			{
				$set_permission_to_true = 1;
			}
			if(($topic_permissions['can_edit_commentaries_from_users_in_lower_groups'] == 1) &&
			($is_user_rank_better_than_user_from_rank))
			{		
				$set_permission_to_true = 1;
			}
			if(($topic_permissions['can_edit_commentaries_from_users_in_groups_with_same_rank'] == 1) &&
			($is_user_rank_equally_user_from_rank))
			{			
				$set_permission_to_true = 1;
			}		
			if($set_permission_to_true)
			{
				$result_permissions['can_edit_this_commentary'] = 1;
			}
			else{
				$result_permissions['can_edit_this_commentary'] = 0;
			}
			
			$set_permission_to_true = 0;			
			if(($topic_permissions['can_delete_commentaries_from_him'] == 1) &&
			($is_user_and_user_from_same))
			{
				$set_permission_to_true = 1;
			}
			if(($topic_permissions['can_delete_commentaries_from_users_in_lower_groups'] == 1) &&
			($is_user_rank_better_than_user_from_rank))
			{		
				$set_permission_to_true = 1;
			}
			if(($topic_permissions['can_delete_commentaries_from_users_in_groups_with_same_rank'] == 1) &&
			($is_user_rank_equally_user_from_rank))
			{			
				$set_permission_to_true = 1;
			}
			if($set_permission_to_true)
			{
				$result_permissions['can_delete_this_commentary'] = 1;
			}
			else{
				$result_permissions['can_delete_this_commentary'] = 0;
			}
			
			return $result_permissions;
		}
		else return null;
	}
	
	/* Проверяет, существует ли указанный форум. */
	function IsForumExist($forum_id) {
		global $mysqli;	
		
		$stmt = $mysqli->prepare("SELECT id FROM forums WHERE (id = ?);");
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$rows = $result_set->fetch_row();
		
		if($rows)
		{		
			return 1;
		}
		else
		{
			return 0;
		}
	}

	/* Проверяет, существует ли указанная тема. */
	function IsTopicExist($topic_id) {
		global $mysqli;	
		
		$stmt = $mysqli->prepare("SELECT id FROM topics WHERE (id = ?);");
		$stmt->bind_param("i", $topic_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$rows = $result_set->fetch_row();
		
		if($rows)
		{		
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	/* Проверяет, существует ли указанный комментарий. */
	function IsCommentaryExist($commentary_id) {
		global $mysqli;	
		
		$stmt = $mysqli->prepare("SELECT id FROM commentaries WHERE (id = ?);");
		$stmt->bind_param("i", $commentary_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$rows = $result_set->fetch_row();
		
		if($rows)
		{		
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	/* Возвращает одномерный массив, содержащий список форумов, от корня, до форума, содержащего указанный форум. Массив содержит два ключа для каждого форума, по типу:
		"id_0"
		"name_0"
	для первого сверху форума. */
	function GetForumTreeAsMass($forum_id) {
		global $mysqli;
		
		$invert_mass = array();
		
		$previous_forum_id = $forum_id;
		$total_forum_id = $forum_id;
		
		$count = 0;
		$was_main_forum = 0;
		while($total_forum_id != 0 || ($was_main_forum == 0))
		{
			$stmt = $mysqli->prepare("SELECT id, name, forum_id FROM forums WHERE (id = ?);");
			$stmt->bind_param("i", $total_forum_id);
			$stmt->execute();
			$result_set = $stmt->get_result();
					
			$row = $result_set->fetch_assoc();
			$invert_mass["id_".$count] = $row['id'];
			$invert_mass["name_".$count] = $row['name'];
			CheckStringValue($invert_mass["name_".$count]);
			
			if($total_forum_id == 0)
			{
				$was_main_forum = 1;
			}
			
			$total_forum_id = $row['forum_id'];
			$count++;
		}
		
		$result_mass = array();
		
		for($i = 0; $i < $count; $i++)
		{
			$result_mass["id_".$i] = $invert_mass["id_".($count - $i - 1)];
			$result_mass["name_".$i] = $invert_mass["name_".($count - $i - 1)];
		}
		
		return $result_mass;
	}
	
	/* Возвращает одномерный массив, содержащий список форумов, в указанном форуме для указанного пользователя (так как некоторые форумы могут быть недоступны пользователю). Массив содержит пять ключей для каждого форума, по типу:
		"id_0"
		"name_0"
		"is_category_0"
		"description_0"
		"is_description_hided_0"
	для первого форума в списке. Форумы отсортированы по названию.*/
	function GetForumsInThisForumAsMass($forum_id, $user_id) {
		global $mysqli;
		
		$result_mass = array();
		
		$stmt = $mysqli->prepare("SELECT id, name, is_category, description, is_description_hided FROM forums WHERE (forum_id = ?) ORDER BY is_category, name;");
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		
		$relative_position_id = 0;
		while($row = $result_set->fetch_assoc())
		{
			$user_permissions = GetUserForumPermissions($user_id, $row['id']);
			$can_see_this_forum = $user_permissions['can_see_this_forum'];
			
			if($can_see_this_forum == 1) // если пользователь может видеть форум
			{
				if($row['id'] != 0) // проверка на главный форум, так как родитель главного форума есть сам главный форум - его не нужно добавлять в этот список
				{
					$result_mass["id_".$relative_position_id] = $row['id'];
					$result_mass["name_".$relative_position_id] = $row['name'];
					CheckStringValue($result_mass["name_".$relative_position_id]);
					$result_mass["is_category_".$relative_position_id] = $row['is_category'];
					$result_mass["description_".$relative_position_id] = $row['description'];
					CheckStringValue($result_mass["description_".$relative_position_id]);
					$result_mass["is_description_hided_".$relative_position_id] = $row['is_description_hided'];
					$relative_position_id++;
				}
			}
		}
		
		
		return $result_mass;
	}
	
	/* Возвращает одномерный массив, содержащий список тем, в указанном форуме. Массив содержит пять ключей для каждого форума, по типу:
		"id_0"
		"name_0"
		"description_0"
		"is_description_hided_0"
		"is_closed_0"
	для первой теме в списке. Темы отсортированы по названию. */
	function GetTopicsInThisForumAsMass($forum_id) {
		global $mysqli;
		
		$result_mass = array();
		
		$stmt = $mysqli->prepare("SELECT id, name, description, is_description_hided, is_closed FROM topics WHERE (forum_id = ?) ORDER BY name;");
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$relative_position_id = 0;
		while($row = $result_set->fetch_assoc())
		{
			$result_mass["id_".$relative_position_id] = $row['id'];
			$result_mass["name_".$relative_position_id] = $row['name'];
			CheckStringValue($result_mass["name_".$relative_position_id]);
			$result_mass["description_".$relative_position_id] = $row['description'];
			CheckStringValue($result_mass["description_".$relative_position_id]);
			$result_mass["is_description_hided_".$relative_position_id] = $row['is_description_hided'];
			$result_mass["is_closed_".$relative_position_id] = $row['is_closed'];
			$relative_position_id++;
		}
		
		return $result_mass;
	}
	
	/* Выводит строчки таблицы с форумами и темами в указанном форуме для указанного пользователя (так как некоторые форумы могут быть недоступны пользователю). Данная функция является вспомогательной для EchoForumTable(...). */
	function EchoForumsInThisForumTable($forum_id, $user_id) {
		$forums_in_this_forum = GetForumsInThisForumAsMass($forum_id, $user_id);
		$forums_in_this_forum_count = sizeof($forums_in_this_forum) / 5;
			
		$was_category_in_this_forum = 0;
		for($i = 0; $i < $forums_in_this_forum_count; $i++)
		{
			if($forums_in_this_forum["is_category_".$i] == 1) // если категория - вывод категории и все форумов в ней
			{
				if($was_category_in_this_forum == 0){
					EchoTopicsInThisForumTable($forum_id);
					$was_category_in_this_forum = 1;
				}
				echo "<tr class=\"category\">";
					echo "<td colspan=\"5\">";
						echo "<b><a href=\"/forum?id=".$forums_in_this_forum["id_".$i]."\">";
							echo $forums_in_this_forum["name_".$i];
						echo "</a></b>";
						if($forums_in_this_forum["is_description_hided_".$i] == 0) // если описание не скрыто
						{
							echo "<br/>".$forums_in_this_forum["description_".$i];
						}
					echo "</td>";
				echo "</tr>";
				
				$has_forums_or_topics = IsAnyForumsOrTopicsInThisForum($forums_in_this_forum["id_".$i], $user_id);
				if($has_forums_or_topics == 1) // если в форуме есть форумы или темы
				{
					EchoForumsInThisForumTable($forums_in_this_forum["id_".$i], $user_id);
				}
				else
				{
					echo "	<tr class=\"category\">";
					echo "		<td colspan=\"5\">";
					echo "		Нет форумов или тем!";
					echo "		</td>";
					echo "	</tr>";
				}
			}
			else // если не категория - обычный вывод информации
			{				
				echo "<tr>";
					echo "<td class = \"forum_table_td_1 forum_table_td_icon forum_table_td_icon_forum\">";
					echo "	<a href=\"/forum?id=".$forums_in_this_forum["id_".$i]."\"><div></div></a>";
					echo "</td>";
					echo "<td class = \"forum_table_td_2\">";
						echo "<b><a href=\"/forum?id=".$forums_in_this_forum["id_".$i]."\">";
							echo $forums_in_this_forum["name_".$i];
						echo "</a></b>";
						if($forums_in_this_forum["is_description_hided_".$i] == 0) // если описание не скрыто
						{
							echo "<br/>".$forums_in_this_forum["description_".$i];
						}
					echo "</td>";
					echo "<td class = \"forum_table_td_3\">";
						echo GetTopicsCountInForum($forums_in_this_forum["id_".$i], $user_id);
					echo "</td>";
					echo "<td class = \"forum_table_td_4\">";
						echo GetCommentariesCountInForum($forums_in_this_forum["id_".$i], $user_id);
					echo "</td>";
					echo "<td class = \"forum_table_td_5\">";
						echo GetInfoTextLastCommentaryInForum($forums_in_this_forum["id_".$i], $user_id);
					echo "</td>";
				echo "</tr>";
			}
		}
		
		if($was_category_in_this_forum == 0){
			EchoTopicsInThisForumTable($forum_id);
		}
	}
	
	/* Выводит строчки таблицы с темами в указанном форуме. Данная функция является вспомогательной для EchoForumsInThisForumTable(...). */
	function EchoTopicsInThisForumTable($forum_id) {
		$topics_in_this_forum = GetTopicsInThisForumAsMass($forum_id);
		$topics_in_this_forum_count = sizeof($topics_in_this_forum) / 5;
			
		for($i = 0; $i < $topics_in_this_forum_count; $i++)
		{
				echo "<tr class=\"topics\">";
					$is_closed = $topics_in_this_forum["is_closed_".$i];
					$class = "forum_table_td_icon_topic";
					if($is_closed == 1) // если тема закрыта - меняем иконку
					{
						$class = "forum_table_td_icon_topic_closed";
					}
					echo "<td class = \"forum_table_td_1 forum_table_td_icon $class\">";
					echo "	<a href=\"/topic?id=".$topics_in_this_forum["id_".$i]."\"><div></div></a>";
					echo "</td>";
					echo "<td class = \"forum_table_td_2\">";
						echo "<b><a href=\"/topic?id=".$topics_in_this_forum["id_".$i]."\">";
							echo $topics_in_this_forum["name_".$i];
						echo "</a></b>";
						if($topics_in_this_forum["is_description_hided_".$i] == 0) // если описание не скрыто
						{
							echo "<br/>".$topics_in_this_forum["description_".$i];
						}
					echo "</td>";
					echo "<td class = \"forum_table_td_4\">";
						echo "-";
					echo "</td>";
					echo "<td class = \"forum_table_td_4\">";
					echo GetCommentariesCountInTopic($topics_in_this_forum["id_".$i]);
					echo "</td>";
					echo "<td class = \"forum_table_td_5\">";
						echo GetInfoTextLastCommentaryInTopic($topics_in_this_forum["id_".$i]);
					echo "</td>";
				echo "</tr>";
		}
	}
		
	/* Проверяет, содержит ли указанный форум другие форумы или темы. Есть возможность не учитывать форумы-категории. Также передаётся ID пользователя, так как некотоые форумы могут быть недоступны пользователю. */
	function IsAnyForumsOrTopicsInThisForum($forum_id, $user_id, $skip_categories = 0) {
		global $mysqli;	
		
		$stmt = $mysqli->prepare("SELECT id FROM forums WHERE (forum_id = ?);");
		if($skip_categories == 1) // если категории учитывать не нужно
		{
			$stmt = $mysqli->prepare("SELECT id FROM forums WHERE (forum_id = ?) AND (is_category = 0);");
		}
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
				
		
		while($row = $result_set->fetch_assoc()) // есть ли форумы
		{		
			$user_permissions_to_forum = GetUserForumPermissions($user_id, $row['id']);
			if($user_permissions_to_forum['can_see_this_forum'] == 1)
			{
				if($row['id'] != $forum_id) {
					return 1;
				}
			}
		}
		
		$stmt = $mysqli->prepare("SELECT id FROM topics WHERE (forum_id = ?);");
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
				
		$row = $result_set->fetch_assoc();
		
		if($row) // есть ли темы
		{		
			return 1;
		}
		return 0;
	}
		
	/* Проверяет, содержит ли указанный форум другие форумы или темы. Есть возможность не учитывать форумы-категории. Также передаётся ID пользователя, так как некотоые форумы могут быть недоступны пользователю. */
	function IsAnyForumsInThisForum($forum_id, $user_id) {
		global $mysqli;	
		
		$stmt = $mysqli->prepare("SELECT id FROM forums WHERE (forum_id = ?);");
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
				
		
		while($row = $result_set->fetch_assoc()) // есть ли форумы
		{		
			$user_permissions_to_forum = GetUserForumPermissions($user_id, $row['id']);
			if($user_permissions_to_forum['can_see_this_forum'] == 1)
			{
				if($row['id'] != $forum_id) {
					return 1;
				}
			}
		}
		
		return 0;
	}
		
	/* Выводит таблицу форумов и тем в указанном форуме для указанного пользователя (так как некоторые форумы могут быть недоступны пользователю). */
	function EchoForumTable($forum_id, $user_id) {
		global $mysqli;	
		
		$stmt = $mysqli->prepare("SELECT name, description, is_description_hided FROM forums WHERE (id = ?);");
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
				
		$row = $result_set->fetch_assoc();
		
		if($row)
		{		
			$forum_tree_mass = GetForumTreeAsMass($forum_id);
			$forum_tree_size = sizeof($forum_tree_mass) / 2;
			if($forum_tree_size >= 1){
				echo "<div class=\"forum_table_forums_names\">";
				for($i = 0; $i < $forum_tree_size; $i++)
				{
					if($i != 0){
						echo "<div> > </div>";
					}
					if($forum_tree_mass['id_'.$i] == $forum_id) // если текущий форум совпадает с тем, название которого выводится
					{
						echo "<div><b><a class=\"total_select\">".$forum_tree_mass['name_'.$i]."</a></b></div>";
					}
					else // если текущий форум не совпадает с тем, название которого выводится
					{
						echo "<div><b><a href=\"/forum?id=".$forum_tree_mass['id_'.$i]."\">".$forum_tree_mass['name_'.$i]."</a></b></div>";
					}
				}
				echo "</div>";
				echo "<div class='clear'></div>";	
			}
			
			echo "<table class = \"forum_table\">";
				
			// вывод заголовков столбцов
			echo "	<tr>";
			echo "		<th class = \"forum_table_th_2\" colspan=\"2\">Название</th>";
			echo "		<th class = \"forum_table_th_3\">Тем</th>";
			echo "		<th class = \"forum_table_th_4\">Сообщений</th>";
			echo "		<th class = \"forum_table_th_5\">Последнее сообщение</th>";
			echo "	</tr>";
			
			$has_forums_not_categories_or_topics = IsAnyForumsOrTopicsInThisForum($forum_id, $user_id, 1);
			$has_forums_or_topics = IsAnyForumsOrTopicsInThisForum($forum_id, $user_id);
			
			if($has_forums_not_categories_or_topics || $has_forums_or_topics == 0) // если в форуме, помимо категорий, есть другие форумы или темы
			{
				// вывод названия форума
				$forum_name = $row['name'];
				CheckStringValue($forum_name);
				$is_description_hided = $row['is_description_hided'];
				$forum_description = $row['description'];
				CheckStringValue($forum_description);
				echo "	<tr class=\"category\">";
				echo "	<td colspan=\"5\">";
				echo "	<b><a class=\"total_select\">";
				echo $forum_name;
				echo "	</a></b>";
				if($is_description_hided == 0) // если описание не скрыто
				{
					echo "<br/>".$forum_description;
				}
				echo "	</td>";
				echo "	</tr>";
			}
			
			if($has_forums_or_topics == 1) // если в форуме есть форумы или темы
			{
				EchoForumsInThisForumTable($forum_id, $user_id);
			}
			else
			{
				echo "	<tr class=\"category\">";
				echo "		<td colspan=\"5\">";
				echo "		Нет форумов или тем!";
				echo "		</td>";
				echo "	</tr>";
			}
			
			echo "</table>";
		}
		else
		{
			echo "Форум не найден!";
		}
	}
	
	/* Выводит таблицу с комментариями в указанной теме для указанного пользователя (так как проверяются права пользователя для каждого выводимого комментария). */
	function EchoTopicTable($topic_id, $user_id, $limit, $offset, $action = 'view') {
		global $mysqli;	
		
		$stmt = $mysqli->prepare("SELECT name, description, is_description_hided, forum_id, is_closed FROM topics WHERE (id = ?);");
		$stmt->bind_param("i", $topic_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
				
		$row = $result_set->fetch_assoc();
		
		if($row)
		{		
			$forum_id = $row['forum_id'];
			$topic_name = $row['name'];
			CheckStringValue($topic_name);
			if($row['is_closed'] == 1) // если тема закрыта
			{
				$topic_name .= " <span class='topic_closed'>(Тема закрыта)</span>";
			}
			else
			{
				$topic_name .= " <span class='topic_opened'>(Тема открыта)</span>";
			}
			
			echo "<table class = \"topic_table\">";
			
			$was_first = 0;
			if($_GET['page'] == 1 || $_GET['page'] === null){
				echo "	<tr>";
				echo "		<td colspan=\"2\">";
				echo "			<b>".$topic_name."</b>";
				echo "		</td>";
				echo "	</tr>";
			}
			else{
				echo "	<tr>";
				echo "		<td colspan=\"2\">";
				echo "			<b>Комментарии:</b>";
				echo "		</td>";
				echo "	</tr>";
				$was_first = 1;
			}
			
			$stmt = $mysqli->prepare("SELECT id, user_from_id, text, creation_datetime_int FROM commentaries WHERE (topic_id = ?) LIMIT ? OFFSET ?;");
			$stmt->bind_param("iii", $topic_id, $limit, $offset);
			$stmt->execute();
			$result_set = $stmt->get_result();
					
			$row = $result_set->fetch_assoc();
			
			$commentaries = 0;
			if($row)
			{	
				do
				{
					$user_from_id = $row['user_from_id'];
					
					$stmt2 = $mysqli->prepare("SELECT * FROM users WHERE (id = ?);");
					$stmt2->bind_param("i", $user_from_id);
					$stmt2->execute();
					$result_set2 = $stmt2->get_result();
							
					$row2 = $result_set2->fetch_assoc();
					
					echo "	<tr>";
					echo "		<td rowspan=\"2\" class=\"td_visitka\">";
					$tag_name = "scroll-to-commentary-".$commentaries;
					
					if($commentaries != 0)
					{
						$tag_name_prev = "scroll-to-commentary-".($commentaries-1);
					}
					else
					{
						$tag_name_prev = "scroll-to-commentary-0";
					}
					
					if($was_first == 1){
						echo "			<a id=\"".$tag_name."\"></a>";
					}
					echo "			<div class=\"topic_table_commentary_visitka\">
										<div class=\"topic_table_commentary_profile_name\">
					";
												$profile_nick = $row2["nick"];
												CheckStringValue($profile_nick);
												echo $profile_nick;
					echo "				</div>
										<div class=\"topic_table_commentary_status\">
					";
												if(IsBanned($user_from_id)){
													echo "<div class='status_banned'>Забанен</div>";
												}
												else{
													$last_active_datetime_int = $row2["last_active_datetime_int"];
													if((GetLocalTime(time()) - $last_active_datetime_int)/60 >= 5){
														echo "<div class='status_offline'>Оффлайн</div>";
													}
													else{
														echo "<div class='status_online'>Онлайн</div>";
													}
												}
					echo "				</div>";
											$avatar_link = $row2["avatar_link"];
											if($avatar_link == null){
												$avatar_link = "/img/profile_no_avatar.png";
											}
											CheckStringValue($avatar_link);
					echo "				<div class=\"topic_table_commentary_avatar\" style=\"background-image: url(".$avatar_link.");\">
										</div>
										<div class=\"topic_table_commentary_rank\">
					";
												$role = $row2["role"];
												CheckStringValue($role);
												if($role == null){
													$role = "Пользователь";
												}
												echo $role;
					echo "				</div>
									</div>
					";
					
					echo "		</td>";
					echo "		<td class=\"reg_date_info\">";
					$datetime_int = $row["creation_datetime_int"];
					echo "			<div class=\"reg_date_text\">".gmdate("d.m.Y - H:i:s", $datetime_int)."</div>";
					
					if(($_GET['page'] != 1 && $_GET['page'] !== null) || $was_first !== 0) // самый первый комментарий в теме нельзя редактировать или удалить, так как он является "текстом темы"
					{
						$commentary_id = $row['id'];
						$user_permissions_to_commentary = GetUserCommentaryPermissions($user_id, $commentary_id);
						$can_edit_this_commentary = $user_permissions_to_commentary['can_edit_this_commentary'];
						$can_delete_this_commentary = $user_permissions_to_commentary['can_delete_this_commentary'];
						
						$is_editing_commentary = 0;
						if($can_edit_this_commentary == 1 && $_GET['action'] == 'edit-commentary' && $_GET['commentary-id'] == $commentary_id) // если идёт редактирование текущего комментария
						{
							$is_editing_commentary = 1;
						}
						
						$is_deleting_commentary = 0;
						if($can_delete_this_commentary == 1 && $_GET['action'] == 'delete-commentary' && $_GET['commentary-id'] == $commentary_id) // если идёт удаление текущего комментария
						{
							$is_deleting_commentary = 1;
						}
						
						$url_with_page = "/topic?id=".$topic_id;
						if($_GET['page'] !== null)
						{
							$url_with_page .= "&page=".$_GET['page'];
						}
						
						if($is_editing_commentary == 0 && $is_deleting_commentary == 0)
						{
							if($can_edit_this_commentary || $can_delete_this_commentary)
							{
								echo "<div class=\"commentary_buttons\">";
							}
							if($can_edit_this_commentary)
							{
								echo "<a class='article_menu_button_blue' href='".$url_with_page."&action=edit-commentary&commentary-id=".$commentary_id."#".$tag_name."'>Изменить</a> ";
							}
							if($can_delete_this_commentary)
							{
								echo "<a class='article_menu_button_blue' href='".$url_with_page."&action=delete-commentary&commentary-id=".$commentary_id."#".$tag_name."'>Удалить</a> ";
							}
							if($can_edit_this_commentary || $can_delete_this_commentary)
							{
								echo "</div>";
							}
						}
					}
					
					echo "		</td>";
					echo "	</tr>";
					echo "	<tr>";
					echo "		<td class=\"commentary commentary_create\">";
					$commentary = $row['text'];
					$commentary = htmlspecialchars($commentary); // Преобразует специальные символы в HTML-сущности
					if($is_editing_commentary)
					{
						echo "			<form method=\"POST\" action='".$url_with_page."#".$tag_name."'>";
						echo "				<input type=\"hidden\" name=\"commentary-id\" value=".$_GET['commentary-id'].">";
						if($_POST['edited-commentary'] === null){
							$_POST['edited-commentary'] = $commentary;
						}
						echo "				<textarea required rows=\"7\" maxlength=\"8191\" name=\"edited-commentary\" id=\"commentary\">".$_POST['edited-commentary']."</textarea>";
						
						global $errors_number;
						global $errors_text;
						
						
						if(sizeof($errors_text) > 0)
						{
							echo "<div class=\"forum_form_errors\">";
								
							for($i = 0; $i < $errors_number; $i++){
								echo "<div class=\"error_text\">".$errors_text[$i]."</div>";
							}
								
							echo "</div>";
						}
						
						echo "				<input type=\"submit\" value=\"Подтвердить изменение\" name=\"button_submit_edit\">";
						echo "				<a href='".$url_with_page."#".$tag_name."'><input type=\"button\" value=\"Отмена\" name=\"button_cancel\"></a>";
						echo "			</form>";
					}
					else
					{
						echo "			".$commentary;
						if($is_deleting_commentary == 1)
						{
							echo "			<form method=\"POST\" action='".$url_with_page."#".$tag_name_prev."'>";
							echo "				<input type=\"hidden\" name=\"commentary-id\" value=".$_GET['commentary-id'].">";
							echo "				<label>";
							echo "					<b><i><br/>Вы действительно хотите удалить комментарий?<br/>Отменить это действие будет невозможно.</b></i><br/>";
							echo "				</label>";
							echo "				<input type=\"submit\" value=\"Подтвердить удаление\" name=\"button_submit_delete\">";
							echo "				<a href='".$url_with_page."#".$tag_name."'><input type=\"button\" value=\"Отмена\" name=\"button_cancel\"></a>";
							echo "			</form>";
						}
					}
					echo "		</td>";
					echo "	</tr>";
					
					if($was_first == 1)
					{
						$commentaries++;
					}
					
					if($was_first === 0)
					{
						echo "</table>";
						echo "<table class = \"topic_table\">";
						echo "	<tr>";
						echo "		<td colspan=\"2\">";
						echo "			<b>Комментарии:</b>";
						echo "		</td>";
						echo "	</tr>";
						$was_first = 1;
					}
				} while ($row = $result_set->fetch_assoc());
			}
			if ($commentaries == 0){
				echo "	<tr>";
				echo "		<td colspan=\"2\">";
				echo "			Нет комментариев";
				echo "		</td>";
				echo "	</tr>";
			}
			
			echo "</table>";
			
			$user_permissions_to_topic = GetUserTopicPermissions($user_id, $topic_id);
			
			if($user_permissions_to_topic['can_create_commentaries'] == 1)
			{
				$stmt = $mysqli->prepare("SELECT * FROM users WHERE (id = ?);");
				$stmt->bind_param("i", $user_id);
				$stmt->execute();
				$result_set = $stmt->get_result();
						
				$row = $result_set->fetch_assoc();
				
				echo "<table class = \"topic_table\">";
				
				echo "	<tr>";
				echo "		<td colspan=\"2\">";
				echo "			<b>Добавить комментарий</b>";
				echo "		</td>";
				echo "	</tr>";
				
				echo "	<tr>";
				echo "		<td class=\"td_visitka\">";
				echo "			<div class=\"topic_table_commentary_visitka\">
									<div class=\"topic_table_commentary_profile_name\">
				";
											$profile_nick = $row["nick"];
											CheckStringValue($profile_nick);
											echo $profile_nick;
				echo "				</div>
									<div class=\"topic_table_commentary_status\">
				";
											if(IsBanned($user_from_id)){
												echo "<div class='status_banned'>Забанен</div>";
											}
											else{
												$last_active_datetime_int = $row["last_active_datetime_int"];
												if((GetLocalTime(time()) - $last_active_datetime_int)/60 >= 5){
													echo "<div class='status_offline'>Оффлайн</div>";
												}
												else{
													echo "<div class='status_online'>Онлайн</div>";
												}
											}
				echo "				</div>";
										$avatar_link = $row["avatar_link"];
										if($avatar_link == null){
											$avatar_link = "/img/profile_no_avatar.png";
										}
										CheckStringValue($avatar_link);
				echo "				<div class=\"topic_table_commentary_avatar\" style=\"background-image: url(".$avatar_link.");\">
									</div>
									<div class=\"topic_table_commentary_rank\">
				";
											$role = $row["role"];
											if($role == null){
												$role = "Пользователь";
											}
											CheckStringValue($role);
											echo $role;
				echo "				</div>
								</div>
				";
				
				echo "		</td>";
				echo "		<td class=\"commentary commentary_create\">";
				echo "			<form method=\"POST\">";
				echo "				<a id=\"create-commentary\"></a>";
				echo "				<textarea required rows=\"9\" maxlength=\"8191\" name=\"commentary\" id=\"commentary\">".$_POST['commentary']."</textarea>";
				
				if($action != 'edit' && $action != 'delete'){
					global $errors_number;
					global $errors_text;
					
					
					if(sizeof($errors_text) > 0)
					{
						echo "<div class=\"forum_form_errors\">";
							
						for($i = 0; $i < $errors_number; $i++){
							echo "<div class=\"error_text\">".$errors_text[$i]."</div>";
						}
							
						echo "</div>";
					}
				}
				
				echo "				<input type=\"submit\" value=\"Отправить\" name=\"button_submit\">";
				echo "			</form>";
				echo "		</td>";
				echo "	</tr>";
				
				echo "</table>";
			}
		}
		else
		{
			echo "Тема не найдена!";
		}
	}
		
	/* Вспомогательная функция для EchoForumsTreeInSelectTag(...). Выводит опции выпадающего списка. */
	function EchoForumsTreeInSelectTag_EchoOptions($user_id, $selected_id = 0, $forum_id = 0, $space_offset) {
		$forums_tree = GetForumsInThisForumAsMass($forum_id, $user_id);
		
		if($selected_id == "") // в случае, если запроса POST не было и он пустой
		{
			$selected_id = 0;
		}
		
		$forums_number = sizeof($forums_tree) / 5;
		for($i = 0; $i < $forums_number; $i++)
		{
			$id = $forums_tree["id_".$i];
			$name = $forums_tree["name_".$i];
			
			$user_permissions_to_forum = GetUserForumPermissions($user_id, $id);
			$can_create_forums = $user_permissions_to_forum['can_create_forums'];
			
			if($can_create_forums)
			{
				echo "	<option value=\"$id\" "; if($selected_id === "".$id) echo "selected"; echo ">";
				echo $space_offset."► ".$name;
				echo "	</option>";
			}
			
			if(IsAnyForumsInThisForum($id, $user_id)) // если в форуме есть другие форумы
			{
				// выводим рекурсивно все форумы
				EchoForumsTreeInSelectTag_EchoOptions($user_id, $selected_id, $id, $space_offset."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
			}
		}
	}
	
	/* Выводит выпадающий список со всеми видимыми для пользователя форумами. */
	function EchoForumsTreeInSelectTag($user_id, $selected_id = "0", $forum_id, $action, $is_topic = 0) {
		echo "<select name=\"forums_tree\" "; if($forum_id == 0 && $action == 'edit' && $is_topic == 0){ echo "disabled"; } echo ">";
		
		echo "	<option value=\"0\" "; if($selected_id === "0") echo "selected"; echo ">";
		echo "Главный форум";
		echo "	</option>";
		
		$forums_tree = GetForumsInThisForumAsMass(0, $user_id);
		
		EchoForumsTreeInSelectTag_EchoOptions($user_id, $selected_id, 0, "");
		
		echo "</select>";
	}
	
	/* Выводит строчки таблицы, в которой настраиваются права групп к форумам. При этом учитываются права пользователя, который видит эту таблицу, поэтому некоторые действия будут для него недоступны. */
	function EchoGroupsPermissionsToForumsSettingsInTrTag($user_id, $forum_id, $action) {
		global $mysqli;	
		
		$user_max_group_rank = GetUserMaxGroupRank($user_id);
		
		$stmt = $mysqli->prepare("SELECT id, name, rank FROM groups WHERE id >= 1 ORDER BY rank;");
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$groups_ids = array();
		$groups_names = array();
		$groups_ranks = array();
		$groups_number = 0;
		while($row = $result_set->fetch_assoc())
		{		
			$groups_ids[$groups_number] = $row['id'];
			$groups_names[$groups_number] = $row['name'];
			CheckStringValue($groups_names[$groups_number]);
			$groups_ranks[$groups_number] = $row['rank'];
			$groups_number++;
		}	
			
		global $permissions_fields_names;
		global $permissions_descriptions;
		global $permissions_number;
		
		$groups_to_permissions = array();
		
		for($i = 0; $i < $permissions_number; $i += 3)
		{			
			echo "
						<tr>
							<td class=\"center\">
								<label>
									Группа
								</label>
							</td>
				";
			for($i3 = 0; $i3 < 3; $i3++)
			{
				$new_i = $i + $i3;
				
				if($new_i < $permissions_number){
					echo "
							<td class=\"center\">
								<label>
									".$permissions_descriptions[$new_i]."
								</label>
							</td>
					";
				}
			}
			echo "</tr>";
			
			for($i2 = 0; $i2 < $groups_number; $i2++)
			{		
				echo "	<tr>
							<td>
								<label>
									".$groups_names[$i2]."
								</label>
							</td>";
				for($i3 = 0; $i3 < 3; $i3++)
				{
					$new_i = $i + $i3;
					if($new_i < $permissions_number)
					{
						$cant_delete = 0;
						if(($forum_id === "0") && $action != 'create-forum' && ($permissions_fields_names[$new_i] === "can_delete_this_forum")){
							$cant_delete = 1;
						}
						
						$select_name = "forum_permission_".$permissions_fields_names[$new_i]."_for_group_with_id_".$groups_ids[$i2];
						
						if($groups_ids[$i2] == 1) // если группа - владельцы
						{
							$_POST[$select_name] = "1";
						}
								
						if($groups_ids[$i2] == 3 && $permissions_fields_names[$new_i] != 'can_see_this_forum') // для гостей всё запрещено
						{
							$cant_delete = 1;
						}
						
						echo "
								<td>
									<select name=\"".$select_name."\" "; if($user_max_group_rank >= $groups_ranks[$i2] || $cant_delete === 1){ echo "disabled"; } echo ">";
						if($forum_id === "0" && $action != 'create-forum')
						{
									echo "
										<option value=\"0\" "; if($_POST[$select_name] === null || $_POST[$select_name] === "0" || $cant_delete === 1) echo "selected"; echo ">
											Запретить
										</option>";
						}
						else
						{
									echo "
										<option value=\"2\" "; if(($_POST[$select_name] === null || $_POST[$select_name] === "2") && $cant_delete === 0) echo "selected"; echo ">
											Не установлено (наследовать)
										</option>
										<option value=\"0\" "; if($_POST[$select_name] === "0" || $cant_delete === 1) echo "selected"; echo ">
											Запретить
										</option>";
						}
										
										echo "<option value=\"1\" "; if($_POST[$select_name] === "1" && $cant_delete === 0) echo "selected"; echo ">
											Разрешить
										</option>
									</select>
								</td>
						";
					}
				}
				echo "</tr>";	
			}		
		}		
	}
	
	/* Выводит строчки таблицы, в которой настраиваются права групп. При этом учитываются права пользователя, который видит эту таблицу, поэтому некоторые действия будут для него недоступны. */
	function EchoGroupsPermissionsSettingsInTrTag($user_id) {
		global $mysqli;	
		
		$user_max_group_rank = GetUserMaxGroupRank($user_id);
		$user_permissions = GetUserPermissions($user_id);
		
		$stmt = $mysqli->prepare("SELECT id, name, rank FROM groups WHERE id >= 1 ORDER BY rank;");
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$groups_ids = array();
		$groups_names = array();
		$groups_ranks = array();
		$groups_number = 0;
		while($row = $result_set->fetch_assoc())
		{		
			$groups_ids[$groups_number] = $row['id'];
			$groups_names[$groups_number] = $row['name'];
			CheckStringValue($groups_names[$groups_number]);
			$groups_ranks[$groups_number] = $row['rank'];
			$groups_number++;
		}	
			
		global $permissions_fields_names2;
		global $permissions_descriptions2;
		global $permissions_number2;
		
		$groups_to_permissions = array();
		
		for($i = 0; $i < $permissions_number2; $i += 3)
		{			
			echo "
						<tr>
							<td class=\"center\">
								<label>
									Группа
								</label>
							</td>
				";
			for($i3 = 0; $i3 < 3; $i3++)
			{
				$new_i = $i + $i3;
				
				if($new_i < $permissions_number2){
					echo "
							<td class=\"center\">
								<label>
									".$permissions_descriptions2[$new_i]."
								</label>
							</td>
					";
				}
			}
			echo "</tr>";
			
			for($i2 = 0; $i2 < $groups_number; $i2++)
			{		
				echo "	<tr>
							<td>
								<label>
									".$groups_names[$i2]."
								</label>
							</td>";
				for($i3 = 0; $i3 < 3; $i3++)
				{
					$new_i = $i + $i3;
					if($new_i < $permissions_number2)
					{						
						$select_name = "group_permission_".$permissions_fields_names2[$new_i]."_for_group_with_id_".$groups_ids[$i2];
						
						$disabled = 0;
						if($groups_ids[$i2] == 1) // если группа - владельцы
						{
							//$_POST[$select_name] = "1";
							$disabled = 1;
						}
						else if(($groups_ids[$i2] == 2) || ($groups_ids[$i2] == 3)) // если группа - пользователи или гости
						{
							//$_POST[$select_name] = "0";
							$disabled = 1;
						}
						
						$user_permissions_to_group = GetUserPermissionsToGroup($user_id, $groups_ids[$i2]);
						if($user_permissions_to_group['can_edit'] == 0)
						{
							$disabled = 1;
						}
						
						echo "
								<td>
									<select name=\"".$select_name."\" "; if($disabled == 1){ echo "disabled"; } echo ">";
									echo "
										<option value=\"2\" "; if($_POST[$select_name] === null || $_POST[$select_name] === "2") echo "selected"; echo ">
											Не установлено (запретить)
										</option>
										<option value=\"0\" "; if($_POST[$select_name] === "0") echo "selected"; echo ">
											Запретить
										</option>
						";
						if(($user_permissions[$permissions_fields_names2[$new_i]] == 1) || $disabled == 1) // пользователь не может создать группу с правами, разрешающими то, чего он не может сейчас
						{
							echo "
											<option value=\"1\" "; if($_POST[$select_name] === "1") echo "selected"; echo ">
												Разрешить
											</option>
							";
						}
						echo "
									</select>
								</td>
						";
					}
				}
				echo "</tr>";	
			}		
		}		
	}
	
	/* Проверка на корректность значения опции для значений 0 и 1. */
	function CheckValue01AndSetToDefaultIfWrong(&$value) {
		if(($value !== "0") && ($value !== "1"))
		{
			$value = "0";
		}
	}
	
	/* Проверка на корректность значения опции для значений 0, 1 и 2. */
	function CheckValue012AndSetToDefaultIfWrong(&$value) {
		if(($value !== "0") && ($value !== "1") && ($value !== "2"))
		{
			$value = "2";
		}
	}
	
	/* Проверка на корректность значения опции для текстовых. */
	function CheckStringValue(&$value) {
		$value = htmlspecialchars($value); // Преобразует специальные символы в HTML-сущности
	}
	
	/* Возвращает количество комментариев в указанной теме. Права пользователя на просмотр не проверяются, так как до этого должны были проверяться права на форум, в котором лежит указанная тема. */
	function GetCommentariesCountInTopic($topic_id) {
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT COUNT(*) as count FROM commentaries WHERE topic_id = ?;");
		$stmt->bind_param("i", $topic_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		if($row = $result_set->fetch_assoc()) {
			return $row['count'];
		}
		else return 0;
	}
	
	/* Возвращает количество тем в указанном форуме для указанного пользователя (если пользователь не видит форум, то будет возвращено 0 комментариев). */
	function GetTopicsCountInForum($forum_id, $user_id) {
		global $mysqli;
		
		$user_permissions_to_forum = GetUserForumPermissions($user_id, $forum_id);
		if($user_permissions_to_forum['can_see_this_forum'] == 1) {
			$stmt = $mysqli->prepare("SELECT COUNT(*) as count FROM topics WHERE forum_id = ?;");
			$stmt->bind_param("i", $forum_id);
			$stmt->execute();
			$result_set = $stmt->get_result();
			
			$row = $result_set->fetch_assoc();
			if($row)
			{
				$count = $row['count'];
				$stmt = $mysqli->prepare("SELECT id FROM forums WHERE forum_id = ?;");
				$stmt->bind_param("i", $forum_id);
				$stmt->execute();
				$result_set = $stmt->get_result();
				while($row = $result_set->fetch_assoc())
				{
					$count += GetTopicsCountInForum($row['id'], $user_id);
				}
				return $count;
			}
			else return 0;
		}
		else return 0;
	}
	
	/* Возвращает количество комментариев в указанном форуме для указанного пользователя (так как некоторые форумы могут быть недоступны пользователю). */
	function GetCommentariesCountInForum($forum_id, $user_id) {
		global $mysqli;
		
		$count = 0;
		$stmt = $mysqli->prepare("SELECT id FROM forums WHERE forum_id = ?;");
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		while($row = $result_set->fetch_assoc())
		{
			$count += GetCommentariesCountInForum($row['id'], $user_id);
		}
		
		$stmt = $mysqli->prepare("SELECT id FROM topics WHERE forum_id = ?;");
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		while($row = $result_set->fetch_assoc())
		{
			$count += GetCommentariesCountInTopic($row['id']);
		}
		
		return $count;
	}
	
	/* Возвращает информацию о последнем комментарии в указанной теме в виде текста. Права пользователя на просмотр не проверяются, так как до этого должны были проверяться права на форум, в котором лежит указанная тема. */
	function GetInfoTextLastCommentaryInTopic($topic_id) {
		global $mysqli;
		
		$stmt = $mysqli->prepare("
			SELECT commentaries.user_from_id, commentaries.text, commentaries.creation_datetime_int, users.nick, topics.name
			FROM commentaries, users, topics
			WHERE (commentaries.topic_id = ?) AND (topics.id = ?) AND (commentaries.user_from_id = users.id) 
			ORDER BY commentaries.creation_datetime_int DESC
			LIMIT 1
		;");
		$stmt->bind_param("ii", $topic_id, $topic_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$row = $result_set->fetch_assoc();
		if($row)
		{
			$user_from_id = $row['user_from_id'];
			$user_from_nick = $row['nick'];
			CheckStringValue($user_from_nick);
			$topic_name = $row['name'];
			CheckStringValue($topic_name);
			$creation_datetime = gmdate("d.m.Y - H:i:s", $row['creation_datetime_int']);
			return "От <a href=\"/profile?id=".$user_from_id."\">".$user_from_nick."</a> в теме <a href=\"/topic?id=".$topic_id."&page=last#topic-bottom\">".$topic_name."</a><br/>[".$creation_datetime."]";
		}
		else return "-";
	}
	
	/* Возвращает ID последнего комментария в указанном форуме для указанного пользователя (так как некоторые форумы могут быть недоступны пользователю). */
	function GetLastCommentaryIdInForum($forum_id, $user_id) {
		global $mysqli;
		
		$user_permissions_to_forum = GetUserForumPermissions($user_id, $forum_id);
		if($user_permissions_to_forum['can_see_this_forum'] == 1) {
			$last_commentary_id_in_forum = -1;
			$last_creation_datetime_int = 0;
			
			$stmt = $mysqli->prepare("SELECT id FROM forums WHERE forum_id = ?;");
			$stmt->bind_param("i", $forum_id);
			$stmt->execute();
			$result_set = $stmt->get_result();
			while($row = $result_set->fetch_assoc())
			{
				$last_commentary_id_in_forum2 = GetLastCommentaryIdInForum($row['id'], $user_id);
				if($last_commentary_id_in_forum2 != -1)
				{
					$stmt2 = $mysqli->prepare("SELECT creation_datetime_int FROM commentaries WHERE id = ?;");
					$stmt2->bind_param("i", $last_commentary_id_in_forum2);
					$stmt2->execute();
					$result_set2 = $stmt2->get_result();
					if($row2 = $result_set2->fetch_assoc())
					{
						if($row2['creation_datetime_int'] > $last_creation_datetime_int) // если комментарий был позже сохранённого
						{
							$last_creation_datetime_int = $row2['creation_datetime_int'];
							$last_commentary_id_in_forum = $last_commentary_id_in_forum2;
						}
					}
				}
			}
			
			$stmt = $mysqli->prepare("SELECT id FROM topics WHERE forum_id = ?;");
			$stmt->bind_param("i", $forum_id);
			$stmt->execute();
			$result_set = $stmt->get_result();
			while($row = $result_set->fetch_assoc())
			{
				$stmt2 = $mysqli->prepare("SELECT id, creation_datetime_int FROM commentaries WHERE topic_id = ?;");
				$stmt2->bind_param("i", $row['id']);
				$stmt2->execute();
				$result_set2 = $stmt2->get_result();
				while($row2 = $result_set2->fetch_assoc())
				{
					if($row2['creation_datetime_int'] > $last_creation_datetime_int) // если комментарий был позже сохранённого
					{
						$last_creation_datetime_int = $row2['creation_datetime_int'];
						$last_commentary_id_in_forum = $row2['id'];
					}
				}
			}
			
			return $last_commentary_id_in_forum;
		}
		else return -1;
	}
	
	/* Возвращает ID темы с последним комментарии в указанном форуме для указанного пользователя (так как некоторые форумы могут быть недоступны пользователю). */
	function GetTopicIdWithLastCommentaryInForum($forum_id, $user_id) {
		global $mysqli;
		
		$last_commentary_id_in_forum = GetLastCommentaryIdInForum($forum_id, $user_id);
		
		$stmt = $mysqli->prepare("SELECT topic_id FROM commentaries WHERE id = ?;");
		$stmt->bind_param("i", $last_commentary_id_in_forum);
		$stmt->execute();
		$result_set = $stmt->get_result();
		if($row = $result_set->fetch_assoc())
		{
			return $row['topic_id'];
		}
		else return -1;
	}
	
	/* Возвращает информацию о последнем комментарии в указанной теме для указанного пользователя (так как некоторые форумы могут быть недоступны пользователю) в виде текста. */
	function GetInfoTextLastCommentaryInForum($forum_id, $user_id) {
		global $mysqli;
		
		$topic_id_with_last_commentary = GetTopicIdWithLastCommentaryInForum($forum_id, $user_id);
		
		if($topic_id_with_last_commentary == -1) // если не нашлось ни одного комментария
		{
			return "-";
		}
		else
		{
			return GetInfoTextLastCommentaryInTopic($topic_id_with_last_commentary);
		}
	}
	
?>