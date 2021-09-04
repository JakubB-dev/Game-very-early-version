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
	
	# Jeżeli nie została wybrana osoba do czatu
	if(!isset($_GET['nazwa'])){
		header('Location: czat.php');
		exit();
	}
	
	# Pobranie nazwy osoby do czatu
	$nazwa = $_GET['nazwa'];
	$_SESSION['id_kogos'] = $_GET['idkogos'];
	
	$odkogo = mysqli_query($conn, "SELECT postacie.id, nick, tresc, data FROM postacie, message WHERE ((od_kogo = ".$_SESSION['id_postaci']." AND do_kogo = ".$_SESSION['id_kogos'].") OR (od_kogo = ".$_SESSION['id_kogos']." AND do_kogo = ".$_SESSION['id_postaci'].")) ORDER BY data DESC");
	
	$ilewiado = mysqli_num_rows($odkogo);
	
	$read = mysqli_query($conn, "SELECT id FROM message WHERE od_kogo != ".$_SESSION['id_postaci']." AND do_kogo = ".$_SESSION['id_postaci']." AND wyswietlona = 0");
	
	while($read_row = mysqli_fetch_array($read)){
		$id_niewys = $read_row[0];
		$przeczytana_wiado = mysqli_query($conn, "UPDATE message SET wyswietlona = 1 WHERE id = ".$id_niewys."");
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
			Gra przeglądarkowa - czat
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
				<br>Czat z <i><?php echo $nazwa; ?></i>
			</h2>
			<br><br>
			<div class="czat">
				<form class="chat" action="wiadomosc.php" method="POST">
					<label class="wysylanie">
						Napisz wiadomość:<br>
						<textarea class="wysylanie" name="tresc"></textarea>
					</label>
					<button class="submit" type="submit">Wyślij</button>
					<br><br>
					<?php
						if(isset($_SESSION['wiado'])){
							echo $_SESSION['wiado'];
							$_SESSION['wiado'] = "";
						}
					?>
					<br>
				</form>
				<br><hr>
				<?php
					for($i=1; $i<=$ilewiado; $i++){
				
						$row = mysqli_fetch_assoc($odkogo);
						$_SESSION['idkogos'] = $row['id'];
						$_SESSION['odkogo'] = $row['nick'];
						$_SESSION['tresc'] = $row['tresc'];
						$_SESSION['data'] = $row['data'];
						
						echo 
						"<div class='messa'>
						<br>
						<b>".$_SESSION['odkogo']."</b><font size='2'> ".$_SESSION['data']."</font>
						<br><br>
						".$_SESSION['tresc']."<br><br>
						</div>";
					}
				?>
			</div>
			<br><br>
		</div>
	</body>
</html>