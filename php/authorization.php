<?php
include_once 'classes/AuthorizeUser.php';

if (@$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $aut = new AuthorizeUser($_POST['login'], $_POST['password']);
        $aut->sendResponse();
    }
}