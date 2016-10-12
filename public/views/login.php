<?php include 'header.php'; ?>
<div class="login-form col-md-6 col-xs-12 no-float">
    <form method="post">
        <h3>Uloguj se</h3>
        <div class="form-group hidden za-registraciju">
            <label>Ime</label>
            <input type="text" name="ime" class="form-control" placeholder="Korisničko ime">
        </div>
        <div class="form-group hidden za-registraciju">
            <label>Prezime</label>
            <input type="text" name="prezime" class="form-control" placeholder="Korisničko ime">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="korisnicko_ime" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
            <label>Sifra</label>
            <input type="password" name="sifra" class="form-control" placeholder="Sifra">
        </div>
        <input type="hidden" name="akcija" value="logovanje">
        <button type="submit" name="submit" class="col-md-12 col-xs-12 btn btn-default btn-info">Uloguj se</button>
        <div class="links">
            <a href="javascript:void(0)" class="promeniAkciju hidden" data-value="logovanje">Uloguj se</a>
            <a href="javascript:void(0)" class="promeniAkciju" data-value="registracija_studenta">Registruj studenta</a>
            <a href="javascript:void(0)" class="promeniAkciju" data-value="registracija_profesora">Registruj profesora</a>
        </div>
    </form>
    <?php if(!empty($greske)): ?>
    <div class="alert alert-danger my-alert">
        <?php echo implode('</br>', $greske); ?>
    </div>
    <?php endif; ?>
</div>
<script src="public/js/login.js"></script>
<?php include 'footer.php'; ?>
