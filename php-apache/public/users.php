<?php
require "includes/mysql/mysql_connect.php";
require "includes/session/session_start.php";
CheckBanAndLogoutIfTrue();

// Устранение варнингов
$action = $_GET['action'] ?? 'view';
$errors_text = $errors_text ?? array();
$errors_number = $errors_number ?? 0;
$mysqli = $mysqli ?? null;

$records_on_page = 30;

$page_number = $_GET['page'] ?? 1;
if ($page_number <= 0) {
    header('Location: /users');
    exit;
}

$url_with_page = "/users?page=" . $page_number;

$url_for_page_navigation = "/users?page=";
if ($action == 'search') {
    $url_for_page_navigation = "/users";
    $is_first = 1;
    if (($_GET['button_update'] ?? null) !== null) {
        foreach ($_GET as $key => $val) {
            if ($val != '' && $key != 'page') {
                if ($is_first == 1) {
                    $url_for_page_navigation .= "?";
                    $is_first = 0;
                } else {
                    $url_for_page_navigation .= "&";
                }
                $url_for_page_navigation .= $key . "=" . $val;
            }
        }
    }
    if ($is_first == 1) {
        $url_for_page_navigation .= "?action=search&page=";
        $is_first = 0;
    } else {
        $url_for_page_navigation .= "&page=";
    }
}

if ($action == 'search') {
    $nick_contains = "%" . ($_GET['nick_contains'] ?? "") . "%";
    $where = "WHERE (id >= 1) AND (nick LIKE ?)";

    $stmt = $mysqli->prepare("SELECT id, name, `rank` FROM `groups` WHERE id >= 1 AND id != 3 ORDER BY `rank`;");
    $stmt->execute();
    $result_set = $stmt->get_result();
    $is_first = 1;
    while ($row = $result_set->fetch_assoc()) {
        $name = "is_attached_to_group_" . $row['id'];

        if (($_GET[$name] ?? null) === 'on') {
            $where .= " AND (id IN (SELECT user_id FROM users_to_groups WHERE (group_id = " . $row['id'] . ")))";
        }
    }
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS count FROM users $where;");
    $stmt->bind_param("s", $nick_contains);
} else {
    $stmt = $mysqli->prepare("SELECT COUNT(id) AS count FROM users WHERE (id >= 1);");
}
$stmt->execute();
$result_set = $stmt->get_result();
$records_num = 0;
if ($row = $result_set->fetch_assoc()) {
    $records_num = $row["count"];
}
$pages_num = ceil($records_num / $records_on_page);
if ($pages_num != 0) {
    if ($page_number > $pages_num) {
        header('Location: ' . $url_for_page_navigation . $pages_num);
        exit;
    }
    if ($page_number < 1 && $action == 'search' && $pages_num > 0) {
        header('Location: ' . $url_for_page_navigation . "1");
        exit;
    }
    if ($page_number < 1 && $action != 'search' && $_GET['button'] === null && $pages_num > 0) {
        header('Location: /users?page=1');
        exit;
    }
}

$title = "Пользователи";
include_once "includes/head.php";
?>
<?php
$menu_button = 4;
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
    echo "<a class='article_menu_button_blue' href='" . "/users?action=search&page=" . $page_number . "'>Открыть поиск</a> ";
}

if ($show_article_menu == 1) {
    echo "</div>";
}

if ($action == 'search') {
    echo "
								<form method=\"GET\" class=\"forum_form\">
									<fieldset>
										<input type=\"text\" name=\"action\" id=\"action\" value=\"" . $_GET['action'] . "\" hidden>
										<input type=\"text\" name=\"page\" id=\"page\" value=\"" . $_GET['page'] . "\" hidden>
										<legend><b>Поиск пользователей</b></legend>
										<table class=\"settings\">
											<tr>
												<td colspan=\"2\">
													<label>
															<b>Информация о пользователе</b>
													</label>
												</td>
											</tr>
											<tr>
												<td>
													<label for=\"nick_contains\">
															Ник пользователя содержит:
													</label>
												</td>
												<td>
													<input type=\"text\" size=\"32\" maxlength=\"63\" name=\"nick_contains\" id=\"nick_contains\" value=\"" . ($_GET['nick_contains'] ?? "") . "\">
												</td>
											</tr>
										</table>
										<table class=\"settings\">
											<tr>
												<td colspan=\"2\">
													<label>
															<b>Обязательная принадлежность к группам</b>
													</label>
												</td>
											</tr>
							";

    $stmt = $mysqli->prepare("SELECT id, name, `rank` FROM `groups` WHERE id >= 1 AND id != 3 ORDER BY `rank`;");
    $stmt->execute();
    $result_set = $stmt->get_result();
    while ($row = $result_set->fetch_assoc()) {
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
        if (($_GET[$name] ?? null) == 'on') {
            echo " checked";
        }
        echo ">
												</td>
											</tr>
								";
    }
    echo "
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
										<input type=\"submit\" value=\"Применить\" name=\"button_update\">
										<a href=\"$url_with_page\"><input type=\"button\" value=\"Закрыть\" name=\"button_cancel\"></a>
									</fieldset>
								</form>
							";
}
?>
    <table id="players_table">
        <tr>
            <th colspan="4">
                <?php
                if ($action == 'search') {
                    echo "Найдено пользователей: " . $records_num;
                } else {
                    echo "Всего пользователей: " . $records_num;
                }
                ?>
            </th>
        </tr>

        <?php
        $offset = ($page_number - 1) * $records_on_page;

        $stmt = $mysqli->prepare("SELECT * FROM users WHERE (id >= 1) LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $records_on_page, $offset);
        if ($action == 'search' || ($_POST['button'] ?? false)) {
            $stmt = $mysqli->prepare("SELECT * FROM users $where ORDER BY id LIMIT ? OFFSET ?");
            $stmt->bind_param("sii", $nick_contains, $records_on_page, $offset);
        }
        $stmt->execute();
        $result_set = $stmt->get_result();

        if ($row = $result_set->fetch_assoc()) {
            echo "	
										<tr>
											<th>
												ID
											</th>
											<th>
												Ник
											</th>
											<th>
												Дата регистрации
											</th>
											<th>
												Статус
											</th>
										</tr>
								";
            do {
                echo "	<tr>";
                echo "		<td>";
                echo $row['id'];
                echo "		</td>";
                echo "		<td>";
                $nick = $row["nick"];
                CheckStringValue($nick);
                echo "<a href='/profile?id=" . $row['id'] . "'>" . $nick . "</a>";
                echo "		</td>";
                echo "		<td>";
                $registration_datetime_int = $row["registration_datetime_int"];
                echo gmdate("d.m.Y - H:i:s", $registration_datetime_int);
                echo "		</td>";
                echo "		<td>";
                $last_active_datetime_int = $row["last_active_datetime_int"];
                if (IsBanned($row['id'])) {
                    echo "<div class='status_banned'>Забанен</div>";
                } else {
                    if ((GetLocalTime(time()) - $last_active_datetime_int) / 60 >= 5) {
                        echo "<div class='status_offline'>Оффлайн</div>";
                    } else {
                        echo "<div class='status_online'>Онлайн</div>";
                    }
                }
                echo "		</td>";
                echo "	</tr>";
            } while ($row = $result_set->fetch_assoc());
        } else {
            echo "	<tr>";
            echo "		<td colspan=\"4\">";
            echo "			Пользователи не найдены!";
            echo "		</td>";
            echo "	</tr>";
        }
        ?>
    </table>
<?php
if ($pages_num > 0) {
    EchoPageNavigation($url_for_page_navigation, 1, $page_number, $pages_num, $records_on_page);
}
?>
<?php
include_once "includes/footer.php";
require "includes/mysql/mysql_disconnect.php";
?>