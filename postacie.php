<?php
	session_start();
	require_once('conn.php');
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == false)){
		header('Location: login.php');
		exit();
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
?>
<!DOCTYPE html>
<html lang="pl-PL">
	<head>
		<link rel="stylesheet" href="css/gra.css">
		<meta charset="UTF-8">
		<title>
			Gra przeglądarkowa - postacie
		</title>
		<style>
			button
			{
				position: relative;
				animation: mymove 10s infinite;
			}

			@keyframes mymove
			{
				25%
				{
					box-shadow: 2px 2px 0 0 olive;
				}
				
				50%
				{
					box-shadow: none;
				}
				
				75%
				{
					box-shadow: 2px 2px 0 0 olive;
				}
				
				100%
				{
					box-shadow: none;
				}
			}
		</style>
	</head>
	<body>
		<div class="intro">
			<div class="intro-text">
				<h1 class="hide">
					<span class="text">Wybierz</span>
				</h1>
				<h1 class="hide">
					<span class="text">Postać</span>
				</h1>
			</div>
		</div>
		<main>
		<center>
			<h1 class="title">
				Gra przeglądarkowa - rzeczywistość
			</h1>
			<span class="logout"><a class="logout" href="logout.php">Wyloguj się!</a></span><br>
		</center>
		
		<div class="l_r">
			<h2>Wybierz postać</h2><br>
			<?php
				# Wypisanie błędu - nie wpisanie nicku w formularzu dodania postaci
				if(isset($_SESSION['wpisz_nick'])){
					echo $_SESSION['wpisz_nick']."<br>";
				}
				
				# Wybranie z bazy wszystkich postaci aktualnego konta
				$postacie = mysqli_query($conn, "SELECT * FROM postacie WHERE konto_id = ".$_SESSION['idmoje']." ORDER BY lvl DESC");
				# Ilość postaci dla danego konta
				$ile = mysqli_num_rows($postacie);
				
				for($i = 0; $i < $ile; $i++){
					$row = mysqli_fetch_assoc($postacie);
					$nick = $row['nick'];
					$lvl = $row['lvl'];
					$prof = $row['profesja'];
					
					# Wypisanie wszystkich postaci aktualnego konta
					echo "
					<div class='postac'>
						Nick: <br><b>".$nick."</b><br>
						Lvl: <br><b>".$lvl."</b><br>
						<form method='POST'>
							<input type='hidden' value='".$nick."' name='nick'>
							<button class='enter' type='submit' type='submit'>Wejdź do gry</button>
						</form>
						<img class='profesja' src='profesje/".$prof.".png'>
					</div>";
				}
				
				# Jeżeli wybrana została postać...
				if(isset($_POST['nick'])){
					$_SESSION['postac_wybrana'] = true;
					# Pobranie nicku wybranej postaci
					$nick = $_POST['nick'];
					$postac = mysqli_query($conn, "SELECT * FROM postacie WHERE nick = '".$nick."'");
					
					while($row = mysqli_fetch_assoc($postac)){
						# Pobranie z bazy danych informacji o wybranej postaci
						$_SESSION['id_postaci'] = $row['id'];
						$_SESSION['nick_postaci'] = $row['nick'];
						$_SESSION['id_konta'] = $row['konto_id'];
						$_SESSION['profesja'] = $row['profesja'];
						$_SESSION['kasa'] = $row['money'];
						$_SESSION['losowania'] = $row['liczba_losowan'];
						$_SESSION['wygrane'] = $row['liczba_wygranych'];
						$_SESSION['all_exp'] = $row['razem_exp'];
						$_SESSION['aktualny_exp'] = $row['aktualny_exp'];
						$_SESSION['poziom_exp'] = $row['poziom_exp'];
						$_SESSION['EQ'] = $row['ekwipunek'];
						$_SESSION['hp'] = $row['hp'];
						$_SESSION['max_hp'] = $row['max_hp'];
						$_SESSION['lvl'] = $row['lvl'];
					}
					# Przekierowanie do gry
					header('Location: gra2d.php');
				}
			?>
			<br>
			
			<!-- Otwarcie formularza dodania postaci !-->
			<div class="new_postac tooltip" onclick='openAdd()'>
				+
				<span class='tooltiptext'>Dodaj nową postać</span>
			</div>
			
			<!-- Formularz dodania postaci !-->
			<div id='hero_add'>
				<div class='close_x' onclick='closeAdd()'>X</div>
				<form class='form' action='postac_add.php' method='POST'>
					<h2>TWORZENIE POSTACI</h2>
					<br><br>
					
					<!-- Nick postaci !-->
					<label>
						Nick postaci:<br>
						<input type='text' name='nick' class='green'>
						<br>
						<?php
							# Wypisanie błędu - nie wpisanie nicku w formularzu dodania postaci
							if(isset($_SESSION['wpisz_nick'])){
								echo $_SESSION['wpisz_nick'];
								$_SESSION['wpisz_nick'] = "";
							}
						?>
					</label>
					<br><br><br>
					
					<!-- Wybór płci postaci !-->
					Płeć:<br>
					<label>
						M
						<input type='radio' name='plec' value='m' checked='checked'>
					</label><br>
					<label>
						K
						<input type='radio' name='plec' value='k'>
					</label>
					<br><br><br>
					
					<!-- Wybór profesji !-->
					<div class='profesje'>
						Profesja:<br>
						<div class='profesja'>
							Mag<br>
							<label class='prof'>
								<input class='prof' type='radio' name='prof' value='Mag' checked='checked'><br>
								<img class='profesja' src='profesje/mag.png'>
							</label>
						</div>
						
						<div class='profesja'>
							Łucznik<br>
							<label class='prof'>
								<input class='prof' type='radio' name='prof' value='Łucznik'><br>
								<img class='profesja' src='profesje/lucznik.png'>
							</label>
						</div>
						<br>
						<div class='profesja'>
							Paladyn<br>
							<label class='prof'>
								<input class='prof' type='radio' name='prof' value='Paladyn'><br>
								<img class='profesja' src='profesje/paladyn.png'>
							</label>
						</div>
						
						<div class='profesja'>
							Wojownik<br>
							<label class='prof'>
								<input class='prof' type='radio' name='prof' value='Wojownik'><br>
								<img class='profesja' src='profesje/wojownik.png'>
							</label>
						</div>
					</div>
					<button type='submit'>Stwórz postać</button>
				</form>
			</div>
		</div>
		</main>
		<script type='text/javascript'>
			// Otwarcie okienka
			function openAdd(){
				var uchwyt = document.getElementById('hero_add');
				uchwyt.style.display = "block";
			}
			
			// Zamknięcie okienka
			function closeAdd(){
				var uchwyt = document.getElementById('hero_add');
				uchwyt.style.display = "none";
			}
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js" integrity= "sha512-IQLehpLoVS4fNzl7IfH8Iowfm5+RiMGtHykgZJl9AWMgqx0AmJ6cRWcB+GaGVtIsnC4voMfm8f2vwtY+6oPjpQ==" crossorigin="anonymous"></script>
		<script src="app.js"></script>
	</body>
</html>