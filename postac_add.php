<?php
	session_start();
	require_once('conn.php');
	
	if(!$conn){
		# Błąd połączenia
		echo "Błąd połaczenia ".mysqli_error($conn);
	} else {
		# Pobranie wartości z formularza
		$_SESSION['nick'] = $_POST['nick'];
		$_SESSION['prof'] = $_POST['prof'];
		$_SESSION['plec'] = $_POST['plec'];
		
		if($_SESSION['nick'] == ""){
			# Zaimplementowanie błędu o nie wpisaniu nicku
			$_SESSION['wpisz_nick'] = "<font color='red'>Wpisz nick postaci</font>";
			# Powrót do postacie.php
			header('Location: '.$_SERVER['HTTP_REFERER']);
		} else {
			# Dodanie postaci do bazy danych
			$new_hero = mysqli_query($conn, "INSERT INTO postacie VALUES (NULL, ".$_SESSION['idmoje'].", '".$_SESSION['nick']."', '".$_SESSION['prof']."', 1000.00, 0, 0, 0, 120, 0, 60, 60, 1)");
			if(!$new_hero){
				# Błąd bazy danych
				echo "Błąd: ".mysqli_error($conn);
			} else{
				header("Location: postacie.php");
			}
		}
	}
	$conn->close();
?>