<?php
	session_start();
	require_once("conn.php");
	
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: login.php');
		exit();
	}
	
	if(!$conn){
		echo "Błąd: ".mysqli_error($conn);
	} else {
		$login = $_POST['login'];
		$haslo = sha1($_POST['haslo']);
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
		
		$isORnot = mysqli_query($conn, "SELECT konta.id, login, haslo, money, mail, lvl, exp, hp, max_hp, max_exp FROM konta, konta_gry WHERE (konta.id = konta_gry.id_gracza) AND (login = '".$login."' AND haslo = '".$haslo."')");
			
		if((mysqli_num_rows($isORnot)) > 0){
			$_SESSION['zalogowany'] = true;
			
			while($row = mysqli_fetch_array($isORnot)){
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
			$isORnot->free_result();
			header('Location: postacie.php');
			
		} else {
			
			$_SESSION['błąd_login'] = "<span style='color: red;'>Niepoprawne dane logowania!</span>";
			header('Location: login.php');
			
		}
		
	}
	
	$conn->close();
?>