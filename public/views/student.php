<?php include 'header.php'; ?>
<a href="kreiraj_ispit.php" class="col-md-12 btn btn-default btn-success no-float">
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