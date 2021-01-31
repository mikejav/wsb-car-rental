<?php

// czytamy konfiguracje z pliku
// parse_ini_file wrzytuje zawartość pliku w formacie INI i parsuje go do stałej w formacie tablicy asocjacyjnej "klucz => wartość"
// funkcja define tworzy wartość stałą. Nie można jej zmienić
// __DIR__ jest stałą w PHP która wskazuje na katalog tego pliku
define('CONFIG', parse_ini_file(__DIR__.'/../config.ini'));

// tworzymy globalne połączenie z bazą danych
// urzywamy obiektowej wersji mysqli
$dbConnection = new mysqli(CONFIG['dbHost'], CONFIG['dbUser'], CONFIG['dbPassword'], CONFIG['dbName']);

session_start();
if(isset($_SESSION['loggedUser'])) {    
    define('IS_USER_LOGGED_IN', true);
} else {
    define('IS_USER_LOGGED_IN', false);
}

require_once(__DIR__.'/dataConstants.php');
require_once(__DIR__.'/../functions/templateComponents.php');
require_once(__DIR__.'/../functions/forms.php');
require_once(__DIR__.'/../functions/auth.php');
