<?php
	session_start();
	require_once("conn.php");
	
	if(!$conn){
		# Błąd połączenia z bazą
		echo "Błąd: ".mysqli_error($conn);
	} else {
		# Pobranie danych z formularza oraz hashowanie haseł
		$mail = $_POST['mail'];
		$login = $_POST['login'];
		$haslo1 = sha1($_POST['haslo1']);
		$haslo2 = sha1($_POST['haslo2']);
		
		# Sprawdzenie czy login lub mail istnieje w bazie
		$istnieje = mysqli_query($conn, "SELECT login, mail FROM konta WHERE login = '".$login."' OR mail = '".$mail."'");
		$ostatnie_id = mysqli_query($conn, "SELECT MAX(id) FROM konta_gry;");
		
		while($row1 = mysqli_fetch_array($istnieje)){
			$_SESSION['loginist'] = $row1[0];
			$_SESSION['mailist'] = $row1[1];
		}
		
		while($row = mysqli_fetch_array($ostatnie_id)){
			$_SESSION['ostatnie_id'] = $row[0];
		}
		
		if(isset($_SESSION['loginist']) && ($_SESSION['loginist'] == $login)){
			# Stworzenie błędu o loginie
			$_SESSION['błąd_register'] = "<span style='color: red;'>Podany login jest zajęty!</span>";
			header('Location: register.php');
			exit();
		} else if(isset($_SESSION['mailist']) && ($_SESSION['mailist'] == $mail)){
			# Stworzenie błędu o mailu
			$_SESSION['błąd_register'] = "<span style='color: red;'>Na podanym mailu istnieje już zarejestrowane konto!</span>";
			header('Location: register.php');
			exit();
		} else {
			if($mail == "" || $login == "" || $haslo1 == "" || $haslo2 == ""){
				# Stworzenie błędu o nieuzupełnieniu któregoś z pól
				$_SESSION['błąd_register'] = "<span style='color: red;'>Uzupełnij wymagane pola!</span>";
				header('Location: register.php');
				
			} else if($haslo1!=$haslo2) {
				# Stworzenie błędu o niezgodności haseł
				$_SESSION['błąd_register'] = "<span style='color: red;'>Podane hasła nie są identyczne!</span>";
				header('Location: register.php');
				
			} else {
				# Dodanie konta do bazy danych
				$dodawanie = mysqli_query($conn, "INSERT INTO konta VALUES (NULL, '".$login."', '".$haslo1."', '".$mail."', 700.00, 0, 0, ".($_SESSION['ostatnie_id']+1).")");
				
				if(!$dodawanie){
					# Błąd bazy danych
					$_SESSION['błąd_register'] = "<span style='color: red;'>Pojawił się błąd. Spróbuj ponownie później</span>";
					header('Location: register.php');
				} else {
					$isORnot = mysqli_query($conn, "SELECT login, haslo, money, mail, id FROM konta WHERE login = '".$login."' AND haslo = '".$haslo1."'");
				
					if((mysqli_num_rows($isORnot)) > 0){
						$_SESSION['zalogowany'] = true;
						
						while($row = mysqli_fetch_array($isORnot)){
							$_SESSION['login'] = $row[0];
							$_SESSION['haslo'] = $row[1];
							$_SESSION['money'] = $row[2];
							$_SESSION['mail'] = $row[3];
							$_SESSION['idmoje'] = $row[4];
						}
						$nowe_konto_gra = mysqli_query($conn, "INSERT INTO konta_gry VALUES (NULL, '".$_SESSION['idmoje']."', 0, 0)");
						
						unset($_SESSION['blad']);
						$isORnot->free_result();
						header('Location: gra2d.php');
						exit();
					}
				}
			}
		}
	}
	
	$conn->close();
?>