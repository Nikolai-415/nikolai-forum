<?php
$path = "/var/www/html";
require $path . "/includes/mysql/mysql_connect.php";

require $path . "/includes/session/session_start.php";
if (IsLogged()) {
    header('Location: /profile');
    exit;
}
CheckBanAndLogoutIfTrue();

$title = "Авторизация";
include_once $path . "/includes/head.php";

$menu_button = 3;
include_once $path . "/includes/header.php";
?>
    <form action="/login" method="POST" class="reglog_form">
        <fieldset>
            <legend><b>Авторизация</b></legend>


            <table>
                <tr>
                    <td colspan="2">
                        Данные
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="nick">Ник <span class="asterisk">*</span>:</label>
                    </td>
                    <td>
                        <input type="text" size="32" maxlength="32" name="nick" id="nick"
                               value="<?php echo $_POST['nick'] ?? ""; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Пароль <span class="asterisk">*</span>:</label>
                    </td>
                    <td>
                        <input type="password" size="32" maxlength="32" name="password" id="password"
                               value="<?php echo $_POST['password'] ?? ""; ?>">
                    </td>
                </tr>
            </table>

            <div class="reglog_form_errors">
                <?php
                if (($_POST['button'] ?? null) !== null) {
                    $nick = $_POST['nick'];
                    $password = $_POST['password'];
                    $mdPassword = md5($password);

                    $is_authorization_successful = 0;
                    $was_any_error = 0;
                    $errors_status = array(0, 0, 0, 0);
                    $errors_text = array("", "", "", "");

                    if (empty($nick)) {
                        $errors_status[0] = 1;
                        $errors_text[0] = "Введите ник!";
                        $was_any_error = 1;
                    }
                    if (empty($password)) {
                        $errors_status[1] = 1;
                        $errors_text[1] = "Введите пароль!";
                        $was_any_error = 1;
                    }
                    if ($was_any_error == 0) {
                        $stmt = $mysqli->prepare("SELECT id FROM users WHERE nick = ? AND password_md5 = ?;");
                        $stmt->bind_param("ss", $nick, $mdPassword);
                        $stmt->execute();
                        $result_set = $stmt->get_result();

                        $row = $result_set->fetch_assoc();
                        if (!($row)) {
                            $errors_status[2] = 1;
                            $errors_text[2] = "Вы ввели неправильный логин или пароль!";
                            $was_any_error = 1;
                        } else {
                            $stmt = $mysqli->prepare("SELECT * FROM users WHERE nick = ?");
                            $stmt->bind_param("s", $nick);
                            $stmt->execute();
                            $result_set = $stmt->get_result();

                            $row = $result_set->fetch_assoc();

                            if ($row) {
                                $user_id = $row["id"];

                                if (IsBanned($user_id)) {
                                    $errors_status[3] = 1;
                                    $errors_text[3] = GetBansString($user_id);
                                    $was_any_error = 1;
                                } else {
                                    $is_authorization_successful = 1;
                                }
                            }
                        }
                    }

                    if ($was_any_error == 1) {
                        echo "<div class=\"reglog_form_errors\">";

                        for ($i = 0; $i < sizeof($errors_status); $i++) {
                            if ($errors_status[$i] == 1) {
                                echo "<div class=\"error_text\">" . $errors_text[$i] . "</div>";
                            }
                        }

                        echo "</div>";
                    }

                    if ($is_authorization_successful == 1) {
                        $stmt = $mysqli->prepare("SELECT * FROM users WHERE nick = ?");
                        $stmt->bind_param("s", $nick);
                        $stmt->execute();
                        $result_set = $stmt->get_result();
                        $row = $result_set->fetch_assoc();
                        if ($row) {
                            $id = $row["id"];
                            SaveSession($id);
                            echo "<script type='text/javascript'>document.location.href = '/profile'; </script>";
                        } else {
                            echo "<div class='error_text'>Возникла ошибка на стороне сервера! Попробуйте повторить попытку.</div>";
                        }
                    }
                }
                ?>
            </div>

            <input type="submit" value="Войти" name="button">
            <br/><a href="/registration">Регистрация</a>
        </fieldset>
    </form>
<?php
include_once $path . "/includes/footer.php";
require $path . "/includes/mysql/mysql_disconnect.php";
?>