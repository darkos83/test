<?php include 'header.php'; ?>
<h3><?php echo $_SESSION['ime'] . ' ' . $_SESSION['prezime']?></h3>

<h4>Prijave:</h4>
<div class="list-group">
<?php
	if (!empty($prijave)) {
		foreach ($prijave as $prijava) {
			$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/polaganje_ispita.php?ispit_id={$prijava->vratiIspitId()}";
			?>
			<a href="<?php echo $url?>" class="list-group-item"><?php echo $prijava->vratiNazivIspita()?></a>
		<?php
		}
	}
?>
</div>
<h4>polagani ispiti:</h4>
<div class="list-group">
	<?php
	$ispiti = Korisnik::nadjiPrijavnjeneIspiteZaStudenta();
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