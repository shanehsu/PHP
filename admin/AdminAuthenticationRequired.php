<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/7
 * Time: 上午2:52
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$authenticated = isset($_SESSION['_ADMIN_AUTHENTICATED']) && $_SESSION['_ADMIN_AUTHENTICATED'];

session_commit();

if (!$authenticated) {
    include 'not_authenticated.html';
    exit();
}