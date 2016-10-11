<!DOCTYPE HTML>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Testovi</title>

    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/style.css">

    <script src="public/js/jquery-3.1.1.min.js"></script>
    <script src="public/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container-fluid">
    <div class="login-form">
        <form method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Korisničko ime</label>
                <input type="email" name="korisnicko_ime" class="form-control" placeholder="Korisničko ime">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Sifra</label>
                <input type="password" name="sifra" class="form-control" placeholder="Sifra">
            </div>
            <button type="submit" name="submit" class="col-md-12 btn btn-default btn-info">Uloguj se</button>
        </form>
        <?php
			if(!empty($greske)) { ?>
        <div class="alert alert-danger my-alert">
            <?php
                echo implode('</br>', $greske);
            ?>
        </div>
        <?php
			}
        ?>
    </div>
</div>
</body>
</html>