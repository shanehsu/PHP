<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/5
 * Time: 下午9:21
 */

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != "" && $_POST['password'] != "") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        include './../util/connect.php';

        $statement = $mysqli -> prepare('SELECT id, username, password FROM member WHERE username = ?');
        $statement -> bind_param('s', $username);
        $statement -> execute();
        $statement -> bind_result($rid, $rusername, $rpassword);
        $statement -> fetch();
        
        if ($rusername == $username && $rpassword == $password) {
            session_start();

            $_SESSION["_AUTHENTICATED"] = true;
            $_SESSION["_ID"] = $rid;

            session_commit();

            echo 'true';
        } else {
            echo 'false';
        }

        include './../util/close.php';
    }
} else {
    echo 'false';
}

?>