<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kreiraj ispit</title>
</head>
<body>
<div class="container-fluid">
    <div class="">
        <form method="post">
            <div class="form-group">
                <label>Naziv ispita</label>
                <input type="text" name="naziv_ispita" class="form-control" placeholder="Naziv ispita">
            </div>
            <div class="form-group">
                <label>Broj pitanja</label>
                <input type="number" name="broj_pitanja" class="form-control" placeholder="Broj pitanja">
            </div>
            <button type="submit" name="submit" class="col-md-12 btn btn-default btn-info">Kreiraj</button>
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