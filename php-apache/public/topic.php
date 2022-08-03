<?php
$path = "/var/www/html";
require $path . "/includes/mysql/mysql_connect.php";

require $path . "/includes/session/session_start.php";
CheckBanAndLogoutIfTrue();

$topic_id = 0;
if (($_GET['id'] ?? null) !== null) {
    $topic_id = $_GET['id'];
}
if (!(IsTopicExist($topic_id))) {
    header('Location: /error_404'); // перенаправляем на страницу ошибки
    exit;
}

$user_id = GetSessionId();
$user_permissions = GetUserTopicPermissions($user_id, $topic_id);

$can_see_this_topic = $user_permissions['can_see_this_topic'];

$can_edit_this_topic = $user_permissions['can_edit_this_topic'];
$can_delete_this_topic = $user_permissions['can_delete_this_topic'];
$can_create_commentaries = $user_permissions['can_create_commentaries'];

if ($can_see_this_topic == 0) {
    header('Location: /error_404'); // перенаправляем на страницу ошибки
    exit;
}

$url_for_page_navigation = "/topic?id=" . $topic_id;
/* ============================================= */
/* Вычисления страниц */
/* ============================================= */
$records_on_page = 10;

$stmt = $mysqli->prepare("SELECT COUNT(*) AS count FROM commentaries WHERE (topic_id = ?);");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result_set = $stmt->get_result();

$row = $result_set->fetch_assoc();

$records_num = 1;
if ($row) {
    $records_num = $row["count"];
}
if ($records_num == 0) {
    $records_num = 1;
}

$pages_num = ceil($records_num / $records_on_page);
if (($page_number ?? 1) > $pages_num) {
    header('Location: ' . $url_for_page_navigation . '&page=' . $pages_num);
    exit;
}

$extra_page_name_text = "_2";
if (($_GET['page' . $extra_page_name_text] ?? null) !== null) {
    $_GET['page'] = $_GET['page' . $extra_page_name_text];
}

$page_number = 1;
if (($_GET['page'] ?? null) !== null) {
    $page_number = $_GET['page'];
    if ($page_number == 'last') {
        header('Location: ' . $url_for_page_navigation . '&page=' . $pages_num);
        exit;
    }
    if ($page_number < 1) {
        header('Location: ' . $url_for_page_navigation . '&page=1');
        exit;
    }
}
/* ============================================= */

$action = $_GET['action'] ?? null;
$errors_text = array(); // название каждой ошибки
$errors_number = 0;
$url_with_page = $url_for_page_navigation;
if (($_GET['page'] ?? null) !== null) {
    $url_with_page .= "&page=" . $_GET['page'];
}
if ($action != 'edit' && $action != 'delete') // если запрос пустой
{
    if (($_GET['action'] ?? null) === null) {
        $action = 'view';
    }

    if (($_POST['button_submit'] ?? null) !== null) // если пользователь подтвердил действие
    {
        if ($can_create_commentaries == 0) // если пользователь не имеет соответствующих прав
        {
            header("Location: /topic?id=$topic_id"); // перенаправляем на тему
            exit;
        } else {
            $creation_datetime_int = GetLocalTime(time());
            if (($_POST['commentary'] ?? null) != '') {
                $commentary = $_POST['commentary'];

                $stmt = $mysqli->prepare("INSERT INTO commentaries(topic_id, user_from_id, text, creation_datetime_int) values(?, ?, ?, ?);");
                $stmt->bind_param("iisi", $topic_id, $user_id, $commentary, $creation_datetime_int);
                if ($stmt->execute()) {
                    $successful_create = 1;
                } else {
                    $errors_text[$errors_number++] = "Возникла ошибка при добавлении комментария!";
                }
                $_POST['commentary'] = '';
            } else {
                $errors_text[$errors_number++] = "Введите текст комментария!";
            }
        }
    }

    if ((($_POST['button_submit_edit'] ?? null) !== null) || (($_POST['button_submit_delete'] ?? null) !== null)) // в случае удаления и редактирования комментария
    {
        $commentary_id = $_POST['commentary-id'];
        if (($commentary_id == null) || (IsCommentaryExist($commentary_id) == 0)) {
            header("Location: " . $url_with_page); // перенаправляем на тему
            exit;
        } else {
            $user_permissions_to_commentary = GetUserCommentaryPermissions($user_id, $commentary_id);

            // первый комментарий нельзя обновить или удалить, так как он является "текстом темы"
            $stmt = $mysqli->prepare("SELECT id FROM commentaries WHERE (topic_id = ?) LIMIT 1;");
            $stmt->bind_param("i", $topic_id);
            $stmt->execute();
            $result_set = $stmt->get_result();
            $row = $result_set->fetch_assoc();
            if ($row) {
                $first_commentary_id = $row['id'];
                if ($first_commentary_id == $commentary_id) {
                    header("Location: " . $url_with_page); // перенаправляем на тему
                    exit;
                }
            }

            if ($_POST['button_submit_edit'] !== null) // если пользователь подтвердил действие
            {
                $can_edit_this_commentary = $user_permissions_to_commentary['can_edit_this_commentary'];
                if ($can_edit_this_commentary == 0) // если пользователь не имеет соответствующих прав
                {
                    header("Location: " . $url_with_page); // перенаправляем на тему
                    exit;
                } else {
                    $stmt = $mysqli->prepare("
							UPDATE commentaries SET text = ? WHERE (id = ?);
						");
                    $stmt->bind_param("si", $_POST['edited-commentary'], $commentary_id);
                    if (!($stmt->execute())) {
                        $errors_text[$errors_number++] = "Возникла ошибка при изменении комментария!";
                    }
                }
            } else if ($_POST['button_submit_delete'] !== null) // если пользователь подтвердил действие
            {
                $can_delete_this_commentary = $user_permissions_to_commentary['can_delete_this_commentary'];
                if ($can_delete_this_commentary == 0) // если пользователь не имеет соответствующих прав
                {
                    header("Location: " . $url_with_page); // перенаправляем на тему
                    exit;
                } else {
                    $stmt = $mysqli->prepare("
							DELETE FROM commentaries WHERE (id = ?);
						");
                    $stmt->bind_param("i", $commentary_id);
                    if (!($stmt->execute())) {
                        $errors_text[$errors_number++] = "Возникла ошибка при удалении комментария!";
                    }
                }
            }
        }
    }
} else {
    $url_with_page = $url_for_page_navigation;
    if (($_GET['page'] ?? null) !== null) {
        $url_with_page .= "&page=" . $_GET['page'];
    }

    $url_for_page_navigation .= "&action=" . $action;

    if ($action == 'delete') {
        if ($can_delete_this_topic == 0) // если пользователь не имеет соответствующих прав
        {
            header("Location: " . $url_with_page); // перенаправляем на тему
            exit;
        } else if (($_POST['button_submit'] ?? null) !== null) // если пользователь подтвердил действие
        {
            $stmt = $mysqli->prepare("SELECT forum_id FROM topics WHERE (id = ?);");
            $stmt->bind_param("i", $topic_id);
            $stmt->execute();
            $result_set = $stmt->get_result();
            $row = $result_set->fetch_assoc();
            $parent_forum_id = 0;
            if ($row) {
                $parent_forum_id = $row['forum_id'];
            }
            $stmt = $mysqli->prepare("DELETE FROM topics WHERE (id = ?);");
            $stmt->bind_param("i", $topic_id);
            if ($stmt->execute()) {
                header("Location: /forum?id=$parent_forum_id"); // перенаправляем на форум
                exit;
            } else {
                $errors_text[$errors_number++] = "Возникла ошибка при удалении темы!";
            }
        }
    } else if ($action == 'edit') {
        if ($can_edit_this_topic == 0) // если пользователь не имеет соответствующих прав
        {
            header("Location: " . $url_with_page); // перенаправляем на тему
            exit;
        }

        $stmt = $mysqli->prepare("SELECT name, description, is_description_hided, is_closed, forum_id FROM topics WHERE (id = ?);");
        $stmt->bind_param("i", $topic_id);
        $stmt->execute();
        $result_set = $stmt->get_result();

        $row = $result_set->fetch_assoc();

        if ($row) {
            if (($_POST['button_submit'] ?? null) === null) {
                $_POST['topic_name'] = $row['name'];
                CheckStringValue($_POST['topic_name']);
                $_POST['topic_description'] = $row['description'];
                CheckStringValue($_POST['topic_description']);
                $_POST['topic_is_description_hided'] = "" . $row['is_description_hided'];
                $_POST['topic_is_closed'] = "" . $row['is_closed'];
                $_POST['forum_tree'] = "" . $row['forum_id'];

                $stmt = $mysqli->prepare("SELECT text FROM commentaries WHERE (topic_id = ?) LIMIT 1;");
                $stmt->bind_param("i", $topic_id);
                $stmt->execute();
                $result_set = $stmt->get_result();

                $row = $result_set->fetch_assoc();

                if ($row) {
                    $_POST['topic-commentary'] = "" . $row['text'];
                    CheckStringValue($_POST['topic-commentary']);
                }
            } else {
                // проверка на то, что пользователь имеет доступ для создания тем в выбранном форуме
                $user_permissions_2 = GetUserForumPermissions($user_id, $_POST['forums_tree']);
                $can_see_this_forum = $user_permissions_2['can_see_this_forum'];
                $can_create_topics = $user_permissions_2['can_create_topics'];
                if ($can_see_this_forum == 1 && $can_create_topics == 1) {
                    // проверка на правильность значений
                    CheckValue01AndSetToDefaultIfWrong($_POST['topic_is_closed']);
                    CheckValue012AndSetToDefaultIfWrong($_POST['topic_is_description_hided']);

                    $stmt = $mysqli->prepare("
							UPDATE topics SET name = ?, description = ?, forum_id = ?, is_closed = ?, is_description_hided = ? WHERE id = ?;
						");
                    $stmt->bind_param("ssiiii", $_POST['topic_name'], $_POST['topic_description'], $_POST['forums_tree'], $_POST['topic_is_closed'], $_POST['topic_is_description_hided'], $topic_id);
                    if ($stmt->execute()) {
                        // обновляем текст первого комментария
                        $stmt = $mysqli->prepare("SELECT id FROM commentaries WHERE (topic_id = ?) LIMIT 1;");
                        $stmt->bind_param("i", $topic_id);
                        $stmt->execute();
                        $result_set = $stmt->get_result();
                        $row = $result_set->fetch_assoc();
                        if ($row) {
                            $first_commentary_id = $row['id'];
                            $stmt = $mysqli->prepare("
									UPDATE commentaries SET text = ? WHERE (id = ?) AND (topic_id = ?);
								");
                            $stmt->bind_param("sii", $_POST['topic-commentary'], $first_commentary_id, $topic_id);
                            if ($stmt->execute()) {
                                header("Location: /topic?id=" . $topic_id); // перенаправляем на созданную тему
                            } else {
                                $errors_text[$errors_number++] = "Возникла ошибка при обновлении текста темы!";
                            }
                        }
                    } else {
                        $errors_text[$errors_number++] = "Возникла ошибка при обновлении темы!";
                    }
                } else {
                    $errors_text[$errors_number++] = "Вы не можете изменять темы в выбранном форуме!";
                }
            }
        }
    } else if ($action == 'edit-commentary' || $action == 'delete-commentary') {
        $commentary_id = $_GET['commentary-id'];
        if (($commentary_id == null) || (IsCommentaryExist($commentary_id) == 0)) {
            header("Location: " . $url_with_page); // перенаправляем на тему
            exit;
        } else {
            $user_permissions_to_commentary = GetUserCommentaryPermissions($user_id, $commentary_id);

            if ($action == 'edit-commentary') {
                $can_edit_this_commentary = $user_permissions_to_commentary['can_edit_this_commentary'];
                if ($can_edit_this_commentary == 0) // если пользователь не имеет соответствующих прав
                {
                    header("Location: " . $url_with_page); // перенаправляем на тему
                    exit;
                }
            } else if ($action == 'delete-commentary') {
                $can_delete_this_commentary = $user_permissions_to_commentary['can_delete_this_commentary'];
                if ($can_delete_this_commentary == 0) // если пользователь не имеет соответствующих прав
                {
                    header("Location: " . $url_with_page); // перенаправляем на тему
                    exit;
                }
            }
        }
    } else // если действие не опознано
    {
        header("Location: " . $url_with_page); // перенаправляем на тему
        exit;
    }
}
/* ============================================= */
/* Вычисления страниц (ещё раз пересчитываем количество записей, так как пользователь мог создать / удалить комментарий)*/
/* ============================================= */
$records_on_page = 10;

$page_number = 1;
if (($_GET['page'] ?? null) !== null) {
    $page_number = $_GET['page'];
    if ($page_number < 1) {
        header('Location: ' . $url_for_page_navigation . '&page=1');
        exit;
    }
    if (($_GET['button'] ?? null) !== null) {
        header('Location: ' . $url_for_page_navigation . '&page=' . $page_number);
        exit;
    }
}

$stmt = $mysqli->prepare("SELECT COUNT(*) AS count FROM commentaries WHERE (topic_id = ?);");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result_set = $stmt->get_result();

$row = $result_set->fetch_assoc();

$records_num = 1;
if ($row) {
    $records_num = $row["count"];
}
if ($records_num == 0) {
    $records_num = 1;
}

$pages_num = ceil($records_num / $records_on_page);
if ($page_number > $pages_num) {
    header('Location: ' . $url_for_page_navigation . '&page=' . $pages_num);
    exit;
}
/* ============================================= */

if ($successful_create ?? 0 == 1) // при добавлении комментария - перекидываем в конец темы (к этому самому комментарию)
{
    header('Location: ' . $url_for_page_navigation . '&page=' . $pages_num . "#topic-bottom");
    exit;
}

$stmt = $mysqli->prepare("SELECT name FROM topics WHERE id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result_set = $stmt->get_result();
$row = $result_set->fetch_assoc();
$title = "Тема";
if ($row) {
    $title = $row['name'];
}
include_once $path . "/includes/head.php";
?>
<?php
$menu_button = 2;
include_once $path . "/includes/header.php";
?>
<?php
if ($action != 'edit' && $action != 'delete') {
    $can_do_something = 0;

    if ($can_edit_this_topic == 1) {
        $can_do_something = 1;
    }
    if ($can_delete_this_topic == 1) {
        $can_do_something = 1;
    }
    if ($can_create_commentaries == 1) {
        $can_do_something = 1;
    }

    if ($can_do_something) {
        echo "<div id=\"article_menu\">";
        if ($can_edit_this_topic == 1) {
            echo "<a class='article_menu_button_blue' href='" . $url_with_page . "&action=edit'>Изменить эту тему</a> ";
        }
        if ($can_delete_this_topic == 1) {
            echo "<a class='article_menu_button_blue' href='" . $url_with_page . "&action=delete'>Удалить эту тему</a> ";
        }
        if ($can_create_commentaries == 1) {
            echo "<a class='article_menu_button_blue' href='#create-commentary'>Добавить комментарий</a> ";
        }
        echo "</div>";
    }
} else if ($action == 'edit' || $action == 'delete') {
    if ($action == 'edit') {
        $legend = "Изменение темы";
        $submit_button_name = "Изменить";
    } else if ($action == 'delete') {
        $legend = "Удаление темы";
        $submit_button_name = "Удалить";
    }

    echo "
									<form action=\"/topic?id=$topic_id&action=$action\" method=\"POST\" class=\"forum_form\">
										<fieldset>
											<legend><b>$legend</b></legend>
								";
    if ($action == 'delete') {
        echo "
											<table class=\"settings\">
												<tr>
													<td colspan=\"2\">
														<label>
																Вы действительно хотите удалить эту тему?<br/>Все комментарии в этой теме также будут удалены.<br/>Отменить это действие будет невозможно.
														</label>
													</td>
												</tr>
											</table>
									";
    } else if ($action == 'edit') {
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
														<input required type=\"text\" size=\"32\" maxlength=\"63\" name=\"topic_name\" id=\"topic_name\" value=\"" . $_POST['topic_name'] . "\">
													</td>
												</tr>
												<tr>
													<td>
														<label for=\"topic_description\">
																Описание темы:
														</label>
													</td>
													<td>
														<textarea rows=\"3\" cols=\"34\" maxlength=\"255\" name=\"topic_description\" id=\"topic_description\">" . $_POST['topic_description'] . "</textarea>
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
															<option value=\"1\" ";
        if ($_POST['topic_is_description_hided'] === null || $_POST['topic_is_description_hided'] === "1") echo "selected";
        echo ">
																Да
															</option>
															<option value=\"0\" ";
        if ($_POST['topic_is_description_hided'] === "0") echo "selected";
        echo ">
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
															<option value=\"1\" ";
        if ($_POST['topic_is_closed'] === "1") echo "selected";
        echo ">
																Да
															</option>
															<option value=\"0\" ";
        if ($_POST['topic_is_closed'] === null || $_POST['topic_is_closed'] === "0") echo "selected";
        echo ">
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
        $selected_forum = $_POST['forum_tree'] ?? null;
        if ($selected_forum === null) // если запроса POST нет
        {
            $stmt = $mysqli->prepare("SELECT forum_id FROM topics WHERE (id = ?);");
            $stmt->bind_param("i", $topic_id);
            $stmt->execute();
            $result_set = $stmt->get_result();

            $row = $result_set->fetch_assoc();

            $forum_id = 0;

            if ($row) {
                $forum_id = $row['forum_id'];
            }

            $selected_forum = $forum_id;
        }
        EchoForumsTreeInSelectTag($user_id, $selected_forum, $forum_id ?? $selected_forum, $action, 1);
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
														<textarea required rows=\"7\" maxlength=\"8191\" name=\"topic-commentary\" id=\"topic-commentary\">" . ($_POST['topic-commentary'] ?? "") . "</textarea>
													</td>
												</tr>
											</table>
									";
    }


    if (sizeof($errors_text) > 0) {
        echo "<div class=\"forum_form_errors\">";

        for ($i = 0; $i < $errors_number; $i++) {
            echo "<div color='red'>" . $errors_text[$i] . "</div>";
        }

        echo "</div>";
    }

    echo "
											<input type=\"submit\" value=\"$submit_button_name\" name=\"button_submit\">
											<a href=\"" . $url_with_page . "\"><input type=\"button\" value=\"Отмена\" name=\"button_cancel\"></a>
										</fieldset>
									</form>
								";
}
$offset = ($page_number - 1) * $records_on_page;
$limit = $records_on_page;

$stmt = $mysqli->prepare("SELECT name, forum_id FROM topics WHERE (id = ?);");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result_set = $stmt->get_result();

$row = $result_set->fetch_assoc();

if ($row) {
    $forum_id = $row['forum_id'];
    $topic_name = $row['name'];
    CheckStringValue($topic_name);
    $forum_tree_mass = GetForumTreeAsMass($forum_id);
    $forum_tree_size = sizeof($forum_tree_mass) / 2;
    if ($forum_tree_size >= 1) {
        echo "<div class=\"forum_table_forums_names\">";
        for ($i = 0; $i < $forum_tree_size; $i++) {
            if ($i != 0) {
                echo "<div> > </div>";
            }
            echo "<div><b><a href=\"/forum?id=" . $forum_tree_mass['id_' . $i] . "\">" . $forum_tree_mass['name_' . $i] . "</a></b></div>";
        }
        echo "	<div> > </div>";
        echo "	<div><b><a class=\"total_select\">" . $topic_name . "</a></b></div>";
        echo "</div>";
        echo "<div class='clear'></div>";
    }
}

EchoPageNavigation($url_for_page_navigation . '&page=', 1, $page_number, $pages_num, $records_on_page, 1, $extra_page_name_text);
EchoTopicTable($topic_id, $user_id, $limit, $offset, $action);
echo "<a id=\"topic-bottom\"></a>";
EchoPageNavigation($url_for_page_navigation . '&page=', 1, $page_number, $pages_num, $records_on_page, 1);
?>
<?php
include_once $path . "/includes/footer.php";
require $path . "/includes/mysql/mysql_disconnect.php";
?>