<?php
    $path = "/var/www/html/nikolai-forum/public";
	require $path."/includes/mysql/mysql_connect.php";
	
	require $path."/includes/session/session_start.php";
	if(IsLogged())
	{
		header ('Location: /profile');
		exit;
	}
	CheckBanAndLogoutIfTrue();
	
	$title = "Регистрация";
	include_once $path."/includes/head.php";
	
	$menu_button = 3;
	include_once $path."/includes/header.php";
?>
				<form action="/registration" method="POST" class="reglog_form">
					<fieldset>
						<legend><b>Регистрация</b></legend>
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
									<input type="text" size="32" maxlength="32" name="nick" id="nick" value="<?php echo $_POST['nick']; ?>">
								</td>
							</tr>
							<tr>
								<td>
									<label for="password">Пароль <span class="asterisk">*</span>:</label>
								</td>
								<td>
									<input type="password" size="32" maxlength="32" name="password" id="password" value="<?php echo $_POST['password']; ?>">
								</td>
							</tr>
							<tr>
								<td>
									<label for="password2">Подтверждение пароля <span class="asterisk">*</span>:</label>
								</td>
								<td>
									<input type="password" size="32" maxlength="32" name="password2" id="password2" value="<?php echo $_POST['psssword2']; ?>">
								</td>
							</tr>
						</table>
						
						<div class="reglog_form_errors">
						<?php
							if ($_POST['button'] !== null){
								$nick = $_POST['nick'];
								$password = $_POST['password'];
								$password_md5 = md5($password);
								$password2 = $_POST['password2'];
								
								$is_registration_successful = 0;
								$was_any_error = 0;
								$errors_status = array(0, 0, 0, 0, 0, 0, 0);
								$errors_text = array("", "", "", "", "", "", "");
								
								if(empty($nick))  {
									$errors_status[0] = 1;
									$errors_text[0] = "Введите ник!";
									$was_any_error = 1;
								}
								if ((!preg_match("/^[a-zA-Z0-9_-]{5,32}$/", $nick)) && (!empty($nick))) {
									$errors_status[1] = 1;
									$errors_text[1] = "Введённый ник не подходит! Только латинские буквы, цифры и символы _ и -, длина ника: 5-32 символа.";
									$was_any_error = 1;
								}
								if(empty($_POST['password'])) {
									$errors_status[2] = 1;
									$errors_text[2] = "Введите пароль!";
									$was_any_error = 1;
								}
								if ((!preg_match("/^[a-zA-Z0-9_@!#$%^&*)(]{8,32}$/", $password)) && (!empty($password))) {
									$errors_status[3] = 1;
									$errors_text[3] = "Введённый пароль не подходит! Длина пароля: 8-32 символа. Пароль может содержать только латинские буквы, цифры и следующие символы: @, !, #, $, %, ^, &, *, ), (, -, _, =, +.";
									$was_any_error = 1;
								}
								if(empty($_POST['password2'])) {
									$errors_status[4] = 1;
									$errors_text[4] = "Повторите пароль!";
									$was_any_error = 1;
								}
								if(($_POST['password'] != $password2) && (!empty($password2))) {
									$errors_status[5] = 1;
									$errors_text[5] = "Введенные пароли не совпадают!";
									$was_any_error = 1;
								}
								if($was_any_error == 0){
									$result_set = $mysqli->query("SELECT * FROM users WHERE nick = '$nick'");
									$row = $result_set->fetch_assoc();
									if($row){
										$errors_status[6] = 1;
										$errors_text[6] = "Пользователь с таким ником уже зарегистрирован!";
										$was_any_error = 1;
									}
									else {
										$is_registration_successful = 1;
									}
								}
								
								if($was_any_error == 1){
									echo "<div class=\"reglog_form_errors\">";
																			
									for($i = 0; $i < sizeof($errors_status); $i++){
										if($errors_status[$i] == 1){
											echo "<div class=\"error_text\">".$errors_text[$i]."</div>";
										}
									}
									
									echo "</div>";
										
								}
								
								if($is_registration_successful == 1){
									$registration_datetime_int = GetLocalTime(time());
									
									$client  = @$_SERVER['HTTP_CLIENT_IP'];
									$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
									$remote  = @$_SERVER['REMOTE_ADDR'];
									 
									if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
									elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
									else $ip = $remote;
									
									$stmt = $mysqli->prepare("INSERT INTO users (nick, password_md5, registration_datetime_int, registration_ip) VALUES (?, ?, ?, ?)");
									$stmt->bind_param("ssis", $nick, $password_md5, $registration_datetime_int, $ip);
									$stmt->execute();
										
									$stmt = $mysqli->prepare("SELECT * FROM users WHERE nick = ?");
									$stmt->bind_param("s", $nick);
									$stmt->execute();
									$result_set = $stmt->get_result();
									$row = $result_set->fetch_assoc();
									if($row){
										$id = $row["id"];
										SaveSession($id);
										echo "<script type='text/javascript'>document.location.href = '/profile'; </script>";
									}
									else{
										echo "<div class='error_text'>Возникла ошибка на стороне сервера! Попробуйте повторить попытку.</div>";
									}
								}
							}
						?>
						</div>
						
						<input type="submit" value="Зарегистроваться" name="button">
						<br/><a href="/login">Авторизация</a>
					</fieldset>
				</form>
<?php
	include_once $path."/includes/footer.php";
	require $path."/includes/mysql/mysql_disconnect.php";
?>