<?php
	session_start();
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)){
		header('Location: konto.php');
		exit();
	}
?>
<!DOCTYPE html>
<html lang="pl-PL">
	<head>
		<link rel="stylesheet" href="css/gra.css">
		<meta charset="UTF-8">
		<title>
			Gra przeglądarkowa - rejestracja
		</title>
	</head>
	<body>
		<center><h1>Gra przeglądarkowa - rzeczywistość</h1></center><br>
		<form class="l_r" action="rejestracja.php" method="POST">
			<h2>Zarejestruj się</h2><br>
			<label>
				E-mail*<br>
				<input type="mail" name="mail">
			</label>
			<br><br>
			<label>
				Login*<br>
				<input type="text" name="login">
			</label>
			<br><br>
			<label>
				Hasło*<br>
				<input type="password" name="haslo1">
			</label>
			<br><br>
			<label>
				Powtórz hasło*<br>
				<input type="password" name="haslo2">
			</label>
			<br><br><br>
			<button type="submit">Zarejestruj się</button>
			<br><br>
			<?php
				# Błąd rejestracji - wyświetlenie
				if(isset($_SESSION['błąd_register'])){
					echo $_SESSION['błąd_register'];
					$_SESSION['błąd_register'] = "";
				}
			?>
			<br><br>
			Masz już konto?<br>Zaloguj się <a href="index.php">tutaj</a>
		</form>
	</body>
</html>