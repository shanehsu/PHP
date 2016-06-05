<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/5
 * Time: 上午11:56
 * 
 * Check if username is in use.
 */

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    include './../util/connect.php';

    $statement = $mysqli -> prepare('SELECT username FROM member WHERE username = ?');
    $statement -> bind_param('s', $username);

    $statement -> execute();
    $statement -> bind_result($un);
    $statement -> fetch();

    $exists = $un == $username;
    
    if ($exists) {
        echo 'false';
    } else {
        echo 'true';
    }

    include './../util/close.php';
} else {
    throw new Exception('期待有 username 搜尋字串。');
}