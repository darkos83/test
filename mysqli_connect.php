<?php

DEFINE('DB_USER', 'root');
DEFINE('DB_PASWORD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'user_db');

$dbc = @mysqli_connect(DB_HOST,DB_USER,DB_PASWORD, DB_NAME)
OR die('Nema konekcije sa bazom' .
    mysqli_connect_error() );

