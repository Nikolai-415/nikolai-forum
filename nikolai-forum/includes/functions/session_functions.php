<?php
	/* Проверяет, авторизовался ли текущий посетитель сайта. */
	function IsLogged() {
		if(isset($_SESSION['logged_user'])) {
			return 1;
		}
		else {
			return 0;
		}
	}
	
	/* Возвращает ID посетителя сайта (если тот авторизован, иначе - null, то есть он будет считаться "гостем"). */
	function GetSessionId() {
		if(IsLogged()) {
			return $_SESSION['logged_user']['id'];
		}
		else return null;
	}
	
	/* Сохраняет информацию о сессии. */
	function SaveSession($id) {
		$user = array("id" => $id);
		$_SESSION['logged_user'] = $user;
	}
	
	/* Очищает информацию о сессии. */
	function DeleteSession(){
		unset($_SESSION['logged_user']);
	}
	
	/* Проверяет, забанен ли текущий посетитель сайта (если он авторизовался), и выбрасывает его из аккаунта, если пользователь имеет действующий бан. */
	function CheckBanAndLogoutIfTrue() {
		global $mysqli;
		
		if(IsLogged()) {
			$user_id = GetSessionId();
			
			if(IsBanned($user_id)) {
				header ('Location: /logout');
				exit;
			}
			else {
				$last_active_datetime_int = GetLocalTime(time());
				$stmt = $mysqli->prepare("UPDATE users SET last_active_datetime_int = ? WHERE id = ?;");
				$stmt->bind_param("ii", $last_active_datetime_int, $user_id);
				$stmt->execute();
			}
		}
	}
	
	/* Проверяет, действительно ли пользователь вышел из аккаунта, если нет - перебрасывает его на страницу выхода. */
	function CheckIsLoggedAndLogoutIfFalse() {
		if(!IsLogged()) {
			header ('Location: /logout');
			exit;
		}
	}
?>