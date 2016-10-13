<?php include 'header.php'; ?>
	<?php if (empty($upozorenja)) : ?>
	<div class="create-exam">
		<div class="header">
			<h3>Polaganje ispita iz <?php echo $ispit->vratiNazivIspita();?></h3>
		</div>
		<form method="post">
			<ul>
				<?php for ($i=0; $i < $ispit->vratiBrojPitanja(); $i++) : ?>
					<?php $br = $i +1; $tacan_odgovor = isset($pitanja_i_odgovori["tacan_odgovor_{$br}"]) ? $pitanja_i_odgovori["tacan_odgovor_{$br}"] : 0; ?>
					<li><p name="pitanje_<?php echo $i + 1 ?>" class="form-control">
							<?php echo isset($pitanja_i_odgovori["pitanje_{$br}"]) ?  $pitanja_i_odgovori["pitanje_{$br}"] : ''?>
						</p>
						<ul>
							<li>
								<div class="radio">
									<input type="radio" name="tacan_odgovor_<?php echo $i + 1 ?>" value="0">
									<p class="form-control" name="odgovor_<?php echo $i + 1 ?>[]">
										<?php echo isset($pitanja_i_odgovori["odgovori_{$br}"][0]) ? $pitanja_i_odgovori["odgovori_{$br}"][0] : ''?>
									</p>
								</div>
							</li>
							<li>
								<div class="radio">
									<input type="radio"  name="tacan_odgovor_<?php echo $i + 1 ?>" value="1">
									<p class="form-control" name="odgovor_<?php echo $i + 1 ?>[]">
										<?php echo isset($pitanja_i_odgovori["odgovori_{$br}"][1]) ? $pitanja_i_odgovori["odgovori_{$br}"][1] : ''?>
									</p>
								</div>
							</li>
							<li>
								<div class="radio">
									<input type="radio"  name="tacan_odgovor_<?php echo $i + 1 ?>" value="2">
									<p class="form-control" name="odgovor_<?php echo $i + 1 ?>[]">
										<?php echo isset($pitanja_i_odgovori["odgovori_{$br}"][2]) ? $pitanja_i_odgovori["odgovori_{$br}"][2] : ''?>
									</p>
								</div>
							</li>
						</ul>
					</li>
				<?php endfor; ?>
			</ul>
			<button class="col-md-12 col-xs-12 btn btn-default btn-success">Polazi</button>
		</form>
	</div>
	<?php endif;?>
<?php include 'footer.php'; ?>