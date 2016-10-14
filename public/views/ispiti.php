<?php include 'header.php'; ?>
<div class="create-exam">
	<div class="header">
		<h3>Kreiranje ispita</h3>
		<p>Popuniti pitanja, ponudjene odgovore i izabrati tačan odgovor</p>
	</div>
	<form method="post">
		<ol>
			<?php for ($i=0; $i < $ispit->vratiBrojPitanja(); $i++) : ?>
				<?php $br = $i +1; $tacan_odgovor = isset($pitanja_i_odgovori["tacan_odgovor_{$br}"]) ? $pitanja_i_odgovori["tacan_odgovor_{$br}"] : 0; ?>
			<li><input type="text" name="pitanje_<?php echo $i + 1 ?>" class="form-control" placeholder="Pitanje <?php echo $i + 1; ?>"
					<?php echo isset($pitanja_i_odgovori["pitanje_{$br}"]) ? 'value="'. $pitanja_i_odgovori["pitanje_{$br}"] . '"': ''?> >
				<ul>
					<li>
						<div class="radio">
							<input type="radio" <?php echo $tacan_odgovor == 0 ? 'checked' : ''; ?> name="tacan_odgovor_<?php echo $i + 1 ?>" value="0">
							<input type="text" class="form-control" name="odgovor_<?php echo $i + 1 ?>[]" placeholder="Odgovor a"
							<?php echo isset($pitanja_i_odgovori["odgovori_{$br}"][0]) ? 'value="'. $pitanja_i_odgovori["odgovori_{$br}"][0] . '"': ''?> >
						</div>
					</li>
					<li>
						<div class="radio">
							<input type="radio" <?php echo $tacan_odgovor == 1 ? 'checked' : ''; ?> name="tacan_odgovor_<?php echo $i + 1 ?>" value="1">
							<input type="text" class="form-control" name="odgovor_<?php echo $i + 1 ?>[]" placeholder="Odgovor b"
							<?php echo isset($pitanja_i_odgovori["odgovori_{$br}"][1]) ? 'value="'. $pitanja_i_odgovori["odgovori_{$br}"][1] . '"': ''?> >
						</div>
					</li>
					<li>
						<div class="radio">
							<input type="radio" <?php echo $tacan_odgovor == 2 ? 'checked' : ''; ?> name="tacan_odgovor_<?php echo $i + 1 ?>" value="2">
							<input type="text" class="form-control" name="odgovor_<?php echo $i + 1 ?>[]" placeholder="Odgovor c"
							<?php echo isset($pitanja_i_odgovori["odgovori_{$br}"][2]) ? 'value="'. $pitanja_i_odgovori["odgovori_{$br}"][2] . '"': ''?> >
						</div>
					</li>
				</ul>
			</li>
			<?php endfor; ?>
		</ol>
		<button class="col-md-12 col-xs-12 btn btn-default btn-success">Kreiraj</button>
	</form>	
</div>
<?php include 'footer.php'; ?>