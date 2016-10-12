<?php include 'header.php'; ?>
<?php if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::STUDENT): ?>
<div class="alert alert-danger my-alert">
	Morate biti student da bi ste polagali ispite!!!
</div>
<?php
	die;
	endif;
?>
<a href="kreiraj_ispit.php" class="btn btn-lg btn-success">
	<span class="glyphicon glyphicon-plus"></span> Kreiraj ispit
</a>
<div class="list-group">
<?php
	$ispiti = Ispit::nadjiPoKorisnikId($_SESSION['korisnik_id']);
	if (!empty($ispiti)) {
		foreach ($ispiti as $ispit) {
			$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/ispit.php?ispit_id={$ispit->vratiIspitId()}";
			?>
			<a href="<?php echo $url?>" class="list-group-item"><?php echo $ispit->vratiNazivIspita()?></a>
		<?php
		}
	}
?>
</div>
<?php include 'footer.php'; ?>