<?php
require_once __DIR__ . '/config.php';
session_start();
if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::PROFESOR)  {
	?>
<div class="alert alert-danger my-alert">
	Niste autorizovani za pregled ove stranice!!!
</div>
<?php
	die;
}
?>
<a href="kreiraj_ispit.php" class="btn btn-lg btn-success">
	<span class="glyphicon glyphicon-plus"></span> Kreiraj ispit
</a>
<div class="list-group">
<?php
	$ispiti = Ispit::nadjiPoKorisnikId($_SESSION['korisnik_id']);
	if (!empty($ispiti)) {
		foreach ($ispiti as $ispit) {
			$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "kreiraj_ispit.php?ispit_id={$ispit->vratiIspitId()}";
			?>
			<a href="<?php echo $url?>" class="list-group-item"><?php echo $ispit->vratiNazivIspita()?></a>
		<?php
		}
	}
?>
</div>
