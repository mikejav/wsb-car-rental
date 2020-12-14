<?php

require_once('./common/bootstrap.php');

if (IS_USER_LOGGED_IN) {
    session_unset();
    session_destroy();
}

header("Location: .");
