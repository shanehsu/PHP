<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/5
 * Time: 下午2:28
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$authenticated = isset($_SESSION['_AUTHENTICATED']) && $_SESSION['_AUTHENTICATED'];
$uid = isset($_SESSION['_ID']) ? intval($_SESSION['_ID']) : -1;
?>

<div class="ui large menu">
    <a href="index.php" class="active item">阿寯的美食天地</a>
    <div class="right menu">
        <div class="item">
            <div class="ui category search">
                <div class="ui transparent icon input">
                    <input class="prompt" type="text" placeholder="搜尋...">
                    <i class="search link icon"></i>
                </div>
                <div class="results"></div>
            </div>
        </div>
        <?php

        if (!$authenticated) {
            ?>
            <a id="login-modal-show" class="ui item">登入</a>
            <?php
        } else {
            include 'util/connect.php';

            $id = $_SESSION['_ID'];
            session_write_close();

            $statement = $mysqli -> prepare('SELECT name FROM member WHERE id = ?');
            $statement -> bind_param('d', $id);
            $statement -> execute();
            $statement -> bind_result($name);
            $statement -> fetch();

            include 'util/close.php';
            ?>
            <div class="ui dropdown item">
                <?php
                include 'util/connect.php';
                $count_stmt = $mysqli -> prepare('SELECT COUNT(*) FROM group_12.receipt WHERE member = ? AND paid = 0');
                $count_stmt -> bind_param('d', $uid);
                $count_stmt -> bind_result($unpaid);
                $count_stmt -> execute();
                $count_stmt -> fetch();
                $count_stmt -> close();
                include 'util/close.php';
                if ($unpaid != 0) {
                    ?>
                    <a class="ui red empty circular label"></a>
                    <?php
                }
                ?>
                <?php echo $name; ?>
                <i class="dropdown icon"></i>
                <div class="menu">
                    <a href="member.php" class="item">
                        <?php
                        if ($unpaid != 0) {
                            ?>
                            <div class="ui red tiny label"><?= $unpaid ?></div>
                            <?php
                        }
                        ?>
                        會員中心
                    </a>
                    <a id="logout" class="item">登出</a>
                </div>
            </div>
            <a id="cart-modal-show" class="ui item">購物車</a>
            <?php
        }
        ?>
    </div>
</div>
