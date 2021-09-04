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

	$_SESSION['hp'] = $_SESSION['max_hp'];
	mysqli_query($conn, "UPDATE postacie SET hp = ".$_SESSION['hp']." WHERE id = ".$_SESSION['id_postaci']."");
	header('Location: '.$_SERVER['HTTP_REFERER']);
?>