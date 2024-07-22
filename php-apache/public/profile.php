<?php
require "includes/mysql/mysql_connect.php";
require "includes/session/session_start.php";
CheckBanAndLogoutIfTrue();

// Устранение варнингов
$errors_text = $errors_text ?? array();
$errors_number = $errors_number ?? 0;
$_POST['description'] = $_POST['description'] ?? null;
$_POST['button_unwarn'] = $_POST['button_unwarn'] ?? null;
$_POST['button_unban'] = $_POST['button_unban'] ?? null;
$_POST['unban_date'] = $_POST['unban_date'] ?? null;
$_POST['is_permanent'] = $_POST['is_permanent'] ?? null;

$is_created = array();

$user_id = GetSessionId();

$profile_id = $user_id;
if (($_GET['id'] ?? null) !== null) // если ID пользователя указан
{
    $profile_id = $_GET['id'];
} else // если ID пользователя не указан
{
    CheckIsLoggedAndLogoutIfFalse();
}

if ((!(IsUserExist($profile_id)) || ($profile_id < 1)) && ($user_id != -1)) // если пользователя не существует
{
    header('Location: /error_404'); // перенаправляем на страницу ошибки
    exit;
}

$stmt = $mysqli->prepare("SELECT * FROM users WHERE (id = ?);");
$stmt->bind_param("i", $profile_id);
$stmt->execute();
$result_set = $stmt->get_result();
$row = $result_set->fetch_assoc();

CheckStringValue($row["nick"]);

if ($user_id == $profile_id) {
    $title = "Личный кабинет";
} else {
    $title = "Профиль пользователя " . $row["nick"];
}

$action = $_GET['action'] ?? null;
if ($action === null) {
    $action = 'view';
} else if ($action == 'view-warns') {
    if ($user_id == $profile_id) {
        $title = "Мои предупреждения";
    } else {
        $title = "Предупреждения пользователя " . $row["nick"];
    }
} else if ($action == 'view-bans') {
    if ($user_id == $profile_id) {
        $title = "Мои баны";
    } else {
        $title = "Баны пользователя " . $row["nick"];
    }
} else if ($action == 'view-groups') {
    if ($user_id == $profile_id) {
        $title = "Мои группы";
    } else {
        $title = "Группы пользователя " . $row["nick"];
    }
} else if ($action == 'edit-profile') {
    if ($user_id == $profile_id) {
        $title = "Изменение моего профиля";
    } else {
        $title = "Изменение профиля пользователя " . $row["nick"];
    }
} else if ($action == 'warn') {
    $title = "Выдача предупреждения пользователю " . $row["nick"];
} else if ($action == 'ban') {
    $title = "Выдача бана пользователю " . $row["nick"];
} else if ($action == 'unwarn') {
    $title = "Снятие предупреждения пользователя " . $row["nick"];
} else if ($action == 'unban') {
    $title = "Снятие бана пользователя " . $row["nick"];
}
$profile_nick = $row["nick"];

$user_permissions_to_this_user = GetUserPermissionsToUser($user_id, $profile_id);

$errors_number = 0;

$getLocalTime = GetLocalTime(time());
if (($_POST['button_submit_edit'] ?? null) !== null) {
    if ($user_permissions_to_this_user['can_edit_user'] == 0) {
        header("Location: /profile?id=$profile_id"); // перенаправляем на профиль
        exit;
    } else {
        if ($_POST['nick'] === null) {
            $errors_text[$errors_number++] = "Введите ник!";
        } else if ($_POST['nick'] != 'Niko' && (!preg_match("/^[a-zA-Z\d_-]{5,32}$/", $_POST['nick'])) && ($_POST['nick'] !== null)) {
            $errors_text[$errors_number++] = "Введённый ник не подходит! Только латинские буквы, цифры и символы _ и -, длина ника: 5-32 символа.";
        } else {
            $stmt = $mysqli->prepare("
					UPDATE users SET nick = ?, avatar_link = ?, about = ? WHERE (id = ?);
				");
            $stmt->bind_param("sssi", $_POST['nick'], $_POST['avatar-link'], $_POST['profile-about'], $profile_id);
            if ($stmt->execute()) {
                header("Location: /profile?id=$profile_id"); // перенаправляем на профиль
            } else {
                $errors_text[$errors_number++] = "Указанный ник занят!";
            }
        }
    }
} else if (($_POST['button_submit_warn'] ?? null) !== null) {
    if ($user_permissions_to_this_user['can_warn_user'] == 0) {
        header("Location: /profile?id=$profile_id"); // перенаправляем на профиль
        exit;
    } else {
        if ($_POST['description'] === null) {
            $errors_text[$errors_number++] = "Введите причину!";
        } else {
            $stmt = $mysqli->prepare("
					INSERT INTO warns(user_from_id, user_to_id, description, warn_datetime_int) VALUES(?, ?, ?, ?);
				");
            $stmt->bind_param("iisi", $user_id, $profile_id, $_POST['description'], $getLocalTime);
            if ($stmt->execute()) {
                header("Location: /profile?id=$profile_id&action=view-warns"); // перенаправляем на профиль
            } else {
                $errors_text[$errors_number++] = "Возникла ошибка при выдаче предупреждения!";
            }
        }
    }
} else if (($_POST['button_submit_ban'] ?? null) !== null) {
    if ($user_permissions_to_this_user['can_ban_user'] == 0) {
        header("Location: /profile?id=$profile_id"); // перенаправляем на профиль
        exit;
    } else {
        if ($_POST['description'] === null) {
            $errors_text[$errors_number++] = "Введите причину!";
        } else {
            $stmt = $mysqli->prepare("
					INSERT INTO bans(user_from_id, user_to_id, description, ban_datetime_int, is_permanent, unban_datetime_int)
					VALUES(?, ?, ?, ?, ?, ?);
				");
            $unban_datetime_int = GetLocalTime(strtotime($_POST['unban_date']));
            $stmt->bind_param("iisiii", $user_id, $profile_id, $_POST['description'], $getLocalTime, $_POST['is_permanent'], $unban_datetime_int);
            if ($stmt->execute()) {
                header("Location: /profile?id=$profile_id&action=view-bans"); // перенаправляем на профиль
            } else {
                $errors_text[$errors_number++] = "Возникла ошибка при выдаче бана!";
            }
        }
    }
}

if ($action == 'unwarn') {
    $warn_id = $_GET['warn-id'];
    $stmt = $mysqli->prepare("SELECT * FROM warns WHERE id = ? AND user_to_id = ?;");
    $stmt->bind_param("ii", $warn_id, $profile_id);
    $stmt->execute();
    $result_set = $stmt->get_result();
    $row = $result_set->fetch_assoc();
    if (!($row)) {
        header("Location: /profile?id=$profile_id&action=view-warns"); // перенаправляем на профиль
        exit;
    } else {
        if (CanUserUnwarnWarn($user_id, $warn_id) == 0) {
            header("Location: /profile?id=$profile_id&action=view-warns"); // перенаправляем на профиль
            exit;
        } else {
            if ($_POST['button_unwarn'] !== null) {
                $stmt = $mysqli->prepare("DELETE FROM warns WHERE id = ?;");
                $stmt->bind_param("i", $warn_id);
                if ($stmt->execute()) {
                    header("Location: /profile?id=$profile_id&action=view-warns"); // перенаправляем на профиль
                } else {
                    $errors_text[$errors_number++] = "Возникла ошибка при снятии предупреждения!";
                }
            }
        }
    }
} else if ($action == 'unban') {
    $ban_id = $_GET['ban-id'];
    $stmt = $mysqli->prepare("SELECT * FROM bans WHERE id = ? AND user_to_id = ?;");
    $stmt->bind_param("ii", $ban_id, $profile_id);
    $stmt->execute();
    $result_set = $stmt->get_result();
    $row = $result_set->fetch_assoc();
    if (!($row)) {
        header("Location: /profile?id=$profile_id&action=view-bans"); // перенаправляем на профиль
        exit;
    } else {
        if (CanUserUnbanBan($user_id, $ban_id) == 0) {
            header("Location: /profile?id=$profile_id&action=view-bans"); // перенаправляем на профиль
            exit;
        } else {
            if ($_POST['button_unban'] !== null) {
                $stmt = $mysqli->prepare("DELETE FROM bans WHERE id = ?;");
                $stmt->bind_param("i", $ban_id);
                if ($stmt->execute()) {
                    header("Location: /profile?id=$profile_id&action=view-bans"); // перенаправляем на профиль
                } else {
                    $errors_text[$errors_number++] = "Возникла ошибка при снятии предупреждения!";
                }
            }
        }
    }
} else if ($action == 'change-groups') {
    if ($user_permissions_to_this_user['can_change_user_attach_to_lower_groups'] == 0) {
        header("Location: /profile?id=$profile_id&action=view-bans"); // перенаправляем на профиль
        exit;
    } else {
        if (($_POST['button_update_groups'] ?? null) !== null) {
            $was_error = 0;

            $stmt = $mysqli->prepare("SELECT id, name, `rank` FROM `groups` WHERE id >= 1 AND id != 3 ORDER BY `rank`;");
            $stmt->execute();
            $result_set = $stmt->get_result();
            while ($row = $result_set->fetch_assoc()) {
                $stmt2 = $mysqli->prepare("SELECT id FROM users_to_groups WHERE users_to_groups.user_id = ? AND users_to_groups.group_id = ?;");
                $stmt2->bind_param("ii", $profile_id, $row['id']);
                $stmt2->execute();
                $result_set2 = $stmt2->get_result();
                $is_attached = 0;
                if ($row2 = $result_set2->fetch_assoc()) {
                    $is_attached = 1;
                }

                // пользователь может изменить принадлежность только к группам ниже его по рангу
                $is_disabled = 0;
                $user_max_group_rank = GetUserMaxGroupRank($user_id);
                if ($user_max_group_rank >= $row['rank']) {
                    $is_disabled = 1;
                }

                if ($row['id'] == 2) {
                    $is_disabled = 1;
                }

                if (!($is_disabled)) {
                    $name = "is_attached_to_group_" . $row['id'];
                    $checked = $_POST[$name];
                    if ($checked == 'on') {
                        $new_is_attached = 1;
                    } else {
                        $new_is_attached = 0;
                    }
                    if ($new_is_attached != $is_attached) {
                        if ($new_is_attached == 0) {
                            $stmt2 = $mysqli->prepare("DELETE FROM users_to_groups WHERE user_id = ? AND group_id = ?;");
                            $stmt2->bind_param("ii", $profile_id, $row['id']);
                            $result_set2 = $stmt2->get_result();
                            if ($stmt2->execute()) {
                                $is_attached = 1;
                            } else {
                                $was_error = 1;
                                break;
                            }
                        } else if ($new_is_attached == 1) {
                            $stmt2 = $mysqli->prepare("INSERT INTO users_to_groups(user_id, group_id) VALUES(?, ?);");
                            $stmt2->bind_param("ii", $profile_id, $row['id']);
                            $result_set2 = $stmt2->get_result();
                            if ($stmt2->execute()) {
                                $is_attached = 1;
                            } else {
                                $was_error = 1;
                                break;
                            }
                        }
                    }
                }

            }

            if ($was_error == 0) // если были успешно выполнены все запросы
            {
                header("Location: /profile?id=" . $profile_id . "&action=view-groups"); // перенаправляем на форум
            } else {
                $errors_text[$errors_number++] = "Возникла ошибка при изменении групп пользователя!<br/>";
            }
        }
    }
}

include_once "includes/head.php";
?>
<?php
$menu_button = 3;
include_once "includes/header.php";
?>
<?php
CheckStringValue($profile_nick);

$about = $row["about"] ?? null;
CheckStringValue($about);

$avatar_link = $row["avatar_link"] ?? null;
if ($avatar_link == null) {
    $avatar_link = "/img/profile_no_avatar.png";
}
CheckStringValue($avatar_link);

$user_permissions_to_this_user = GetUserPermissionsToUser($user_id, $profile_id);

$can_edit_this_user = $user_permissions_to_this_user['can_edit_user'];
$can_warn_this_user = $user_permissions_to_this_user['can_warn_user'];
$can_ban_this_user = $user_permissions_to_this_user['can_ban_user'];
$can_change_this_user_attach_to_lower_groups = $user_permissions_to_this_user['can_change_user_attach_to_lower_groups'];

$show_article_menu = 0;
if ($action == 'view-warns' || $action == 'view-bans' || $action == 'view-groups' || (($action == 'view') && ($can_edit_this_user || $can_warn_this_user || $can_ban_this_user))
    ||
    ($action == 'view-warns' || $action == 'view-bans' || $action == 'view-groups' || $action == 'change-groups')
    ||
    ($action == 'view' && $user_id == $profile_id)) {
    $show_article_menu = 1;
}

if ($show_article_menu == 1) {
    echo "<div id=\"article_menu\">";
}

if ($action == 'view') {
    if ($can_edit_this_user == 1) {
        echo "<a class='article_menu_button_blue' href='/profile?id=" . $profile_id . "&action=edit-profile'>Редактировать профиль</a> ";
    }
    if ($can_warn_this_user == 1) {
        echo "<a class='article_menu_button_blue' href='/profile?id=" . $profile_id . "&action=warn'>Выдать предупреждение</a> ";
    }
    if ($can_ban_this_user == 1) {
        echo "<a class='article_menu_button_blue' href='/profile?id=" . $profile_id . "&action=ban'>Выдать бан</a> ";
    }

    if ($profile_id == $user_id) {
        echo "<a class='article_menu_button_blue' href='/logout'>Выйти</a> ";
    }
} else if ($action == 'view-warns') {
    if ($can_warn_this_user == 1) {
        echo "<a class='article_menu_button_blue' href='/profile?id=" . $profile_id . "&action=warn'>Выдать предупреждение</a> ";
    }
} else if ($action == 'view-bans') {
    if ($can_ban_this_user == 1) {
        echo "<a class='article_menu_button_blue' href='/profile?id=" . $profile_id . "&action=ban'>Выдать бан</a> ";
    }
} else if ($action == 'view-groups') {
    if ($can_change_this_user_attach_to_lower_groups == 1) {
        echo "<a class='article_menu_button_blue' href='/profile?id=" . $profile_id . "&action=change-groups'>Изменить группы пользователя</a> ";
    }
    if (HasUserAccessToSpecialPanel($user_id)) {
        echo "<a class='article_menu_button_blue' href='/groups'>Управление группами</a> ";
    }
}

if ($action == 'view-warns' || $action == 'view-bans' || $action == 'view-groups' || $action == 'change-groups') {
    echo "<a class='article_menu_button_blue' href='/profile?id=" . $profile_id . "'>Вернуться к профилю</a> ";
}

if ($show_article_menu == 1) {
    echo "</div>";
}

if ($action == 'view' || $action == 'edit-profile') {
    if ($action == 'edit-profile') {
        if (($_POST['nick'] ?? null) === null) {
            $_POST['nick'] = $profile_nick;
        }
        if (($_POST['profile-about'] ?? null) === null) {
            $_POST['profile-about'] = $about;
        }
        if (($_POST['avatar-link'] ?? null) === null) {
            if ($avatar_link != "/img/profile_no_avatar.png") {
                $_POST['avatar-link'] = $avatar_link;
            }
        }
        echo "
										<form method=\"POST\" class=\"forum_form\">
											<fieldset>
												<legend><b>Редактирование профиля</b></legend>
													<table class=\"settings\">
														<tr>
															<td colspan=\"2\">
																<label>
																		<b>Данные</b>
																</label>
															</td>
														</tr>
														<tr>
															<td>
																<label for=\"nick\">
																		Ник:
																</label>
															</td>
															<td>
																<input required type=\"text\" maxlength=\"63\" name=\"nick\" id=\"nick\" value=\"" . $_POST['nick'] . "\">
															</td>
														</tr>
														<tr>
															<td>
																<label for=\"avatar-link\">
																		Ссылка на аватарку:
																</label>
															</td>
															<td>
																<input type=\"text\" maxlength=\"1023\" name=\"avatar-link\" id=\"avatar-link\" value=\"" . ($_POST['avatar-link'] ?? "") . "\">
															</td>
														</tr>
														<tr>
															<td>
																<label for=\"profile-about\">
																		О себе:
																</label>
															</td>
															<td>
																<textarea rows=\"3\" cols=\"34\" maxlength=\"511\" name=\"profile-about\" id=\"profile-about\">" . $_POST['profile-about'] . "</textarea>
															</td>
														</tr>
													</table>
								";


        if (sizeof($errors_text ?? array()) > 0) {
            echo "<div class=\"forum_form_errors\">";

            for ($i = 0; $i < $errors_number; $i++) {
                echo "<div class=\"error_text\">" . $errors_text[$i] . "</div>";
            }

            echo "</div>";
        }

        echo "
												<input type=\"submit\" value=\"Подтвердить изменения\" name=\"button_submit_edit\">
												<a href=\"/profile?id=" . $profile_id . "\"><input type=\"button\" value=\"Отмена\" name=\"button_cancel\"></a>
											</fieldset>
										</form>
									";
    }
    echo "
									<div id=\"stats\">
										<div id=\"forum_profile\">
											<div id=\"first_stats\">
												<div id=\"visitka\">
													<div id=\"profile_name\">
								";
    echo $profile_nick;
    echo "
													</div>
													<div id=\"status\">
								";
    if (IsBanned($profile_id)) {
        echo "<div class='status_banned'>Забанен</div>";
    } else {
        $last_active_datetime_int = $row["last_active_datetime_int"];
        if (($getLocalTime - $last_active_datetime_int) / 60 >= 5) {
            echo "<div class='status_offline'>Оффлайн</div>";
        } else {
            echo "<div class='status_online'>Онлайн</div>";
        }
    }
    $avatar_link = $avatar_link ?? "";
    echo "
													</div>
													<!--suppress CssUnknownTarget -->
													<div id=\"avatar\" style=\"background-image: url(" . $avatar_link . ");\">
													</div>
													<div id=\"rank\">
								";
    $role = $row["role"];
    if ($role == null) {
        $role = "Пользователь";
    }
    $role = htmlspecialchars($role); // Преобразует специальные символы в HTML-сущности
    echo $role;
    echo "
													</div>
												</div>
												<div id=\"rightside\">
													<div id=\"reg_date\">
														<b>Дата регистрации:</b>
								";
    $registration_datetime_int = $row["registration_datetime_int"];
    echo gmdate("d.m.Y - H:i:s", $registration_datetime_int);
    echo "
													</div>
													<div id=\"last_active_date\">
														<b>Последний раз в сети:</b>
								";
    $registration_datetime_int = $row["last_active_datetime_int"];
    echo gmdate("d.m.Y - H:i:s", $registration_datetime_int);
    echo "
													</div>
													<div id=\"groups\">
														<b>Группы:</b>
								";
    $stmt = $mysqli->prepare("SELECT COUNT(id) as count FROM users_to_groups WHERE user_id = ?;");
    $stmt->bind_param("i", $profile_id);
    $stmt->execute();
    $result_set = $stmt->get_result();

    $groups_number = 0;
    if ($row = $result_set->fetch_assoc()) {
        $groups_number = $row['count'];
    }

    echo "<a href=\"/profile?id=" . $profile_id . "&action=view-groups\">" . $groups_number . "</a>";
    echo "
													</div>
													<div id=\"about\">
														<div id=\"about_head\">
															<b>О себе:</b>
														</div>
														<div id=\"about_body\">
								";
    if (empty($about)) {
        echo 'Информация не указана.';
    } else {
        echo $about;
    }
    echo "
														</div>
													</div>
												</div>
											</div>
											<div class=\"clear\"></div>
											<div class=\"forum_statistics\">
												<div class=\"forum_statistics_head\">
													<b>Форумная активность</b>
												</div>
												<div class=\"forum_statistics_body\">
													<div class=\"forum_statistics_block\">
														<div class=\"forum_statistics_block_head\">
															<div class=\"forum_statistics_block_head_text\">
																Темы<br/>
															</div>
														</div>
														<div class=\"forum_statistics_block_body\">
								";
    $stmt = $mysqli->prepare("SELECT COUNT(id) as count FROM topics WHERE user_from_id = ?;");
    $stmt->bind_param("i", $profile_id);
    $stmt->execute();
    $result_set = $stmt->get_result();

    if ($row = $result_set->fetch_assoc()) {
        echo $row['count'];
    } else echo 0;
    echo "
														</div>
													</div>
													<div class=\"forum_statistics_block\">
														<div class=\"forum_statistics_block_head\">
															<div class=\"forum_statistics_block_head_text\">
																Комментарии<br/>
															</div>
														</div>
														<div class=\"forum_statistics_block_body\">
								";
    $stmt = $mysqli->prepare("SELECT COUNT(id) as count FROM commentaries WHERE user_from_id = ?;");
    $stmt->bind_param("i", $profile_id);
    $stmt->execute();
    $result_set = $stmt->get_result();

    if ($row = $result_set->fetch_assoc()) {
        echo $row['count'];
    } else echo 0;
    echo "
														</div>
													</div>
													<div class=\"clear\"></div>
												</div>
											</div>
											<div class=\"clear\"></div>
											<div class=\"forum_statistics\">
												<div class=\"forum_statistics_head\">
													<b>Нарушения</b>
												</div>
												<div class=\"forum_statistics_body\">
													<div class=\"forum_statistics_block\">
														<div class=\"forum_statistics_block_head\">
															<div class=\"forum_statistics_block_head_text\">
																Предупреждения
															</div>
														</div>
														<div class=\"forum_statistics_block_body\">
															<a href=\"/profile?id=" . $profile_id . "&action=view-warns\">
								";
    $stmt = $mysqli->prepare("SELECT COUNT(id) as count FROM warns WHERE user_to_id = ?;");
    $stmt->bind_param("i", $profile_id);
    $stmt->execute();
    $result_set = $stmt->get_result();

    if ($row = $result_set->fetch_assoc()) {
        echo $row['count'];
    } else echo 0;
    echo "
															</a>
														</div>
													</div>
													<div class=\"forum_statistics_block\">
														<div class=\"forum_statistics_block_head\">
															<div class=\"forum_statistics_block_head_text\">
																Баны
															</div>
														</div>
														<div class=\"forum_statistics_block_body\">
															<a href=\"/profile?id=" . $profile_id . "&action=view-bans\">
								";
    $stmt = $mysqli->prepare("SELECT COUNT(id) as count FROM bans WHERE user_to_id = ?;");
    $stmt->bind_param("i", $profile_id);
    $stmt->execute();
    $result_set = $stmt->get_result();

    if ($row = $result_set->fetch_assoc()) {
        echo $row['count'];
    } else echo 0;
    echo "
															</a>
														</div>
													</div>
													<div class=\"clear\"></div>
												</div>
											</div>
											<div class=\"clear\"></div>
										</div>
									</div>
								";
} else if ($action == 'view-warns' || $action == 'warn' || $action == 'unwarn') {
    if ($action == 'warn') {
        echo "
										<form method=\"POST\" class=\"forum_form\">
											<fieldset>
												<legend><b>Выдать предупреждение</b></legend>
													<table class=\"settings\">
														<tr>
															<td colspan=\"2\">
																<label>
																		<b>Информация</b>
																</label>
															</td>
														</tr>
														<tr>
															<td>
																<label for=\"description\">
																		Причина:
																</label>
															</td>
															<td>
																<textarea required rows=\"3\" cols=\"34\" maxlength=\"511\" name=\"description\" id=\"description\">" . $_POST['description'] . "</textarea>
															</td>
														</tr>
													</table>
									";


        if (sizeof($errors_text) > 0) {
            echo "<div class=\"forum_form_errors\">";

            for ($i = 0; $i < $errors_number; $i++) {
                echo "<div class=\"error_text\">" . $errors_text[$i] . "</div>";
            }

            echo "</div>";
        }

        echo "
												<input type=\"submit\" value=\"Выдать предупреждение\" name=\"button_submit_warn\">
												<a href=\"/profile?id=" . $profile_id . "&action=view-warns\"><input type=\"button\" value=\"Отмена\" name=\"button_cancel\"></a>
											</fieldset>
										</form>
									";
    } else if ($action == 'unwarn') {
        echo "
										<form method=\"POST\" class=\"forum_form\">
											<fieldset>
												<legend><b>Снять предупреждение</b></legend>
												<table class=\"settings\">
													<tr>
														<td colspan=\"2\">
															<label>
																	<b>Информация о предупреждении:</b>
															</label>
														</td>
													</tr>
													<tr>
														<td colspan=\"2\">
															<label>
									";
        echo GetWarnString($row);
        echo "
															</label>
														</td>
													</tr>
													<tr>
														<td colspan=\"2\">
															<label>
																	Вы действительно хотите снять предупреждение?<br/>
																	Отменить это действие будет невозможно.
															</label>
														</td>
													</tr>
												</table>
									";


        if (sizeof($errors_text) > 0) {
            echo "<div class=\"forum_form_errors\">";

            for ($i = 0; $i < $errors_number; $i++) {
                echo "<div class=\"error_text\">" . $errors_text[$i] . "</div>";
            }

            echo "</div>";
        }

        echo "
												<input type=\"submit\" value=\"Снять предупреждение\" name=\"button_unwarn\">
												<a href=\"/profile?id=" . $profile_id . "&action=view-warns\"><input type=\"button\" value=\"Отмена\" name=\"button_cancel\"></a>
											</fieldset>
										</form>
									";
    }

    echo "
									<table class=\"profile_extra_info\">
										<tr>
											<td class=\"profile_extra_info_head\" colspan=\"4\">
												<b>Предупреждения пользователя <a href='/profile?id=" . $profile_id . "'>" . $profile_nick . "</a></b>
											</td>
										</tr>
								";

    $stmt = $mysqli->prepare("SELECT * FROM warns WHERE user_to_id = ?;");
    $stmt->bind_param("i", $profile_id);
    $stmt->execute();
    $result_set = $stmt->get_result();
    $row = $result_set->fetch_assoc();
    if ($row) {
        echo "
										<tr>
											<td class=\"profile_extra_info_head\">
												<b>Кем выдано</b>
											</td>
											<td class=\"profile_extra_info_head\">
												<b>Дата выдачи</b>
											</td>
											<td class=\"profile_extra_info_head\" colspan=\"2\">
												<b>Причина</b>
											</td>
										</tr>
									";
        do {
            echo "<tr>";

            $result = "";

            $user_from_id = $row['user_from_id'];

            $stmt2 = $mysqli->prepare("SELECT * FROM users WHERE id = ?;");
            $stmt2->bind_param("i", $user_from_id);
            $stmt2->execute();
            $result_set2 = $stmt2->get_result();

            $row2 = $result_set2->fetch_assoc();

            $user_from_name = $row2['nick'];
            CheckStringValue($user_from_name);
            $user_from_id = $row2['id'];

            $warn_datetime_int = $row['warn_datetime_int'];
            $warn_datetime = gmdate("d.m.Y - H:i:s", $warn_datetime_int);

            $description = $row['description'];
            CheckStringValue($description);
            $can_unwarn_this_warn = CanUserUnwarnWarn($user_id, $row['id']);

            $result .= "<td class=\"profile_extra_info_row_from\">";
            $result .= "<a href=\"/profile?id=$user_from_id\">" . $user_from_name . "</a>";
            $result .= "</td>";
            $result .= "<td class=\"profile_extra_info_row_date\">";
            $result .= $warn_datetime;
            $result .= "</td>";
            $result .= "<td class=\"profile_extra_info_row_description\"";
            if ($can_unwarn_this_warn == 0) {
                $result .= " colspan=\"2\"";
            }
            $result .= ">";
            $result .= $description;
            $result .= "</td>";
            if ($can_unwarn_this_warn) {
                $result .= "<td class=\"profile_extra_info_row\">";
                $result .= "	<a href=\"/profile?id=" . $row['user_to_id'] . "&action=unwarn&warn-id=" . $row['id'] . "\" class=\"article_menu_button_blue\">Снять</a>";
                $result .= "</td>";
            }

            echo $result;

            echo "</tr>";
        } while ($row = $result_set->fetch_assoc());
    } else {
        echo "<tr>";
        echo "	<td class=\"profile_extra_info_row\" colspan=\"4\">";
        echo "		Пользователь не получал предупреждений.";
        echo "	</td>";
        echo "</tr>";
    }

    echo "
									</table>
								";
} else if ($action == 'view-bans' || $action == 'ban' || $action == 'unban') {
    if ($action == 'ban') {
        echo "
										<form method=\"POST\" class=\"forum_form\">
											<fieldset>
												<legend><b>Выдать бан</b></legend>
													<table class=\"settings\">
														<tr>
															<td colspan=\"2\">
																<label>
																		<b>Информация</b>
																</label>
															</td>
														</tr>
														<tr>
															<td>
																<label for=\"description\">
																		Причина:
																</label>
															</td>
															<td>
																<textarea required rows=\"3\" cols=\"34\" maxlength=\"511\" name=\"description\" id=\"description\">" . $_POST['description'] . "</textarea>
															</td>
														</tr>
														<tr>
															<td>
																<label for=\"is_permanent\">
																		Бан навсегда:
																</label>
															</td>
															<td>
																<select id=\"is_permanent\" name=\"is_permanent\">
																	<option value=\"1\" ";
        if ($_POST['is_permanent'] === "1") echo "selected";
        echo ">
																		Да
																	</option>
																	<option value=\"0\" ";
        if ($_POST['is_permanent'] === null || $_POST['is_permanent'] === "0") echo "selected";
        echo ">
																		Нет
																	</option>
																</select>
															</td>
														</tr>
														<tr>
															<td>
																<label for=\"unban_date\">
																		Дата разбана (если бан не навсегда):
																</label>
															</td>
															<td>
																<input type=\"date\" name=\"unban_date\" id=\"unban_date\" value=\"" . $_POST['unban_date'] . "\">
															</td>
														</tr>
													</table>
									";


        if (sizeof($errors_text) > 0) {
            echo "<div class=\"forum_form_errors\">";

            for ($i = 0; $i < $errors_number; $i++) {
                echo "<div class=\"error_text\">" . $errors_text[$i] . "</div>";
            }

            echo "</div>";
        }

        echo "
												<input type=\"submit\" value=\"Выдать бан\" name=\"button_submit_ban\">
												<a href=\"/profile?id=" . $profile_id . "&action=view-bans\"><input type=\"button\" value=\"Отмена\" name=\"button_cancel\"></a>
											</fieldset>
										</form>
									";
    } else if ($action == 'unban') {
        echo "
										<form method=\"POST\" class=\"forum_form\">
											<fieldset>
												<legend><b>Снять бан</b></legend>
												<table class=\"settings\">
													<tr>
														<td colspan=\"2\">
															<label>
																	<b>Информация о бане:</b>
															</label>
														</td>
													</tr>
													<tr>
														<td colspan=\"2\">
															<label>
									";
        echo GetBanString($row);
        echo "
															</label>
														</td>
													</tr>
													<tr>
														<td colspan=\"2\">
															<label>
																	Вы действительно хотите снять бан?<br/>
																	Отменить это действие будет невозможно.
															</label>
														</td>
													</tr>
												</table>
									";


        if (sizeof($errors_text) > 0) {
            echo "<div class=\"forum_form_errors\">";

            for ($i = 0; $i < $errors_number; $i++) {
                echo "<div class=\"error_text\">" . $errors_text[$i] . "</div>";
            }

            echo "</div>";
        }

        echo "
												<input type=\"submit\" value=\"Снять бан\" name=\"button_unban\">
												<a href=\"/profile?id=" . $profile_id . "&action=view-bans\"><input type=\"button\" value=\"Отмена\" name=\"button_cancel\"></a>
											</fieldset>
										</form>
									";
    }
    echo "
									<table class=\"profile_extra_info\">
										<tr>
											<td class=\"profile_extra_info_head\" colspan=\"5\">
												<b>Баны пользователя <a href='/profile?id=" . $profile_id . "'>" . $profile_nick . "</a></b>
											</td>
										</tr>
								";

    $stmt = $mysqli->prepare("SELECT * FROM bans WHERE user_to_id = ?;");
    $stmt->bind_param("i", $profile_id);
    $stmt->execute();
    $result_set = $stmt->get_result();
    $row = $result_set->fetch_assoc();
    if ($row) {
        echo "
										<tr>
											<td class=\"profile_extra_info_head\">
												<b>Кем выдан</b>
											</td>
											<td class=\"profile_extra_info_head\">
												<b>Дата выдачи</b>
											</td>
											<td class=\"profile_extra_info_head\">
												<b>Дата разбана</b>
											</td>
											<td class=\"profile_extra_info_head\" colspan=\"2\">
												<b>Причина</b>
											</td>
										</tr>
									";
        do {
            echo "<tr>";

            $result = "";

            $user_from_id = $row['user_from_id'];

            $stmt2 = $mysqli->prepare("SELECT * FROM users WHERE id = ?;");
            $stmt2->bind_param("i", $user_from_id);
            $stmt2->execute();
            $result_set2 = $stmt2->get_result();

            $row2 = $result_set2->fetch_assoc();

            $user_from_name = $row2['nick'];
            CheckStringValue($user_from_name);
            $user_from_id = $row2['id'];

            $ban_datetime_int = $row['ban_datetime_int'];
            $ban_datetime = gmdate("d.m.Y - H:i:s", $ban_datetime_int);
            $description = $row['description'];
            CheckStringValue($description);
            $can_unban_this_ban = CanUserUnbanBan($user_id, $row['id']);
            $result .= "<td class=\"profile_extra_info_row_from\">";
            $result .= "<a href=\"/profile?id=$user_from_id\">" . $user_from_name . "</a>";
            $result .= "</td>";
            $result .= "<td class=\"profile_extra_info_row_date\">";
            $result .= $ban_datetime;
            $result .= "</td>";
            $result .= "<td class=\"profile_extra_info_row_date\">";
            if ($row['is_permanent']) // если бан навсегда
            {
                $result .= "Бан навсегда";
            } else // если бан не навсегда
            {
                $unban_datetime_int = $row['unban_datetime_int'];
                $unban_datetime = gmdate("d.m.Y - H:i:s", $unban_datetime_int);
                $result .= $unban_datetime;
            }
            $result .= "</td>";
            $result .= "<td class=\"profile_extra_info_row_description\"";
            if ($can_unban_this_ban == 0) {
                $result .= " colspan=\"2\"";
            }
            $result .= ">";
            $result .= $description;
            $result .= "</td>";
            if ($can_unban_this_ban) {
                $result .= "<td class=\"profile_extra_info_row\">";
                $result .= "	<a href=\"/profile?id=" . $row['user_to_id'] . "&action=unban&ban-id=" . $row['id'] . "\" class=\"article_menu_button_blue\">Снять</a>";
                $result .= "</td>";
            }

            echo $result;

            echo "</tr>";
        } while ($row = $result_set->fetch_assoc());
    } else {
        echo "<tr>";
        echo "	<td class=\"profile_extra_info_row\" colspan=\"5\">";
        echo "		Пользователь не получал банов.";
        echo "	</td>";
        echo "</tr>";
    }

    echo "
									</table>
								";
} else if ($action == 'view-groups' || $action == 'change-groups') {
    if ($action == 'change-groups') {
        echo "
										<form method=\"POST\" class=\"forum_form\">
											<fieldset>
												<legend><b>Изменить группы пользователя</b></legend>
												<table class=\"settings\">
													<tr>
														<td colspan=\"2\">
															<label>
																	<b>Принадлежность к группам</b>
															</label>
														</td>
													</tr>
									";

        $stmt = $mysqli->prepare("SELECT id, name, `rank` FROM `groups` WHERE id >= 1 AND id != 3 ORDER BY `rank`;");
        $stmt->execute();
        $result_set = $stmt->get_result();
        while ($row = $result_set->fetch_assoc()) {
            $stmt2 = $mysqli->prepare("SELECT id FROM users_to_groups WHERE users_to_groups.user_id = ? AND users_to_groups.group_id = ?;");
            $stmt2->bind_param("ii", $profile_id, $row['id']);
            $stmt2->execute();
            $result_set2 = $stmt2->get_result();
            $is_attached = 0;
            if ($row2 = $result_set2->fetch_assoc()) {
                $is_attached = 1;
            }

            // пользователь может изменить принадлежность только к группам ниже его по рангу
            $is_disabled = 0;
            $user_max_group_rank = GetUserMaxGroupRank($user_id);
            if ($user_max_group_rank >= $row['rank']) {
                $is_disabled = 1;
            }

            if ($row['id'] == 2) {
                $is_disabled = 1;
            }

            $name = "is_attached_to_group_" . $row['id'];

            echo "
													<tr>
														<td>
															<label for=\"$name\">
																	" . $row['name'] . "
															</label>
														</td>
														<td>
															<input type=\"checkbox\" name=\"$name\" id=\"$name\"";
            if ($is_attached) {
                echo " checked";
            }
            if ($is_disabled) {
                echo " disabled";
            }
            echo ">
														</td>
													</tr>
										";
        }
        echo "
												</table>
									";


        if (sizeof($errors_text ?? array()) > 0) {
            echo "<div class=\"forum_form_errors\">";

            for ($i = 0; $i < $errors_number; $i++) {
                echo "<div class=\"error_text\">" . $errors_text[$i] . "</div>";
            }

            echo "</div>";
        }

        echo "
												<input type=\"submit\" value=\"Подтвердить изменения\" name=\"button_update_groups\">
												<a href=\"/profile?id=" . $profile_id . "&action=view-groups\"><input type=\"button\" value=\"Отмена\" name=\"button_cancel\"></a>
											</fieldset>
										</form>
									";
    }
    echo "
									<table class=\"profile_extra_info\">
										<tr>
											<td class=\"profile_extra_info_head\">
												<b>Группы пользователя <a href='/profile?id=" . $profile_id . "'>" . $profile_nick . "</a></b>
											</td>
										</tr>
								";

    $stmt = $mysqli->prepare("
									SELECT `groups`.name FROM users_to_groups, `groups`
									WHERE
										(users_to_groups.user_id = ?) AND 
										(users_to_groups.group_id = `groups`.id)
									ORDER BY `rank`;
								");
    $stmt->bind_param("i", $profile_id);
    $stmt->execute();
    $result_set = $stmt->get_result();
    $row = $result_set->fetch_assoc();
    if ($row) {
        do {
            echo "<tr>";
            echo "	<td class=\"profile_extra_info_row\">";
            CheckStringValue($row['name']);
            echo $row['name'];
            echo "	</td>";
            echo "</tr>";
        } while ($row = $result_set->fetch_assoc());
    } else {
        echo "<tr>";
        echo "	<td class=\"profile_extra_info_row\">";
        echo "		Пользователь не состоит ни в одной из групп.";
        echo "	</td>";
        echo "</tr>";
    }

    echo "
									</table>
								";
}
?>
<?php
include_once "includes/footer.php";
require "includes/mysql/mysql_disconnect.php";
?>