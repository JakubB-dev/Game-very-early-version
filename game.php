<?php
	session_start();
	require_once('conn.php');
	
	# Przekierowanie podczas braku zalogowania
	if(!isset($_SESSION['zalogowany'])){
		header('Location: login.php');
		exit();
	}
	
	# Przekierowanie podczas braku wybrania postaci
	if(!isset($_SESSION['postac_wybrana'])){
		header('Location: postacie.php');
		exit();
	}
	
	# Przekierowanie podczas niewybrania liczby
	if(!isset($_POST['game'])){
		header('Location: konto.php');
		exit();
	}
	
	if(!$conn){
		# Wyświetlenie błędu z połączeniem
		echo "Błąd: ".mysqli_error($conn);
	} else {
		# Złapanie typu gracza oraz wylosowanie liczby
		$_SESSION['choose_user'] = $_POST['game'];
		$_SESSION['choose_random'] = rand(1, 50);
		
		if($_SESSION['money'] < 8){
			# Błąd przy zbyt małej ilości gotówki
			$_SESSION['błąd'] = "Masz zbyt niski stan konta!";
			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit();
		} else {
			if($_SESSION['choose_user'] == ""){
				# Błąd przy niewybraniu liczby
				$_SESSION['błąd'] = "Wybierz swoją liczbę!";
				header('Location: '.$_SERVER['HTTP_REFERER']);
				exit();
			} else {
				# Zaktualizowanie wartości (gotówka i liczba losowań) w bazie
				$zagranie = "UPDATE konta SET money = money - 8.00, liczba_losowan = liczba_losowan + 1 WHERE login = '".$_SESSION['login']."' AND haslo = '".$_SESSION['haslo']."'";
				$odejmowanie = mysqli_query($conn, $zagranie);
				header('Location: '.$_SERVER['HTTP_REFERER']);
			}
			
			if((isset($_SESSION['choose_user']) && isset($_SESSION['choose_random'])) && $_SESSION['choose_user'] == $_SESSION['choose_random']){
				# Dodanie nagrody pieniężnej gry wygrana oraz zaktualizowanie liczby gier wygranej
				$wygrana = "UPDATE konta SET money = money + 3000.00, liczba_wygranych = liczba_wygranych + 1 WHERE login = '".$_SESSION['login']."' AND haslo = '".$_SESSION['haslo']."'";
				$dodawanie = mysqli_query($conn, $wygrana);
			}
		}
		/*
		$choose = $_POST['game'];
		
		$i = 0;
		while($liczby = mysqli_fetch_array($choose)){
			$i = $liczby[$i];
			echo $i;
			$i++;
		}

		if(empty($_SESSION['choose_user'])){
			$_SESSION['błąd'] = "Wybierz liczby";
			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit();
		} else {
			
			for($i=1; $i<=6; $i++){
				echo $_SESSION['choose_user'][$i];
			}
		
		}
		
		$_SESSION['ile'] = count($_POST['game']);
		if(($_SESSION['ile'] > 6) && ($_SESSION['ile'] < 6)){
			$_SESSION['błąd'] = "Wybierz 6 liczb!";
			header('Location: '.$_SERVER['HTTP_REFERER']);
		} else {
			if(isset($_POST['submit'])){
				if(!empty($_POST['game'])){
					for($i = 0; $i < $_SESSION['ile']; $i++){
						$_SESSION['choose'.$i] = $_POST['game'][$i];
						$_SESSION['typ'] = $_SESSION['typ'].$_SESSION['choose'.$i];
					}
					header('Location: '.$_SERVER['HTTP_REFERER']);
					exit();
				}
			}
		}*/
	}
?>