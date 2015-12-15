
<?php
$userType = array(
	0 => 'User',
	1 => 'Admin'
);

if(isset($_POST['submit'])) {
    $errors = array();
	/**
	 * Uvek prvo ispitujes ako nesto nije uredu, pa ako svi podaci budu ok onda 
	 * ih tek upisujes u bazu ili sta god treba da uradis sa  njima.
	 * 
	 * array_push funkcija ti je isto kao da si napisao $errors[] = 'Empty email.'
	 */
	if (empty($_POST['email'])) {
		array_push($errors, "Empty email.");
	}
	/**
	 * Ako neka funkcija vraca false za ako nesto nije uredu, kao u ovom slucaju 
	 * moze da napises  !filter_var(trim($email), FILTER_VALIDATE_EMAIL). Funkcija ce
	 * da vrati false a ! znaci negaciju i to ce da bude true i ucice u if, a ako vrati 
	 * neki podatak npr 5 i kad uradis ! to ti je false.
	 * 
	 * filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) ce da vrati za aaaa@aaaaa.aaaaaaa da je validan mail, a ustvari nije
	 * http://php.net/manual/en/filter.filters.validate.php evo ti ovde dokumentacije
	 */
	if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Email not valid.");
	}
	if (empty($_POST['password'])) {
		array_push($errors, "Empty password.");
	}
	/**
	 * Ovde koristimo isset zato sto type moze da bude 0 ili 1, a empty funkcija za 0 ce da 
	 * vrati true. 
	 */
	if (isset($_POST['type']) && !array_key_exists($_POST['type'], $userType)) {
		array_push($errors, "Invalid user type.");
	}
	/**
	 * Kad si sve podatke ispitao onda proveravas da li ima gresaka i ako ih ima tu prekidas kod.
	 */
	if (!empty($errors)) {
		echo 'You need to enter the following data <br> ';
		echo implode("<br>", $errors);
		return;
	}
	
    require_once('../mysqli_connect.php');

    $query = "INSERT INTO users (email, password,
                  type, created) VALUES (?, ?, ?
                  , NOW()) ";
    $stmt = mysqli_prepare($dbc, $query);
//sta ti je ovo sss?
	mysqli_stmt_bind_param($stmt,"sss", $_POST['email'], sha1($_POST['password']), $_POST['type']);
	mysqli_stmt_execute($stmt);
	$affected_rows = mysqli_stmt_affected_rows($stmt);

	/**
	 * I ovde ides ako nije uspesno vratis gresku.
	 */
	if(empty($affected_rows)){
		echo 'Error Ocurred <br />';
		echo mysql_error();
		mysqli_stmt_close($stmt);
		mysqli_close($dbc);
		return;
	}
	echo 'User Entered';
	mysqli_stmt_close($stmt);
	mysqli_close($dbc);
	/**
	 * vidis koliko manje linija koda ima kad ovako ne koristis if i else. to je ono 
	 * o cemu sam ti pricao.
	 * https://github.com/bmpasini/Principles-of-Database-Systems/tree/master/q1_php/examples
	 * i sa ovog si primera gledao na github-u.
	 */
}
