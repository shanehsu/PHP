<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/6
 * Time: 上午4:07
 */

session_start();

$_SESSION["_AUTHENTICATED"] = false;
$_SESSION["_ID"] = 0;

session_commit();