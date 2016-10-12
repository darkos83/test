<?php include 'header.php'; ?>
<div class="login-form col-md-6 col-xs-12 no-float">
    <form method="post">
        <div class="form-group">
            <label>Naziv ispita</label>
            <input type="text" name="naziv_ispita" class="form-control" placeholder="Naziv ispita">
        </div>
        <div class="form-group">
            <label>Broj pitanja</label>
            <input type="number" min='1' name="broj_pitanja" class="form-control" placeholder="Broj pitanja">
        </div>
        <button type="submit" name="submit" class="col-md-12 col-xs-12 btn btn-default btn-info">Kreiraj</button>
    </form>
    <?php if(!empty($greske)): ?>
    <div class="alert alert-danger my-alert">
        <?php echo implode('</br>', $greske); ?>
    </div>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
