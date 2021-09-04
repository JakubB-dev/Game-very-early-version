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
	
	# Przekierowanie podczas braku wiadomosci
	if(!isset($_POST['tresc'])){
		header('Location: czat.php');
		exit();
	}
	
	# Pobranie treści wiadomości prywatnej
	$wiadomosc = $_POST['tresc'];
	
	if($wiadomosc == ""){
		# Błąd o próbie wysłania pustej wiadomości
		$_SESSION['wiado'] = "<font color='red'>Nie można wysłać pustej wiadomości</font>";
		header('Location: '.$_SERVER['HTTP_REFERER']);
	} else {
		# Prawidłowe wysłanie wiadomości
		$wyslanie = mysqli_query($conn, "INSERT INTO message VALUES (NULL, '".$wiadomosc."', '".$_SESSION['id_postaci']."', '".$_SESSION['id_kogos']."', current_timestamp(), 0)");
	
		if(!$wyslanie){
			# Błąd bazy danych
			$_SESSION['wiado'] = "<font color='red'>Błąd wysłania wiadomości, spróbuj ponownie później</font>";
			header('Location: '.$_SERVER['HTTP_REFERER']);
		} else {
			# Powiadomienie o prawidłowym wysłaniu wiadomości
			$_SESSION['wiado'] = "<font color='green'>Wiadomość została wysłana!</font>";
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
	}
	$conn->close();
?>