<?php
	session_start();
	require_once('conn.php');
	
	# Przekierowanie podczas braku wybrania postaci
	if(!isset($_SESSION['postac_wybrana'])){
		header('Location: postacie.php');
		exit();
	}
	
	# Przekierowanie podczas braku wybrania przeciwnika
	if(!isset($_POST['nazwa'])){
		header('Location: gra2d.php');
		exit();
	}

	# Pobranie nazwy przeciwnika
	$nazwa = $_POST['nazwa'];
	
	$przeciwnik = mysqli_query($conn, "SELECT * FROM przeciwnicy WHERE nazwa = '".$nazwa."'");
	
	while($row = mysqli_fetch_assoc($przeciwnik)){
		# Wybranie informacji o przeciwniku z bazy
		$id = $row['id'];
		$nazwa = $row['nazwa'];
		$lvl_enemy = $row['lvl'];
		$_SESSION['min_atak'] = $row['min_atak'];
		$_SESSION['max_atak'] = $row['max_atak'];
		$_SESSION['kryt'] = $row['ck_procent'];
		$punkty_zdrowia = $row['punkty_zdrowia'];
		$trudnosc = $row['trudnosc'];
		$obraz = $row['obraz'];
		$doświadczenie = $row['doświadczenie'];
	}
	
	if($_SESSION['hp'] <= 0){
		# Jeżeli życie jest nie większe niż 0
		echo "Za mało punktów zdrowia";
	} else {
		echo "<a href='gra2d.php'><button>Wróć</button></a><br><br><br>";
		
		# Dopóki czyjeś punkty zdrowia nie będą mniejsze od 0
		while(($_SESSION['hp'] > 0) || ($punkty_zdrowia > 0)){
			
			# Losowanie ciosu krytycznego
			$krytyk = round(100 / $_SESSION['kryt'], 1);
			$random = rand(10, $krytyk*10)/10;
			echo $random." / ".$krytyk."<br>";
			
			# Obrażenia zadawane przez przeciwnika
			$obrazenia_p = (rand(($_SESSION['min_atak']*10), ($_SESSION['max_atak'])*10)/10);
			
			# Wykonanie ciosu krytycznego
			if($random == $krytyk){
				$obrazenia_p = $obrazenia_p*(($_SESSION['kryt']/100)+1);
				$kryt = "(<font color='red'>cios krytyczny</font>)";
			} else {
				$kryt = "";
			}
			
			# Obrażenia zadawane przez gracza
			$obrazenia_m = rand(18, 20*10)/10;
			
			$punkty_zdrowia = $punkty_zdrowia - $obrazenia_m;
			$_SESSION['hp'] = $_SESSION['hp'] - $obrazenia_p;
			
			echo "
			Przeciwnik zadaje: <b>".$obrazenia_p."</b> obrażeń ".$kryt."<br>
			Zadajesz: <b>".$obrazenia_m."</b> obrażeń<br><br>
			Twoje HP: <b>".$_SESSION['hp']."</b><br>
			HP przeciwnika: <b>".$punkty_zdrowia."</b><br><br><br>";
			
			# Zatrzymanie pętli gdy poziom zdrowia spadnie do 0
			if($_SESSION['hp'] <= 0 || $punkty_zdrowia <= 0){
				break;
			}
		}
		
		if($_SESSION['hp'] <= 0){
			$_SESSION['hp'] = 0;
			echo "Przegrałeś!";
		} else {
			$_SESSION['aktualny_exp'] = $_SESSION['aktualny_exp'] + $doświadczenie;
			echo "Wygrałeś! Zdobywasz ".$doświadczenie." punktów doświadczenia";
			
			# Zmiana wartości w bazie
			mysqli_query($conn, "UPDATE postacie SET razem_exp = razem_exp + ".$doświadczenie.", aktualny_exp = aktualny_exp + ".$doświadczenie." WHERE id = ".$_SESSION['id_postaci']."");
		}
		# Aktualizacja punktów zdrowia
		mysqli_query($conn, "UPDATE postacie SET hp = ".$_SESSION['hp']." WHERE id = ".$_SESSION['id_postaci']."");
	}
	$conn->close();
?>