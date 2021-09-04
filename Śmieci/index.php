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
<html lang='pl-PL'>
	<head>
		<link rel='stylesheet' href='gra.css'>
		<link rel='stylesheet' href='css/fontello.css'>
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
		<meta charset='UTF-8'>
		<title>
			Strona główna
		</title>
	</head>
	<body>
		<header>
			<div class="top">
				<a href='index.html'>
					
				</a>
			</div>
		</header>
		<content>
			<div>
				<div class='login'>
					<h3>Logowanie</h3>
					<form method='POST'>
						<label>
						Login
						<input type='text' name='login'><br>
						</label>
						<label>
						Hasło
						<input type='password' name='haslo'><br><br>
						</label>
						<button type='submit'>Zaloguj się</button><br><br>
						<?php
							if(isset($_SESSION['błąd_login'])){	
								echo $_SESSION['błąd_login'];
								$_SESSION['błąd_login'] = "";
							}
						?>
						Nie masz konta?<br>Nic straconego! Zarejestruj się <a href="register.php">tutaj</a>
					</form>
				</div>
			</div>
			<div class="content">
				<article>
					<h2 class='title_article'>Nowe początki </h2><span class='date'> 17.10.2020</span>
					<p class='text_article'>Oto nadeszły nowe początki!</p>
					<sub>Polubienia Komentarze</sub>
				</article>
				<aside>
					<nav>
						<ol>
							<li><a href='' class='active'>Strona główna</a></li>
							<li><a href=''>Forum</a></li>
							<li><a href=''>Społeczność</a></li>
							<li><a href=''>Pomoc</a></li>
						</ol>
					</nav>
				</aside>
			</div>
		</content>
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
				$isOrNot = mysqli_query($conn, "SELECT id, login, haslo, mail FROM konta WHERE login = '".$login."' AND haslo = '".$haslo."'");
					
				if((mysqli_num_rows($isOrNot)) > 0){
					# Zmiana sesyjnej na true
					$_SESSION['zalogowany'] = true;
					
					while($row = mysqli_fetch_array($isOrNot)){
						# Pobranie informacji o koncie
						$_SESSION['idmoje'] = $row[0];
						$_SESSION['login'] = $row[1];
						$_SESSION['haslo'] = $row[2];
						$_SESSION['mail'] = $row[3];
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