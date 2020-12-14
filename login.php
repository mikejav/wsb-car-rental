<?php

require_once('./common/bootstrap.php');

// Jeżeli user jest już zalogowany to przekierowujemy go do strony głównej
if (IS_USER_LOGGED_IN) {
    header("Location: .");
    exit;
}

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if ($email && $password) {
    $isAuthenticated = false;
    $escapedEmail = $dbConnection->real_escape_string($email);
    $escapedPassword = $dbConnection->real_escape_string(sha1($password));
    $sql="SELECT * FROM users WHERE email='$escapedEmail' AND password='$escapedPassword'";

    if($result = $dbConnection->query($sql)) {
        if ($result->num_rows) {
            $isAuthenticated = true;
            $user = $result->fetch_assoc();
        }
    }
    
    if($isAuthenticated) {
        $_SESSION['loggedUser'] = $user;
        header("Location: .");
    } 
    else {
        $errorMessage = "Niepoprawny email lub hasło";
    }
}

require_once('templates/header.php');

?>

<div class="row">
    <form class="w-50 m-auto" action="login.php" method="post">
        <?php if(isset($errorMessage)): ?>
            <div class="alert alert-danger"><?= $errorMessage ?></div>
        <?php endif ?>
        <h2 class="text-center">Logowanie</h2>
        <form>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="email">
            </div>
            <div class="form-group mt-2">
                <label>Hasło</label>
                <input type="password" name="password" class="form-control" placeholder="Hasło">
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Zaloguj się</button>
            </div>
            </form>
    </form>
    <!-- <p class="text-center"><a href="#">Rejestracja</a></p> -->
</div>

<?php
require_once('templates/footer.php');
