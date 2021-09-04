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
	
	$istn = ((isset($_SESSION['choose_user']) && isset($_SESSION['choose_random'])) && ($_SESSION['money'] >= 8));
	
	
	
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
			Gra przeglądarkowa - konto
		</title>
	</head>
	<body>
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
		<div class="content">
			<h2>
				Witaj <i><?php echo $_SESSION['login']; ?></i>!<br>
				Twój portfel: <?php echo $_SESSION['money']; ?> zł
			</h2>
			<center>
				<h3><b><?php if($istn) echo "<hr>Twój ostatni typ: ".$_SESSION['choose_user'] ?></b></h3>
				<h3><b><?php if($istn) echo "Ostatnio wylosowana liczba: ".$_SESSION['choose_random']."<hr>" ?></b></h3><br>
				<h2>
					<font color="green";>
						<?php
							if((isset($_SESSION['choose_user']) && isset($_SESSION['choose_random'])) && $_SESSION['choose_user'] == $_SESSION['choose_random']){
								echo "Gratuluje! Do Twojego konta zostało dodane 3000 zł";
							}
						?>
					</font>
				</h2>
			</center><br>
			<form class="game" action="game.php" method="post">
				<h2>Wytypuj swoją liczbę</h2><br><br>
				<div>
				<label class="number">1<input type="radio" value="1" name="game"></label>
				<label class="number">2<input type="radio" value="2" name="game"></label>
				<label class="number">3<input type="radio" value="3" name="game"></label>
				<label class="number">4<input type="radio" value="4" name="game"></label>
				<label class="number">5<input type="radio" value="5" name="game"></label>
				<label class="number">6<input type="radio" value="6" name="game"></label>
				<label class="number">7<input type="radio" value="7" name="game"></label>
				<label class="number">8<input type="radio" value="8" name="game"></label>
				<label class="number">9<input type="radio" value="9" name="game"></label>
				<label class="number">10<input type="radio" value="10" name="game"></label>
				</div>
				<br>
				<div>
				<label class="number">11<input type="radio" value="11" name="game"></label>
				<label class="number">12<input type="radio" value="12" name="game"></label>
				<label class="number">13<input type="radio" value="13" name="game"></label>
				<label class="number">14<input type="radio" value="14" name="game"></label>
				<label class="number">15<input type="radio" value="15" name="game"></label>
				<label class="number">16<input type="radio" value="16" name="game"></label>
				<label class="number">17<input type="radio" value="17" name="game"></label>
				<label class="number">18<input type="radio" value="18" name="game"></label>
				<label class="number">19<input type="radio" value="19" name="game"></label>
				<label class="number">20<input type="radio" value="20" name="game"></label>
				</div>
				<br>
				<div>
				<label class="number">21<input type="radio" value="21" name="game"></label>
				<label class="number">22<input type="radio" value="22" name="game"></label>
				<label class="number">23<input type="radio" value="23" name="game"></label>
				<label class="number">24<input type="radio" value="24" name="game"></label>
				<label class="number">25<input type="radio" value="25" name="game"></label>
				<label class="number">26<input type="radio" value="26" name="game"></label>
				<label class="number">27<input type="radio" value="27" name="game"></label>
				<label class="number">28<input type="radio" value="28" name="game"></label>
				<label class="number">29<input type="radio" value="29" name="game"></label>
				<label class="number">30<input type="radio" value="30" name="game"></label>
				</div>
				<br>
				<div>
				<label class="number">31<input type="radio" value="31" name="game"></label>
				<label class="number">32<input type="radio" value="32" name="game"></label>
				<label class="number">33<input type="radio" value="33" name="game"></label>
				<label class="number">34<input type="radio" value="34" name="game"></label>
				<label class="number">35<input type="radio" value="35" name="game"></label>
				<label class="number">36<input type="radio" value="36" name="game"></label>
				<label class="number">37<input type="radio" value="37" name="game"></label>
				<label class="number">38<input type="radio" value="38" name="game"></label>
				<label class="number">39<input type="radio" value="39" name="game"></label>
				<label class="number">40<input type="radio" value="40" name="game"></label>
				</div>
				<br>
				<div>
				<label class="number">41<input type="radio" value="41" name="game"></label>
				<label class="number">42<input type="radio" value="42" name="game"></label>
				<label class="number">43<input type="radio" value="43" name="game"></label>
				<label class="number">44<input type="radio" value="44" name="game"></label>
				<label class="number">45<input type="radio" value="45" name="game"></label>
				<label class="number">46<input type="radio" value="46" name="game"></label>
				<label class="number">47<input type="radio" value="47" name="game"></label>
				<label class="number">48<input type="radio" value="48" name="game"></label>
				<label class="number">49<input type="radio" value="49" name="game"></label>
				<label class="number">50<input type="radio" value="50" name="game"></label>
				</div>
				<br><br>
				<button class="submit" type="submit" name="submit">Wyślij swój typ</button>
				<br>(Koszt 8 zł)<br><br>
				<font color="red">
				<?php
					if(isset($_SESSION['błąd'])){
						echo $_SESSION['błąd'];
						$_SESSION['błąd'] = "";
					}
				?>
				</font>
			</form>
			<div class="liczba">
				<center>
					<h4>Liczba gier: <?php echo $_SESSION['losowania'] ?></h4>
					<h4>Gry wygrane: <?php echo $_SESSION['wygrane'] ?></h4>
				</center>
			</div>
		</div>
	</body>
</html>