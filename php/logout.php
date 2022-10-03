<?php
session_start();

if (isset($_SESSION['login'])) {
    unset($_SESSION['login']);
    setcookie('name', '', ['path' => '/']);

    echo json_encode(['redirect' => 'authorization.html']);
}

