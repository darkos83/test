<?php include 'header.php'; ?>
<div class="create-exam">
	<div class="header">
		<h3>Kreiranje ispita</h3>
		<p>Popuniti pitanja, ponudjene odgovore i izabrati tačan odgovor</p>
	</div>
	<form method="post">
		<ul>
			<?php for ($i=0; $i < $ispit->vratiBrojPitanja(); $i++) : ?>
			<li><input type="text" name="pitanje_<?php echo $i + 1 ?>" class="form-control" placeholder="Pitanje <?php echo $i + 1; ?>">
				<ul>
					<li>
						<div class="radio">
							<input type="radio" checked name="tacan_odgovor_<?php echo $i + 1 ?>" value="0">
							<input type="text" class="form-control" name="odgovor_<?php echo $i + 1 ?>[]" placeholder="Odgovor a">
						</div>
					</li>
					<li>
						<div class="radio">
							<input type="radio" name="tacan_odgovor_<?php echo $i + 1 ?>" value="1">
							<input type="text" class="form-control" name="odgovor_<?php echo $i + 1 ?>[]" placeholder="Odgovor b">
						</div>
					</li>
					<li>
						<div class="radio">
							<input type="radio" name="tacan_odgovor_<?php echo $i + 1 ?>" value="2">
							<input type="text" class="form-control" name="odgovor_<?php echo $i + 1 ?>[]" placeholder="Odgovor c">
						</div>
					</li>
				</ul>
			</li>
			<?php endfor; ?>
		</ul>
		<button class="col-md-12 col-xs-12 btn btn-default btn-success">Kreiraj</button>
	</form>	
</div>
<?php include 'footer.php'; ?>