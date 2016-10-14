<?php include 'header.php'; ?>
<h3><?php echo $_SESSION['ime'] . ' ' . $_SESSION['prezime']?></h3>
<h4>Ispiti za polaganje:</h4>
<div class="list-group">
<?php
	if (!empty($prijave)) {
		foreach ($prijave as $prijava) {
			$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/polaganje_ispita.php?ispit_id={$prijava->vratiIspitId()}";
			?>
			<a href="<?php echo $url?>" class="list-group-item"><?php echo $prijava->vratiNazivIspita()?></a>
		<?php
		}
	} else {
		?>
			<p class="bg-info">Nema prijavljenih ispita</p>
		<?php
	}
?>
</div>

<h4>Završeni ispiti:</h4>
<div class="container">
	<?php
	if (!empty($polaganje)) {
		?>
		<div class="row" >
			<div class="col-lg-4">Naziv ispita</div>
			<div class="col-lg-4">Broj pitanja</div>
			<div class="col-lg-4">Rezultat</div>
		</div>
		<?php
		foreach ($polaganje as $ispit) {
			?>
			<div class="row <?php echo $ispit->vratiRezultat() >= 50 ? 'alert-success' : 'alert-danger';?>">
				<div class="col-lg-4"><?php echo $ispit->vratiNazivIspita();?></div>
				<div class="col-lg-4"><?php echo $ispit->vratiBrojPitanja();?></div>
				<div class="col-lg-4"><?php echo $ispit->vratiRezultat();?></div>
			</div>
			<?php
		}
	} else {
		?>
		<p class="bg-info">Nema završenih ispita</p>
		<?php
	}
	?>
</div>
<?php include 'footer.php'; ?>