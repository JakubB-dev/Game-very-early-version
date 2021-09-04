<?php
	session_start();
	require_once('conn.php');
	
	$nick = $_POST['nick'];
	$postac = mysqli_query($conn, "SELECT * FROM postacie WHERE nick = '".$nick."'");
	
	while($row = mysqli_fetch_assoc($postac)){
		$_SESSION['id_postaci'] = $row['id'];
		$_SESSION['nick_postaci'] = $row['nick'];
		$_SESSION['id_konta'] = $row['konto_id'];
		$_SESSION['profesja'] = $row['profesja'];
		$_SESSION['kasa'] = $row['money'];
		$_SESSION['lotto'] = $row['lotto_id'];
		$_SESSION['all_exp'] = $row['razem_exp'];
		$_SESSION['aktualny_exp'] = $row['aktualny_exp'];
		$_SESSION['poziom_exp'] = $row['poziom_exp'];
		$_SESSION['EQ'] = $row['ekwipunek'];
		$_SESSION['hp'] = $row['hp'];
		$_SESSION['max_hp'] = $row['max_hp'];
		$_SESSION['lvl'] = $row['lvl'];
	}
	
	header('Location: gra2d.php');