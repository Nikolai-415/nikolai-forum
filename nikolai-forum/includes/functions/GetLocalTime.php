<?php
	/* Возвращает относительное время (GMT +3) */
	function GetLocalTime($time) {
		return $time + 3 * 60 * 60; // GMT +3 Moscow
	}
?>