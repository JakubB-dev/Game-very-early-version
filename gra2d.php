<?php
	session_start();
	require_once('conn.php');
	
	# Przekierowanie podczas braku zalogowania
	if (!isset($_SESSION['zalogowany'])){
		header('Location: login.php');
		exit();
	}
	
	# Przekierowanie podczas braku wybrania postaci
	if(!isset($_SESSION['postac_wybrana'])){
		header('Location: postacie.php');
		exit();
	}
	
	# Wybranie przeciwników uporządkowanych rosnąco według poziomu
	$enemy = mysqli_query($conn, "SELECT nazwa, lvl, min_atak, max_atak, ck_procent, punkty_zdrowia, trudnosc, obraz, doświadczenie FROM przeciwnicy ORDER BY lvl ASC");
	$ile_przeciw = mysqli_num_rows($enemy);
	
	# Dodanie poziomu postaci, jeżeli jest wystarczająco doświadczenia
	if($_SESSION['aktualny_exp'] >= $_SESSION['poziom_exp']){
		# Wyzerowanie aktualnego doświadczenia
		$_SESSION['aktualny_exp'] = 0;
		# Zwiększenie progu doświadczenia do następnego poziomu
		$_SESSION['poziom_exp'] = round(($_SESSION['poziom_exp'] * 2.1), 0);
		$_SESSION['lvl'] = $_SESSION['lvl'] + 1;
		# Zwiększenie maksymalnego zdrowia postaci
		$_SESSION['max_hp'] = round(($_SESSION['max_hp']*1.06), 2);
		# Wyleczenie po zdobyciu poziomu
		$_SESSION['hp'] = $_SESSION['max_hp'];
		
		# Zmiana danych w bazie
		$zmiana = mysqli_query($conn, "UPDATE postacie SET aktualny_exp = 0, poziom_exp = ".$_SESSION['poziom_exp'].", lvl = ".$_SESSION['lvl'].", max_hp = ".$_SESSION['max_hp']." WHERE id = ".$_SESSION['id_postaci']."");
	}
	
	# Długość trwania sesji (po tym czasie bezczynności sesja zostanie zniszczona). Wartość podana w sekundach (aktualnie 15 minut)
	$intTimeoutSeconds = 900;
 
	if(isset($_SESSION['intLastRefreshTime'])){
		# Zniszczenie sesji po upływnie określonego czasu bezczynności
		if(($_SESSION['intLastRefreshTime']+$intTimeoutSeconds)<time()){
			session_destroy();
			session_start();
			header('Location: login.php');
		}
	}
	# Ustalenie czasu ostatniej aktywności
	$_SESSION['intLastRefreshTime'] = time();
	
	# Wybranie wiadomości czatu ogólnego
	$overworld = mysqli_query($conn, "SELECT overworld_chat.id, kto_id, kto_nick, tresc, data, sek_od_wiado FROM overworld_chat ORDER BY data DESC");

	$ilewiado = mysqli_num_rows($overworld);
?>
<!DOCTYPE html>
<html lang="pl-PL">
	<head>
		<link rel="stylesheet" href="css/gra.css">
		<link rel="stylesheet" href="css/nowe.css">
		<link rel="stylesheet" href="css/fontello.css">
		<meta charset="UTF-8">
		<title>
			Gra przeglądarkowa - gra
		</title>
		<!--<style>
			canvas 
			{
				border: 1px solid #d3d3d3;
				background: url(http://syberia.margonem.pl/obrazki/miasta/thuz-ratusz.png) no-repeat;
			}
		</style>!-->
	</head>
	<body>
		<!--<div class="intro">
			<div class="intro-text">
				<h1 class="hide">
					<span class="text">Never</span>
				</h1>
				<h1 class="hide">
					<span class="text">Give</span>
				</h1>
				<h1 class="hide">
					<span class="text">Up</span>
				</h1>
			</div>
		</div>-->
		<div class="slider"></div>
		<main>
		<center>
			<h1 class="title">
				Gra przeglądarkowa - rzeczywistość
			</h1>
			<span class="logout"><a class="logout" href="logout.php">Wyloguj się!</a></span><br>
			<div class="menu">
				<a class="menu" href="konto.php">Zagraj</a>
				<a class="menu" href="czat.php">Czat</a>
			</div>
		</center>
		<button class='nav-button' id='Open' onclick='navTogglerOpen()'>></button><br>
		<button class='nav-button' id='Close' onclick='navTogglerClose()'><</button>
		<nav id='nav'>
			<a href='account.php' class='nav-link'><div class='text'>Konto</div><div class='nav-block'><span class='icon-user fontello'></span></div></a>
			<a href='gra2d.php' class='nav-link'><div class='text'>Gra</div><div class='nav-block'><span class='icon-gamepad fontello'></span></div></a>
			<a href='znajomi.php' class='nav-link'><div class='text'>Społeczność</div><div class='nav-block'><span class='icon-users fontello'></span></div></a>
			<a href='czat.php' class='nav-link'><div class='text'>Czat</div><div class='nav-block'><span class='icon-chat-inv fontello'></span></div></a>
			<a href='settings.php' class='nav-link'><div class='text'>Ustawienia</div><div class='nav-block'><span class='icon-cog-alt fontello'></span></div></a>
		</nav>
		<div class="content" style="height: 660px;">
			
			<div id='chatowanie' style="overflow: auto;">
				<br><h2>Czat ogólny</h2><hr style='border: 0.5px solid black;'>
				<form class="chat" action="wiadomosc_ogolna.php" method="POST">
					<!-- Formularz wysyłania wiadomości !-->
					Napisz wiadomość:
					<textarea class="wysylanie" name="tresc" style='background-color: rgba(105, 90, 120, .3); border-radius: 10px; height: 30px;'></textarea>
					<button class="submit" type="submit">Wyślij</button>
					<br><br>
					<?php
						if(isset($_SESSION['wiado'])){
							# Błąd pustej wiadomości
							echo $_SESSION['wiado'];
							$_SESSION['wiado'] = "";
						}
					?>
					<br>
				</form>
				<?php
					for($i=1; $i<=$ilewiado; $i++){
				
						$row = mysqli_fetch_assoc($overworld);
						$_SESSION['id'] = $row['id'];
						$_SESSION['idkogos'] = $row['kto_id'];
						$_SESSION['nickkogos'] = $row['kto_nick'];
						$_SESSION['tresc'] = $row['tresc'];
						$_SESSION['data'] = $row['data'];
						$_SESSION['sek'] = $row['sek_od_wiado'];
						
						# Usunięcie wiadomości, które mają dłużej niż dzień
						if($_SESSION['sek'] + 86400 <= time()){
							mysqli_query($conn, "DELETE FROM overworld_chat WHERE id = ".$_SESSION['id']."");
						}
						
						# Dodanie odpowiedniej klasy wiadomości
						if($_SESSION['idkogos'] == $_SESSION['id_postaci']){
							# Gdy wiadomość jest od aktualnej postaci dodaj klasę od1
							$class = "od1";
						} else {
							# W przeciwnym wypadku dodaj klasę od2
							$class = "od2";
						}
						
						# Wypisanie wszystkich wiadomości z bazy danych
						echo 
						"<div class='".$class."'>
							<br>
							<div class='tooltiptext'><font size='2' color='black'> ".$_SESSION['data']."</font></div>
							<b> ".$_SESSION['nickkogos']."</b>: ".$_SESSION['tresc']."<br><br>
						</div>";
					}
				?>
			</div>
			
			<div id='left' style="overflow: auto;">
				<h3>Wybierz swojego przeciwnika</h3>
				
				<?php 
					for($i=1; $i<=$ile_przeciw; $i++){
						$wyliczanie = mysqli_fetch_assoc($enemy);
						
						$nazwa = $wyliczanie['nazwa'];
						$lvl_enemy = $wyliczanie['lvl'];
						$_SESSION['min_atak'] = $wyliczanie['min_atak'];
						$_SESSION['max_atak'] = $wyliczanie['max_atak'];
						$punkty_zdrowia = $wyliczanie['punkty_zdrowia'];
						$trudnosc = $wyliczanie['trudnosc'];
						$obraz = $wyliczanie['obraz'];
						$doświadczenie = $wyliczanie['doświadczenie'];
						
						# Wyświetlenie wszystkich dostępnych przeciwników
						echo "
						<div class='enemy'>
							<div class='photo'>
								<img src='Obrazki/Przeciwnicy/przeciwnik".$obraz.".png'>
							</div>
							<h3>".$nazwa." (".$lvl_enemy.")</h3>
							<center>
							Atak:<br><b>".$_SESSION['min_atak']."-".$_SESSION['max_atak']."</b><br><br>
							Punkty zdrowia:<br><b>".$punkty_zdrowia."</b><br><br>
							Doświadczenie za zabicie:<br><b>".$doświadczenie."</b><br><br>
							Poziom trudności:<br><b>".$trudnosc."</b><br><br>
							</center>
							<form action='atakowanie.php' method='POST'>
								<input type='hidden' name='nazwa' value='".$nazwa."'>
								<button type='submit' class='submit'>Zaatakuj</button>
							</form>
						</div> ";
					}
				?>
			</div>
			
			<div id='right' style="overflow: auto;">
				<?php
					# Obliczanie procentu życia z dokładnością do dwóch miejsc po przecinku
					$procent_zycia = round((($_SESSION['hp']) / ($_SESSION['max_hp']))*100, 2);
					
					# Obliczanie procentu doświadczenia z dokładnością do dwóch miejsc po przecinku
					$procent_exp = round((($_SESSION['aktualny_exp']) / ($_SESSION['poziom_exp']))*100, 2);
				
					if($_SESSION['hp'] > $_SESSION['max_hp']){
						# Maksymalne punkty zdrowia kiedy aktualne zdrowie jest większe od maksymalnego
						$_SESSION['hp'] = $_SESSION['max_hp'];
						mysqli_query($conn, "UPDATE konta_gry SET hp = ".$_SESSION['hp']." WHERE id_gracza = ".$_SESSION['id_postaci']."");
					}
					
					# Wyświetlenie inforamcji o aktualnie zalogowanej postaci
					echo 
					"<h3><b>".$_SESSION['nick_postaci']."</b></h3>
					<br><div id='xycoordinates'></div><br>
					Poziom: <br><b>".$_SESSION['lvl']."</b>
					<br><br>
					Doświadczenie: <br><b>".$procent_exp."%</b><br><div class='pasek tooltip'><span class='tooltiptext'><b>".$_SESSION['aktualny_exp']."</b> / <b>".$_SESSION['poziom_exp']."</b></span><div class='exp' style='width: ". $procent_exp*2 ."px;'></div></div><br>
					<br>
					Punkty zdrowia: <br><b>".$procent_zycia."%</b><br><div class='pasek tooltip'><span class='tooltiptext'><b>".$_SESSION['hp']."</b> / <b>".$_SESSION['max_hp']."</b></span><div class='zycie' style='width: ". $procent_zycia*2 ."px;'></div></div><br>";
				?>
				<br><br>
				<a href="hp.php"><button>Wylecz się</button></a>
				<br><br><br>
				<!--
				Ekwipunek - niedostępne
				<div class="EQ">
					<div class='slot tooltip'>
						<?php
							$item = mysqli_query($conn, "SELECT konsumpcyjne.nazwa, opis, leczenie_punkt FROM konsumpcyjne");
							
							while($row = mysqli_fetch_array($item)){
								$nazwa = $row[0];
								$opis = $row[1];
								$leczenie = $row[2];
							}
							
							echo "<img src='bronie/5.png' width='10px'><div class='tooltiptext item_tip'><b>".$nazwa."</b><br><i>".$opis."</i><br>Leczy: <b>".$leczenie."</b> punktów zdrowia<br></div><button type='submit' class='submit'>Użyj</button>";
						?>
					</div>
				</div>
				!-->
			</div>
		</div>
		</main>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js" integrity= "sha512-IQLehpLoVS4fNzl7IfH8Iowfm5+RiMGtHykgZJl9AWMgqx0AmJ6cRWcB+GaGVtIsnC4voMfm8f2vwtY+6oPjpQ==" crossorigin="anonymous"></script>
		
		<script type='text/javascript'>
			function navTogglerOpen(){
				var uchwyt1 = document.getElementById('nav');
				var uchwyt2 = document.getElementById('Close');
				var uchwyt3 = document.getElementById('Open');
				uchwyt1.style.left = "0px";
				uchwyt2.style.display = "block";
				uchwyt3.style.display = "none";
			}
			
			function navTogglerClose(){
				var uchwyt1 = document.getElementById('nav');
				var uchwyt2 = document.getElementById('Close');
				var uchwyt3 = document.getElementById('Open');
				uchwyt1.style.left = "-75px";
				uchwyt2.style.display = "none";
				uchwyt3.style.display = "block";
			}
		</script>
	</body>
</html>