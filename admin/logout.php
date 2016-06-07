<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/7
 * Time: 上午11:14
 */

session_start();

$_SESSION["_ADMIN_AUTHENTICATED"] = false;
$_SESSION["_ADMIN_ID"] = -1;

header('Location: login.php');

session_commit();