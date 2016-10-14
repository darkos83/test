<?php include 'header.php'; ?>
	<div class="create-exam">
		<div class="header">
			<h3>Polaganje ispita iz <?php echo $ispit->vratiNazivIspita();?></h3>
		</div>
		<form method="post" action="">
			<ol>
				<?php for ($i=0; $i < $ispit->vratiBrojPitanja(); $i++) : ?>
					<?php $br = $i +1; $tacan_odgovor = isset($pitanja_i_odgovori["tacan_odgovor_{$br}"]) ? $pitanja_i_odgovori["tacan_odgovor_{$br}"] : 0; ?>
					<li><p name="pitanje_<?php echo $i + 1 ?>" class="form-control">
							<?php echo isset($pitanja_i_odgovori["pitanje_{$br}"]) ?  $pitanja_i_odgovori["pitanje_{$br}"] : ''?>
						</p>
						<?php if (!empty($pitanja_i_odgovori["odgovori_{$br}"])): ?>
						<ul>
							<?php foreach ($pitanja_i_odgovori["odgovori_{$br}"] as $id => $odgovor) {?>
							<li>
								<div class="radio">
									<input type="radio" name="tacan_odgovor_<?php echo $i + 1 ?>"
										   value="<?php echo $id;?>">
									<p class="form-control" name="odgovor_<?php echo $i + 1 ?>">
										<?php echo $odgovor;?>
									</p>
								</div>
							</li>
							<?php }?>
						</ul>
						<?php endif ?>
					</li>
				<?php endfor; ?>
			</ol>
			<button class="col-md-12 col-xs-12 btn btn-default btn-success">Polazi</button>
		</form>
	</div>
<?php include 'footer.php'; ?>