<?php
include_once 'classes/RegisterUser.php';

if (@$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirm_password'])
        && isset($_POST['email']) && isset($_POST['name'])
    ) {
        $reg = new RegisterUser($_POST['login'], $_POST['password'], $_POST['confirm_password'], $_POST['email'], $_POST['name']);
        $reg->sendResponse();
    }
}