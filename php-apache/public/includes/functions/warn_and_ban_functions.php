<?php
/* Проверяет, забанен ли указанный пользователь. */
function IsBanned($user_id)
{
    global $mysqli;

    $total_time = GetLocalTime(time());

    $stmt = $mysqli->prepare("SELECT * FROM bans WHERE (user_to_id = ?) AND ((unban_datetime_int >= ?) OR is_permanent = 1);");
    $stmt->bind_param("ii", $user_id, $total_time);
    $stmt->execute();
    $result_set = $stmt->get_result();

    $row = $result_set->fetch_assoc();

    if ($row) {
        return 1;
    }
}

/* Возвращает информацию о варне в виде текста (в несколько строк). */
function GetWarnString($row)
{
    global $mysqli;

    $result = "";

    $user_from_id = $row['user_from_id'];

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?;");
    $stmt->bind_param("i", $user_from_id);
    $stmt->execute();
    $result_set = $stmt->get_result();

    $row2 = $result_set->fetch_assoc();

    $user_from_name = $row2['nick'];
    CheckStringValue($user_from_name);

    $warn_datetime_int = $row['warn_datetime_int'];
    $warn_datetime = gmdate("d.m.Y - H:i:s", $warn_datetime_int);
    $result .= "Предупреждение выдано администратором <a href=\"/profile?id=$user_from_id\">" . $user_from_name . "</a>.<br/>Дата выдачи: " . $warn_datetime;

    $description = $row['description'];
    CheckStringValue($description);
    $result .= "<br/>Причина: " . $description . ".";

    return $result;
}

/* Возвращает информацию о бане в виде текста (в несколько строк). */
function GetBanString($row)
{
    global $mysqli;

    $result = "";

    $user_from_id = $row['user_from_id'];

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?;");
    $stmt->bind_param("i", $user_from_id);
    $stmt->execute();
    $result_set = $stmt->get_result();

    $row2 = $result_set->fetch_assoc();

    $user_from_name = $row2['nick'];
    CheckStringValue($user_from_name);

    $ban_datetime_int = $row['ban_datetime_int'];
    $ban_datetime = gmdate("d.m.Y - H:i:s", $ban_datetime_int);
    $result .= "Бан выдан администратором <a href=\"/profile?id=$user_from_id\">" . $user_from_name . "</a>.<br/>Дата бана: " . $ban_datetime;

    if ($row['is_permanent']) // если бан навсегда
    {
        $result .= ".<br/>Бан навсегда.";
    } else // если бан не навсегда
    {
        $unban_datetime_int = $row['unban_datetime_int'];
        $unban_datetime = gmdate("d.m.Y - H:i:s", $unban_datetime_int);
        $result .= ".<br/>Дата разбана: " . $unban_datetime . ".";
    }

    $description = $row['description'];
    CheckStringValue($description);
    $result .= "<br/>Причина: " . $description . ".";

    return $result;
}

/* Возвращает информацию о всех банах пользователя в виде текста (в несколько строк). */
function GetBansString($user_id)
{
    global $mysqli;

    $result = "Данный аккаунт заблокирован!<br/><br/>";

    $total_time = GetLocalTime(time());

    $stmt = $mysqli->prepare("SELECT * FROM bans WHERE user_to_id = ? AND ((unban_datetime_int >= ?) OR (is_permanent = 1));");
    $stmt->bind_param("ii", $user_id, $total_time);
    $stmt->execute();
    $result_set = $stmt->get_result();

    $was_first = 0;
    while ($row = $result_set->fetch_assoc()) {
        if ($was_first == 1) {
            $result .= "<br/>";
        }
        $result .= GetBanString($row) . "<br/>";
        $was_first = 1;
    }

    return $result;
}

?>