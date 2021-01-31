<?php

function guardPage() {
    if (!IS_USER_LOGGED_IN) {
        header("Location: login.php");
        die();
    }
}
