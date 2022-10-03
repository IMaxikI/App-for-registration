<?php
session_start();

if (isset($_SESSION['login'])) {
    echo json_encode(['isAuth' => true]);
} else {
    echo json_encode(['isAuth' => false, 'redirect' => 'authorization.html']);
}