<?php
	// проверяет, существует ли указанный игрок
	function IsUserExist($forum_id)
	{
		global $mysqli;	
		
		$stmt = $mysqli->prepare("SELECT id FROM users WHERE (id = ?);");
		$stmt->bind_param("i", $forum_id);
		$stmt->execute();
		$result_set = $stmt->get_result();
		
		$rows = $result_set->fetch_row();
		
		if($rows)
		{		
			return true;
		}
		else
		{
			return false;
		}
	}
?>