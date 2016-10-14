<?php include 'header.php'; ?>
<?php if (!isset($_SESSION['tip_korisnika']) || $_SESSION['tip_korisnika'] != Korisnik::PROFESOR): ?>
	<div class="alert alert-danger my-alert">
		Morate biti profesot da bi ste prijavili studente za ispit!!!
	</div>
	<?php
	die;
endif;
?>
<div class="create-exam">
	<div class="header">
		<h3>Prijava studenata za ispit <?php echo $ispit->vratiNazivIspita(); ?></h3>
	</div>
</div>
<form method="post">
	<?php foreach ($studenti as $student) {?>
		<div class="checkbox">
			<label><input type="checkbox" <?php echo in_array($student->vratikorisnikId(), $student_ids) ? 'checked' : '';?>
						  value="<?php echo $student->vratiKorisnikId();?>" name="studenti[]" >
				<?php echo $student->vratiIme() . ' ' . $student->vratiPrezime();?></label>
		</div>
	<?php }?>
	<button class="col-md-12 col-xs-12 btn btn-default btn-success">Prijavi</button>
</form>
<?php include 'footer.php'; ?>