<?php
	session_start();
	require_once("conn.php");
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true))
	{
		header('Location: postacie.php');
		exit();
	}
?>
<!DOCTYPE html>
<html lang="pl-PL">
	<head>
		<link rel="stylesheet" href="css/gra.css">
		<meta charset="UTF-8">
		<title>
			Gra przeglądarkowa - logowanie
		</title>
	</head>
	<body>
		<center><h1>Gra przeglądarkowa - rzeczywistość</h1></center><br>
		<form class="l_r" method="POST">
			<h2>Zaloguj się</h2>
			<br>
			<label>
				Login:<br>
				<input type="text" name="login">
			</label>
			<br><br>
			<label>
				Hasło:<br>
				<input type="password" name="haslo">
			</label>
			<br><br>
			<button type="submit">Zaloguj się</button>
			<br><br>
			<?php
				if(isset($_SESSION['błąd_login'])){	
					echo $_SESSION['błąd_login'];
					$_SESSION['błąd_login'] = "";
				}
			?>
			<br><br>
			Nie masz konta?<br>Nic straconego! Zarejestruj się <a href="register.php">tutaj</a>
			<br>
		</form>
		<div class='block'></div>
	</body>
	<?php
		if(!$conn){
			# Błąd połączenia z bazą
			echo "Błąd: ".mysqli_error($conn);
		} else {
			if((isset($_POST['login'])) && (isset($_POST['haslo']))){
				$login = $_POST['login'];
				# Hashowanie hasła
				$haslo = sha1($_POST['haslo']);
				
				$login = htmlentities($login, ENT_QUOTES, "UTF-8");
				$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
				
				# Sprawdzenie poprawności loginu oraz hasła
				$isOrNot = mysqli_query($conn, "SELECT konta.id, login, haslo, money, mail, lvl, exp, hp, max_hp, max_exp FROM konta, konta_gry WHERE (konta.id = konta_gry.id_gracza) AND (login = '".$login."' AND haslo = '".$haslo."')");
					
				if((mysqli_num_rows($isOrNot)) > 0){
					# Zmiana sesyjnej na true
					$_SESSION['zalogowany'] = true;
					
					while($row = mysqli_fetch_array($isOrNot)){
						# Pobranie informacji o koncie
						$_SESSION['idmoje'] = $row[0];
						$_SESSION['login'] = $row[1];
						$_SESSION['haslo'] = $row[2];
						$_SESSION['money'] = $row[3];
						$_SESSION['mail'] = $row[4];
						$_SESSION['lvl'] = $row[5];
						$_SESSION['exp'] = $row[6];
						$_SESSION['hp'] = $row[7];
						$_SESSION['max_hp'] = $row[8];
						$_SESSION['max_exp'] = $row[9];
					}
					
					unset($_SESSION['blad']);
					$isOrNot->free_result();
					header('Location: postacie.php');
					
				} else {
					$_SESSION['błąd_login'] = "<span style='color: red;'>Niepoprawne dane logowania!</span>";
				}
			}
		}
		
		$conn->close();
	?>
</html>