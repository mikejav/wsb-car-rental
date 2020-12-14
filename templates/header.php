<?php
// plik zawiera góre HTMLu strony
?>
<!DOCTYPE html>
<html class="h-100 no-touch">
<head>
<meta charset="UTF-8"/>
<title>Wypożyczalnia samochodów</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body class="d-flex flex-column h-100">

<header>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href=".">Wypożyczalnia samochodów</a>
      <ul class="navbar-nav mb-2 mb-md-0">
        <li class="nav-item active">
          <a class="nav-link" aria-current="page" href=".">Strona główna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <div>
        <span class="text-light mx-2">
          Zalogowany jako: <b><?= $_SESSION['loggedUser']['firstName'].' '.$_SESSION['loggedUser']['lastName'] ?></b>
        </span>
        <?php if (IS_USER_LOGGED_IN): ?>
          <a href="logout.php" class="btn btn-primary">Wyloguj się</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-primary">Zaloguj się</a>
        <?php endif ?>
      </div>
    </div>
  </nav>
</header>

<div class="container h-100 my-4">
