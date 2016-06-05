<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/5
 * Time: 下午2:28
 */
?>

<div class="ui large menu">
    <a href="index.php" class="active item">阿寯的美食天地</a>
    <div class="right menu">
        <div class="item">
            <div class="ui transparent icon input">
                <input type="text" placeholder="搜尋...">
                <i class="search link icon"></i>
            </div>
        </div>
        <?php
        session_start();
        $authenticated = isset($_SESSION['_AUTHENTICATED']) && $_SESSION['_AUTHENTICATED'];

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
                <?php echo $name; ?>
                <i class="dropdown icon"></i>
                <div class="menu">
                    <a href="members.php" class="item">會員中心</a>
                    <a id="logout" class="item">登出</a>
                </div>
            </div>

            <?php
        }
        ?>
        <a id="cart-modal-show" class="ui item">購物車</a>
    </div>
</div>
