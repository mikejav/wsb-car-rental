<?php
// plik zawiera góre HTMLu strony
?>
<!DOCTYPE html>
<html class="h-100 no-touch">
<head>
<meta charset="UTF-8"/>
<title>Wypożyczalnia samochodów</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
</head>
<body class="d-flex flex-column h-100 bg-light">

<header>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href=".">Wypożyczalnia samochodów</a>
      <ul class="navbar-nav mb-2 mb-md-0 ml-auto mr-3">
        <li class="nav-item active">
          <a class="nav-link" aria-current="page" href=".">Strona główna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="vehicles.php">Pojazdy</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="customers.php">Klienci</a>
        </li>
      </ul>
      <div>
        <?php if (IS_USER_LOGGED_IN): ?>
          <span class="text-light mx-2">
            Zalogowany jako: <b><?= $_SESSION['loggedUser']['firstName'].' '.$_SESSION['loggedUser']['lastName'] ?></b>
          </span>
          <a href="logout.php" class="btn btn-primary">Wyloguj się</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-primary">Zaloguj się</a>
        <?php endif ?>
      </div>
    </div>
  </nav>
</header>

<div class="container d-flex flex-column flex-grow-1 my-4">
