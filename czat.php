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
	
	# Wybranie wszystkich postaci poza aktualnie zalogowaną
	$osoby = mysqli_query($conn, "SELECT postacie.id, mail, nick FROM postacie, konta WHERE postacie.konto_id = konta.id AND postacie.id != ".$_SESSION['id_postaci']."");
	$ilosc_osoby = mysqli_num_rows($osoby);
	
	
	
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
			Gra przeglądarkowa - czat
		</title>
	</head>
	<body>
		<!--<div class="intro">
			<div class="intro-text">
				<h1 class="hide">
					<span class="text">Czat</span>
				</h1>
				<h1 class="hide">
					<span class="text">Prywatny</span>
				</h1>
			</div>
		</div>-->
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
		<div class="content">
			<h2>
				<br>Witaj <i><?php echo $_SESSION['nick_postaci']; ?></i>!
			</h2>
			<br><br>
			<div class="content">
				<br><hr>
				<?php
					$read = mysqli_query($conn, "SELECT od_kogo FROM message WHERE od_kogo != ".$_SESSION['id_konta']." AND do_kogo = ".$_SESSION['id_konta']." AND wyswietlona = 0");
					$ile_wiado = mysqli_num_rows($read);
					
					# Pętla wypisująca wszystkie postacie (nick i mail)
					for($i=1; $i<=$ilosc_osoby; $i++){
						
						$row = mysqli_fetch_assoc($osoby);
						$_SESSION['idkogos'] = $row['id'];
						$_SESSION['nazwa'] = $row['nick'];
						$_SESSION['mail'] = $row['mail'];
						
						
						$color = $_SESSION['nazwa'];
						if($ile_wiado > 0){
							$read_row = mysqli_fetch_assoc($read);
							@$odkogo = $read_row['od_kogo'];
							if($_SESSION['idkogos'] == $odkogo){
								$color = "<font color='red'>".$_SESSION['nazwa']."</font>";
							}
						}
						
						echo 
						"<div class='osoby'>
						<br>
						<b>".$color."</b>
						<br><br>
						".$_SESSION['mail']."<br><br>
						<form action='chat.php' method='GET'>
						<input type='hidden' value='".$_SESSION['nazwa']."' name='nazwa'>
						<input type='hidden' value='".$_SESSION['idkogos']."' name='idkogos'>
						<button class='submit' type='submit'>Otwórz czat</button>
						</form>
						</div>";
					}
				?>
				
			</div>
			<br><br>
		</div>
		</main>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js" integrity= "sha512-IQLehpLoVS4fNzl7IfH8Iowfm5+RiMGtHykgZJl9AWMgqx0AmJ6cRWcB+GaGVtIsnC4voMfm8f2vwtY+6oPjpQ==" crossorigin="anonymous"></script>
		<!--<script src="app.js"></script>-->
	</body>
</html>
<?php
	
?>