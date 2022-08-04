<?php
require "includes/mysql/mysql_connect.php";
require "includes/session/session_start.php";
CheckBanAndLogoutIfTrue();
CheckIsLoggedAndLogoutIfFalse();

// Устранение варнингов
$_POST['button_submit'] = $_POST['button_submit'] ?? null;
$_POST['group-name'] = $_POST['group-name'] ?? null;
$_POST['group-description'] = $_POST['group-description'] ?? null;
$_POST['group-rank'] = $_POST['group-rank'] ?? null;
$group_id = $group_id ?? null;
$errors_text = $errors_text ?? array();

$user_id = GetSessionId();

$title = "Управление группами";

$user_permissions = GetUserPermissions($user_id);
$can_create_groups = $user_permissions['can_create_groups'];

$errors_number = 0;

$action = $_GET['action'] ?? null;
if ($action === null) {
    $action = 'view';
} else if ($action == 'create') {
    if ($can_create_groups == 0) // если пользователь не может создавать группы
    {
        header("Location: /groups"); // перенаправляем на страницу групп
        exit;
    } else {
        $title = "Создание новой группы";
        if ($_POST['button_submit'] !== null) {
            if ($_POST['group-name'] === null) {
                $errors_text[$errors_number++] = "Введите название группы!";
            } else if (($_POST['group-rank'] === null) && $group_id != 1 && $group_id != 2 && $group_id != 3) {
                $errors_text[$errors_number++] = "Введите ранг группы!";
            } else if (($_POST['group-rank'] < 2 || $_POST['group-rank'] > 998) && $group_id != 1 && $group_id != 2 && $group_id != 3) {
                $errors_text[$errors_number++] = "Ранг группы должен быть в диапазоне от 2 до 998!";
            } else if ($_POST['group-rank'] < GetUserMaxGroupRank($user_id)) {
                $errors_text[$errors_number++] = "Вы не можете создать группу с рангом лучше, чем ваш текущий максимальный ранг!";
            } else {
                if ($group_id == 1) // владельцы
                {
                    $_POST['group-rank'] = 1;
                } else if ($group_id == 2) // пользователи
                {
                    $_POST['group-rank'] = 999;
                } else if ($group_id == 3) // гости
                {
                    $_POST['group-rank'] = 1000;
                }

                $stmt = $mysqli->prepare("SELECT id FROM `groups` WHERE (`rank` = ?);");
                $stmt->bind_param("i", $_POST['group-rank']);
                $stmt->execute();
                $result_set = $stmt->get_result();
                $row = $result_set->fetch_assoc();

                if ($row) // если существует группа с таким рангом
                {
                    $errors_text[$errors_number++] = "Группа с таким рангом уже существует!";
                } else {
                    $stmt = $mysqli->prepare("INSERT INTO `groups`(name, description, `rank`, user_from_id) VALUES(?, ?, ?, ?);");
                    $stmt->bind_param("ssii", $_POST['group-name'], $_POST['group-description'], $_POST['group-rank'], $user_id);

                    if ($stmt->execute()) // если группа успешно создана
                    {
                        header("Location: /groups"); // перенаправляем на страницу групп
                        exit;
                    } else {
                        $errors_text[$errors_number++] = "Возникла ошибка при создании группы!";
                    }
                }
            }
        }
    }
} else if ($action == 'edit' || $action == 'delete') {
    $group_id = $_GET['id'];

    if ($group_id == null || $group_id == -1) {
        header("Location: /groups"); // перенаправляем на страницу групп
        exit;
    } else {
        $stmt = $mysqli->prepare("SELECT name, description, `rank` FROM `groups` WHERE (id = ?);");
        $stmt->bind_param("i", $group_id);
        $stmt->execute();
        $result_set = $stmt->get_result();
        $row = $result_set->fetch_assoc();

        if (!($row)) // если группы не существует
        {
            header("Location: /groups"); // перенаправляем на страницу групп
            exit;
        } else {
            $group_name = $row["name"];

            CheckStringValue($row["name"]);

            $user_permissions_to_group = GetUserPermissionsToGroup($user_id, $group_id);

            if ($action == 'edit') {
                if ($user_permissions_to_group['can_edit'] == 0) // если пользователь не может изменять указанную группу
                {
                    header("Location: /groups"); // перенаправляем на страницу групп
                    exit;
                } else {
                    $title = "Изменение группы " . $group_name;
                    if ($_POST['button_submit'] !== null) {
                        if ($_POST['group-name'] === null) {
                            $errors_text[$errors_number++] = "Введите название группы!";
                        } else if (($_POST['group-rank'] === null) && $group_id != 1 && $group_id != 2 && $group_id != 3) {
                            $errors_text[$errors_number++] = "Введите ранг группы!";
                        } else if (($_POST['group-rank'] < 2 || $_POST['group-rank'] > 998) && $group_id != 1 && $group_id != 2 && $group_id != 3) {
                            $errors_text[$errors_number++] = "Ранг группы должен быть в диапазоне от 2 до 998!";
                        } else if ($_POST['group-rank'] < GetUserMaxGroupRank($user_id)) {
                            $errors_text[$errors_number++] = "Вы не можете присвоить группе ранг лучше, чем ваш текущий максимальный ранг!";
                        } else {
                            if ($group_id == 1) // владельцы
                            {
                                $_POST['group-rank'] = 1;
                            } else if ($group_id == 2) // пользователи
                            {
                                $_POST['group-rank'] = 999;
                            } else if ($group_id == 3) // гости
                            {
                                $_POST['group-rank'] = 1000;
                            }

                            $stmt = $mysqli->prepare("SELECT id FROM `groups` WHERE (`rank` = ?) AND (id != ?);");
                            $stmt->bind_param("ii", $_POST['group-rank'], $group_id);
                            $stmt->execute();
                            $result_set = $stmt->get_result();
                            $row = $result_set->fetch_assoc();

                            if ($row) // если существует группа с таким рангом
                            {
                                $errors_text[$errors_number++] = "Группа с таким рангом уже существует!";
                            } else {
                                $stmt = $mysqli->prepare("UPDATE `groups` SET name = ?, description = ?, `rank` = ? WHERE id = ?;");
                                $stmt->bind_param("ssii", $_POST['group-name'], $_POST['group-description'], $_POST['group-rank'], $group_id);

                                if ($stmt->execute()) // если группа успешно изменена
                                {
                                    header("Location: /groups"); // перенаправляем на страницу групп
                                    exit;
                                } else {
                                    $errors_text[$errors_number++] = "Возникла ошибка при изменении группы!";
                                }
                            }
                        }
                    } else // если кнопка не была нажата
                    {
                        $_POST['group-name'] = $row['name'];
                        $_POST['group-description'] = $row['description'];
                        $_POST['group-rank'] = $row['rank'];
                    }
                }
            } else if ($action == 'delete') {
                if ($user_permissions_to_group['can_delete'] == 0) // если пользователь не может удалять указанную группу
                {
                    header("Location: /groups"); // перенаправляем на страницу групп
                    exit;
                } else {
                    $title = "Удаление группы " . $group_name;
                    if ($_POST['button_submit'] !== null) {
                        $stmt = $mysqli->prepare("DELETE FROM `groups` WHERE (id = ?);");
                        $stmt->bind_param("i", $group_id);

                        if ($stmt->execute()) // если группа успешно удалена
                        {
                            header("Location: /groups"); // перенаправляем на страницу групп
                            exit;
                        } else {
                            $errors_text[$errors_number++] = "Возникла ошибка при удалении группы!";
                        }
                    }
                }
            }
        }
    }
} else if ($action == 'edit-permissions') {
    $title = "Изменение прав групп";

    $user_max_group_rank = GetUserMaxGroupRank($user_id);

    $user_permissions = GetUserPermissions($user_id);

    $stmt = $mysqli->prepare("SELECT id, `rank` FROM `groups` WHERE id >= 1 ORDER BY `rank`;");
    $stmt->execute();
    $result_set = $stmt->get_result();

    $groups_ids = array();
    $groups_ranks = array();
    $groups_number = 0;
    while ($row = $result_set->fetch_assoc()) {
        $groups_ids[$groups_number] = $row['id'];
        CheckStringValue($groups_names[$groups_number]);
        $groups_ranks[$groups_number] = $row['rank'];
        $groups_number++;
    }

    $loaded_permissions = array();

    for ($i2 = 0; $i2 < $groups_number; $i2++) {
        for ($i3 = 0; $i3 < 3; $i3++) {
            $new_i = $i2 + $i3;
            if ($new_i < $permissions_number2) {
                $group_id = $groups_ids[$i2];

                $stmt = $mysqli->prepare("SELECT * FROM `groups` WHERE (id = ?);");
                $stmt->bind_param("i", $group_id);
                $stmt->execute();
                $result_set = $stmt->get_result();

                $row = $result_set->fetch_assoc();

                if ($row) {
                    $select_values = array();
                    for ($permission_id = 0; $permission_id < $permissions_number2; $permission_id++) {
                        $name_of_select = "group_permission_" . $permissions_fields_names2[$permission_id] . "_for_group_with_id_" . $group_id;

                        if ($_POST['button_submit'] === null) {
                            $_POST[$name_of_select] = "" . $row[$permissions_fields_names2[$permission_id]];
                        }

                        $loaded_permissions[$name_of_select] = "" . $row[$permissions_fields_names2[$permission_id]];
                    }
                }
            }
        }
    }

    if ($_POST['button_submit'] !== null) {
        $was_error = 0;

        $stmt = $mysqli->prepare("SELECT id, `rank` FROM `groups` WHERE id >= 1 ORDER BY `rank`;");
        $stmt->execute();
        $result_set = $stmt->get_result();

        $groups_ids = array();
        $groups_ranks = array();
        $groups_number = 0;
        while ($row = $result_set->fetch_assoc()) {
            $groups_ids[$groups_number] = $row['id'];
            $groups_ranks[$groups_number] = $row['rank'];
            $groups_number++;
        }

        // находим максимальный ранг группы у пользователя
        $user_max_group_rank = GetUserMaxGroupRank($user_id);

        for ($group_local_id = 0; $group_local_id < $groups_number; $group_local_id++) // для каждой группы
        {
            $group_id = $groups_ids[$group_local_id];
            $group_rank = $groups_ranks[$group_local_id];

            $select_values = array();
            for ($permission_id = 0; $permission_id < $permissions_number2; $permission_id++) {
                $name_of_select = "group_permission_" . $permissions_fields_names2[$permission_id] . "_for_group_with_id_" . $group_id;

                $disabled = 0;
                if (($group_id == 1) || ($group_id == 2) || ($group_id == 3)) // если группа - владельцы, пользователи или гости - их права менять нельзя
                {
                    $disabled = 1;
                }
                $user_permissions_to_group = GetUserPermissionsToGroup($user_id, $group_id);
                if ($user_permissions_to_group['can_edit'] == 0) {
                    $disabled = 1;
                }

                // пользователь не может создать группу с правами, разрешающими то, чего он не может сейчас
                if (($user_permissions[$permissions_fields_names2[$permission_id]] == 0) && ($_POST[$name_of_select] == 1)) {
                    $disabled = 1;
                }

                if ($disabled == 1) {
                    $select_values[$permission_id] = "" . $loaded_permissions[$name_of_select];
                } else {
                    $select_values[$permission_id] = $_POST[$name_of_select];
                }

                if ($group_id == -1 || $group_id == 1) $select_values[$permission_id] = "1"; // для супервизоров разрешено всё
                if ($group_id == 2 || $group_id == 3) $select_values[$permission_id] = "0"; // для пользователей и гостей всё запрещено

                CheckValue012AndSetToDefaultIfWrong($select_values[$permission_id]); // проверка на правильность значения
            }

            // изменение прав к форуму в таблице groups_permissions_to_forums
            $stmt = $mysqli->prepare("
					UPDATE `groups` SET 
						can_warn_users_in_lower_groups = ?, 
						can_unwarn_warns_from_him = ?, 
						can_unwarn_warns_from_users_in_lower_groups = ?, 
						can_unwarn_warns_from_users_in_groups_with_same_rank = ?, 
						can_ban_users_in_lower_groups = ?, 
						can_unban_bans_from_him = ?, 
						can_unban_bans_from_users_in_lower_groups = ?, 
						can_unban_bans_from_users_in_groups_with_same_rank = ?, 
						can_create_groups = ?, 
						can_edit_groups_from_him = ?, 
						can_edit_groups_from_users_in_lower_groups = ?, 
						can_edit_groups_from_users_in_groups_with_same_rank = ?, 
						can_delete_groups_from_him = ?, 
						can_delete_groups_from_users_in_lower_groups = ?, 
						can_delete_groups_from_users_in_groups_with_same_rank = ?, 
						can_edit_users_in_lower_groups = ?, 
						can_change_users_in_lower_groups_attach_to_lower_groups = ?, 
						can_change_users_in_groups_with_same_rank_attach_to_lower_groups = ?
					WHERE (id = ?);
				");
            $stmt->bind_param("iiiiiiiiiiiiiiiiiii",
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
                $group_id
            );
            if ($stmt->execute() == 0) {
                $was_error = 1;
                break;
            }
        }
        if ($was_error == 0) // если были успешно выполнены все запросы
        {
            header("Location: /groups?action=edit-permissions"); // перенаправляем на форум
        } else {
            $errors_text[$errors_number++] = "Возникла ошибка при изменении прав для форума!<br/>" . $stmt->error;
        }
    }
}
include_once "includes/head.php";
?>
<?php
include_once "includes/header.php";
?>
<?php
$show_article_menu = 0;
if ($action == 'view') {
    $show_article_menu = 1;
}

if ($show_article_menu == 1) {
    echo "<div id=\"article_menu\">";
}

if ($action == 'view') {
    echo "<a class='article_menu_button_blue' href='/groups?action=edit-permissions'>Посмотреть / Изменить права групп</a> ";
    if ($can_create_groups == 1) {
        echo "<a class='article_menu_button_blue' href='/groups?action=create'>Создать новую группу</a> ";
    }
}

if ($show_article_menu == 1) {
    echo "</div>";
}

if ($action == 'create' || $action == 'edit' || $action == 'delete' || $action == 'edit-permissions') {
    if ($action == 'create') {
        $legend = "Создание группы";
        $submit_button_name = "Создать";
    } else if ($action == 'edit') {
        $legend = "Изменение группы";
        $submit_button_name = "Изменить";
    } else if ($action == 'delete') {
        $legend = "Удаление группы";
        $submit_button_name = "Удалить";
    } else if ($action == 'edit-permissions') {
        $legend = "Изменение прав групп";
        $submit_button_name = "Сохранить";
    }

    echo "
								<form action=\"/groups?action=$action&id=$group_id\" method=\"POST\" class=\"forum_form\">
									<fieldset>
										<legend><b>$legend</b></legend>
							";

    if ($action == 'delete') {
        $stmt = $mysqli->prepare("SELECT name FROM `groups` WHERE id = ?;");
        $stmt->bind_param("i", $group_id);
        $stmt->execute();
        $result_set = $stmt->get_result();
        $row = $result_set->fetch_assoc();
        if ($row) {
            echo "
										<table class=\"settings\">
											<tr>
												<td colspan=\"2\">
													<label>
															Вы действительно хотите удалить группу <b><i>$group_name</i></b>?<br/>Отменить это действие будет невозможно.
													</label>
												</td>
											</tr>
										</table>
									";
        }
    } else if ($action == 'create' || $action == 'edit') {
        echo "
										<table class=\"settings\">
											<tr>
												<td colspan=\"2\">
													<label>
															<b>Информация о группе</b>
													</label>
												</td>
											</tr>
											<tr>
												<td>
													<label for=\"group-name\">
															Название группы:
													</label>
												</td>
												<td>
													<input required type=\"text\" size=\"32\" maxlength=\"63\" name=\"group-name\" id=\"group-name\" value=\"" . $_POST['group-name'] . "\">
												</td>
											</tr>
											<tr>
												<td>
													<label for=\"group-description\">
															Описание группы:
													</label>
												</td>
												<td>
													<textarea rows=\"3\" cols=\"34\" maxlength=\"255\" name=\"group-description\" id=\"group-description\">" . $_POST['group-description'] . "</textarea>
												</td>
											</tr>
											<tr>
												<td>
													<label for=\"group-rank\">
															Ранг группы (2-998):
													</label>
												</td>
												<td>
													<input required type=\"text\" size=\"4\" maxlength=\"4\" name=\"group-rank\" id=\"group-rank\" value=\"" . $_POST['group-rank'] . "\" ";
        if ($group_id == 1 || $group_id == 2 || $group_id == 3) {
            echo " disabled";
        }
        echo ">
												</td>
											</tr>
										</table>
								";
    } else if ($action == 'edit-permissions') {
        echo "
									<table class=\"permissions\">
										<tr>
											<td colspan=\"4\">
												<label>
													<b>Права групп</b>
												</label>
											</td>
										</tr>
								";
        EchoGroupsPermissionsSettingsInTrTag($user_id);
        echo "
									</table>
								";
    }

    if (sizeof($errors_text) > 0) {
        echo "<div class=\"forum_form_errors\">";

        for ($i = 0; $i < $errors_number; $i++) {
            echo "<div class=\"error_text\">" . $errors_text[$i] . "</div>";
        }

        echo "</div>";
    }

    echo "
										<input type=\"submit\" value=\"$submit_button_name\" name=\"button_submit\">
										<a href=\"/groups\"><input type=\"button\" value=\"";
    if ($action == 'edit-permissions') {
        echo "Закрыть";
    } else {
        echo "Отмена";
    }
    echo "\" name=\"button_cancel\"></a>
									</fieldset>
								</form>
							";
}

echo "
							<table class=\"profile_extra_info\">
								<tr>
									<td class=\"profile_extra_info_head\" colspan=\"5\">
										<b>Группы</b>
									</td>
								</tr>
						";

$stmt = $mysqli->prepare("
							SELECT id, name, description, `rank` FROM `groups`
							WHERE id >= 0 
							ORDER BY `rank`;
						");
$stmt->execute();
$result_set = $stmt->get_result();
$row = $result_set->fetch_assoc();
if ($row) {
    echo "<tr>";
    echo "	<td class=\"groups_extra_info_head\">";
    echo "		<b>Ранг</b>";
    echo "	</td>";
    echo "	<td class=\"groups_extra_info_head\">";
    echo "		<b>Название</b>";
    echo "	</td>";
    echo "	<td class=\"groups_extra_info_head\">";
    echo "		<b>Описание</b>";
    echo "	</td>";
    echo "	<td class=\"groups_extra_info_head\" colspan=\"2\">";
    echo "		<b>Действия</b>";
    echo "	</td>";
    echo "</tr>";
    do {
        echo "<tr>";

        echo "	<td class=\"groups_extra_info_row_rank\">";
        echo $row['rank'];
        echo "	</td>";

        echo "	<td class=\"groups_extra_info_row_name\">";
        CheckStringValue($row['name']);
        echo $row['name'];
        echo "	</td>";

        $user_permissions_to_group = GetUserPermissionsToGroup($user_id, $row['id']);
        $can_edit_group = $user_permissions_to_group['can_edit'];
        $can_delete_group = $user_permissions_to_group['can_delete'];

        echo "	<td class=\"groups_extra_info_row_description\">";
        CheckStringValue($row['description']);
        if ($row['description'] == '') {
            $row['description'] = "Нет описания.";
        }
        echo $row['description'];
        echo "	</td>";

        echo "<td class=\"groups_extra_info_row_button\">";
        if ($can_edit_group) {
            echo "	<a href=\"/groups?action=edit&id=" . $row['id'] . "\" class=\"article_menu_button_blue\">Изменить</a>";
        } else echo "-";
        echo "</td>";

        echo "<td class=\"groups_extra_info_row_button\">";
        if ($can_delete_group) {
            echo "	<a href=\"/groups?action=delete&id=" . $row['id'] . "\" class=\"article_menu_button_blue\">Удалить</a>";
        } else echo "-";
        echo "</td>";

        echo "</tr>";
    } while ($row = $result_set->fetch_assoc());
} else {
    echo "<tr>";
    echo "	<td class=\"groups_extra_info_row\" colspan=\"5\">";
    echo "		Нет групп.";
    echo "	</td>";
    echo "</tr>";
}

echo "
							</table>
						";
?>
<?php
include_once "includes/footer.php";
require "includes/mysql/mysql_disconnect.php";
?>