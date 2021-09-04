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
	
	# Przekierowanie podczas braku wybrania postaci
	if(!isset($_POST['tresc'])){
		header('Location: gra2d.php');
		exit();
	}
	
	# Pobranie wiadomości
	$wiadomosc = $_POST['tresc'];
	
	if($wiadomosc == ""){
		# Błąd, jeśli wiadomość jest pusta
		$_SESSION['wiado'] = "<font color='red'>Nie można wysłać pustej wiadomości</font>";
		header('Location: '.$_SERVER['HTTP_REFERER']);
	} else {
		# Wysłanie zapytania dodającego wiadomość do bazy
		$wyslanie = mysqli_query($conn, "INSERT INTO overworld_chat VALUES (NULL, '".$_SESSION['id_postaci']."', '".$_SESSION['nick_postaci']."', '".$wiadomosc."', current_timestamp(), ".time().")");
	
		if(!$wyslanie){
			# Błąd bazy danych
			$_SESSION['wiado'] = "<font color='red'>Błąd wysłania wiadomości, spróbuj ponownie później</font>";
			header('Location: '.$_SERVER['HTTP_REFERER']);
		} else {
			# Powiadomienie o wysłaniu wiadomości
			$_SESSION['wiado'] = "<font color='green'>Wiadomość została wysłana!</font>";
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
	}
	$conn->close();
?>