<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kreiraj ispit</title>

    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/style.css">

    <script src="public/js/jquery-3.1.1.min.js"></script>
    <script src="public/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<?php if (!empty($_SESSION)): ?>
<a href="logout.php" class="col-md-12 col-xs-12 btn btn-default btn-info">Izloguj se</a>
<?php endif; ?>
<div class="container-fluid">
	<div class="wrapper col-md-6 col-xs-12 no-float">
		<?php if(!empty($greske)): ?>
			<div class="alert alert-danger my-alert">
				<?php echo implode('</br>', $greske); ?>
			</div>
		<?php 
			die; 
			endif; 
		?>