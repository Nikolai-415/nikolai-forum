<?php
/* Вспомогательная функция для EchoPageNavigation(...). */
function EchoLink($number)
{
    if ($number != $GLOBALS["total_page"]) {
        echo "<a href='" . $GLOBALS['zapros'] . $number . "'><div>" . $number . "</div></a>";
    }
}

/* Вспомогательная функция для EchoPageNavigation(...). */
function EchoFirstEllipsis()
{
    echo "<a href='" . $GLOBALS['zapros'] . ($GLOBALS['total_page'] - $GLOBALS['navigation_pages_num'] - 1) . "'><div>...</div></a>";
}

/* Вспомогательная функция для EchoPageNavigation(...). */
function EchoFirstLinks()
{
    for ($i = $GLOBALS['first_page']; $i < $GLOBALS['total_page']; $i++) {
        if (($i > $GLOBALS['first_page']) && ($i < ($GLOBALS['total_page'] - $GLOBALS['navigation_pages_num'])) && (($GLOBALS['total_page'] - $GLOBALS['first_page'] - 2) > $GLOBALS['navigation_pages_num'])) {
            EchoFirstEllipsis();
            $i = ($GLOBALS['total_page'] - $GLOBALS['navigation_pages_num']);
        }
        echo EchoLink($i);
    }
}

/* Вспомогательная функция для EchoPageNavigation(...). */
function EchoTotalLink()
{
    echo "<a class=\"total_a\"><div>" . $GLOBALS['total_page'] . "</div></a>";
}

/* Вспомогательная функция для EchoPageNavigation(...). */
function EchoLastEllipsis()
{
    echo "<a href='" . $GLOBALS['zapros'] . ($GLOBALS['total_page'] + $GLOBALS['navigation_pages_num'] + 1) . "'><div>...</div></a>";
}

/* Вспомогательная функция для EchoPageNavigation(...). */
function EchoLastLinks()
{
    for ($i = ($GLOBALS['total_page'] + 1); $i <= $GLOBALS['last_page']; $i++) {
        if (($i > ($GLOBALS['total_page'] + $GLOBALS['navigation_pages_num'])) && ($i < $GLOBALS['last_page']) && (($GLOBALS['last_page'] - $GLOBALS['total_page'] - 2) > $GLOBALS['navigation_pages_num'])) {
            EchoLastEllipsis();
            $i = $GLOBALS['last_page'];
        }
        echo EchoLink($i);
    }
}

/* Выводит форму с навигацией по страницам. */
function EchoPageNavigation($zapros, $first_page, $total_page, $last_page, $records_on_page = 30, $is_topic = 0, $extra_page_name_text = "", $navigation_pages_num = 4)
{
    $GLOBALS['zapros'] = $zapros;
    $GLOBALS['first_page'] = $first_page;
    $GLOBALS['total_page'] = $total_page;
    $GLOBALS['last_page'] = $last_page;
    $GLOBALS['navigation_pages_num'] = $navigation_pages_num;

    echo "
			<div class=\"navigation\">
				Страницы:
		";

    echo EchoFirstLinks();
    echo EchoTotalLink();
    echo EchoLastLinks();

    if (($_GET['page' . $extra_page_name_text] ?? null) === null) {
        $_GET['page' . $extra_page_name_text] = 1;
    }
    echo "
				<br/>
				";
    echo "<form method=\"GET\">";
    if ($is_topic === 1) {
        echo "<input type=\"hidden\" name=\"id\" value=" . $_GET['id'] . ">";
    } else {
        foreach ($_GET as $key => $val) {
            if ($val != '' && $key != 'page') {
                echo "<input type=\"hidden\" name=\"$key\" value=" . $val . ">";
            }
        }
    }
    echo "
					<label for=\"page$extra_page_name_text\">Результатов на странице: " . $records_on_page . ". Перейти на</label>
					<input required type=\"text\" name=\"page$extra_page_name_text\" id=\"page$extra_page_name_text\" value=\"" . $_GET['page' . $extra_page_name_text] . "\">
					<label for=\"page$extra_page_name_text\">страницу:</label>
					<input type=\"submit\" value=\"Обновить\" name=\"button\">
				</form>
			</div>
		";
}

?>