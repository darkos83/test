<?php include 'header.php'; ?>
<a href="kreiraj_ispit.php" class="col-md-12 col-xs-12 btn btn-default btn-success no-float">
	<span class="glyphicon glyphicon-plus"></span> Kreiraj ispit
</a>
<div class="list-group">
<?php
	if (!empty($ispiti)) {
		foreach ($ispiti as $ispit) {
			$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
			?>
			<a href="<?php echo $url . "/ispit.php?ispit_id={$ispit->vratiIspitId()}"; ?>" class="list-group-item col-md-8"><?php echo $ispit->vratiNazivIspita()?></a>
			<a href="<?php echo $url . "/prijava_studenata.php?ispit_id={$ispit->vratiIspitId()}";  ?>" class="list-group-item col-md-4">Prijavi studente</a>
		<?php
		}
	}
?>
</div>
<?php include 'footer.php'; ?>