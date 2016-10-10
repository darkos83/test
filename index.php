<?php

require_once __DIR__ . '/config.php';
session_start();
if (isset($_SESSION['korisnik_id'])) {
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	if (!isset($_SESSION['tip_korisnika'])) {
		$korisnik = Korisnik::nadjiPoId($_SESSION['korisnik_id']);
		if (empty($korisnik)) {
			session_start();
			session_destroy();
			header("Location: {$url}index.php");
		}
		$_SESSION['tip_korisnika'] = $korisnik->vratiTipKorisnika();
	}
	if (Korisnik::PROFESOR == $_SESSION['tip_korisnika']) {
		header("Location: {$url}profesor.php");
	}
	if (Korisnik::STUDENT == $_SESSION['tip_korisnika']) {
		header("Location: {$url}student.php");
	}
}
if (isset($_REQUEST['korisnicko_ime'])) {
	echo json_encode(array('greska' => 1, 'poruka' => 'Korisnicko ime je prazno!'));
	exit;
}
if (isset($_REQUEST['sifra'])) {
	echo json_encode(array('greska' => 1, 'poruka' => 'Sifra je prazna!'));
	exit;
}

$korisnik = Korisnik::nadjiPoKorisnickomImenuISifri($_REQUEST['korisnicko_ime'], $_REQUEST['sifra']);

if (empty($korisnik)) {
	echo json_encode(array('greska' => 1, 'poruka' => 'Neispravni podaci za logovanje!'));
	exit;
}

$_SESSION['korisnik_id'] = $korisnik->vratiKorisnikId();
$_SESSION['tip_korisnika'] = $korisnik->vratiTipKorisnika();
$_SESSION['ime'] = $korisnik->vratiIme();
$_SESSION['prezime'] = $korisnik->vratiPrezime();


$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
if (Korisnik::PROFESOR == $korisnik->vratiTipKorisnika()) {
	header('Location: ' . $url . 'profesor.php');
	exit;
}
if (Korisnik::STUDENT == $korisnik->vratiTipKorisnika()) {
	header('Location: ' . $url . 'student.php');
	exit;
}
?>
<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Testovi</title>

	<link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="public/css/style.css">

	<script src="public/js/jquery-3.1.1.min.js"></script>
	<script src="public/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container-fluid">
		<div class="login-form">
			<form>
				<div class="form-group">
				<label for="exampleInputEmail1">Korisničko ime</label>
					<input type="email" name="korisnicko_ime" class="form-control" placeholder="Korisničko ime">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Sifra</label>
					<input type="password" name="sifra" class="form-control" placeholder="Sifra">
				</div>
				<button type="submit" class="col-md-12 btn btn-default btn-info">Uloguj se</button>
			</form>
		</div>
	</div>
</body>
<!--<script src="public/js/login.js"></script>-->
</html>