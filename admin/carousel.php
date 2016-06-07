<?php
include "AdminAuthenticationRequired.php";
?>

<?php
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = intval($_GET['id']);

    include './../util/connect.php';

    if ($action == 'add') {
        $stmt = $mysqli -> prepare('INSERT INTO group_12.carousel(image) VALUES (?)');
        $stmt -> bind_param('d', $id);

        if ($stmt -> execute()) {
            header('location: carousel.php');
        } else {
            ?>
            <script>
                alert('新增失敗！')
                window.location.assign('carousel.php')
            </script>
            <?php
        }
    } else if ($action == 'delete') {
        $stmt = $mysqli -> prepare('DELETE FROM group_12.carousel WHERE id = ?');
        $stmt -> bind_param('d', $id);

        if ($stmt -> execute()) {
            header('location: carousel.php');
        } else {
            ?>
            <script>
                alert('刪除失敗！')
                window.location.assign('carousel.php')
            </script>
            <?php
        }
    }

    include './../util/close.php';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nameless Apps 收支管理系統</title>
    <link rel="stylesheet" type="text/css" href="../semantic/semantic.css">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <script src="../scripts/jquery-2.2.2.js"></script>
    <script src="../semantic/semantic.js"></script>

    <script>
    </script>

    <style>
    </style>
</head>
<body>
<div class="ui container">
    <!-- 選單 -->
    <?php
    include 'navigation.php';
    ?>

    <!-- 標題 -->
    <h1 class="ui teal header">
        首頁輪播
    </h1>

    <!-- 內容 -->
    <table class="ui celled padded table">
        <thead>
        <tr>
            <th>ID</th>
            <th>圖片</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        include("./../util/connect.php");

        $stmt = $mysqli -> prepare('SELECT id, image FROM carousel');
        $stmt -> bind_result($id, $image);
        $stmt -> execute();
        while ($stmt -> fetch()) {
            ?>
            <tr>
                <td style="text-align: center;">
                    <?php
                    echo $id;
                    ?>
                </td>
                <td>
                    <img style="max-height: 6em; max-width: 6em;" src="<?php echo "/images.php?id={$image}" ?>">
                </td>
                <td class="center aligned">
                    <a href="carousel.php?action=delete&id=<?php echo $id; ?>">刪除</a>
                </td>
            </tr>
            <?php
        }

        $stmt -> close();
        ?>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <?php
            // 取得所有圖片的 ID
            $stmt_i = $mysqli -> prepare('SELECT id FROM images');
            $stmt_i -> bind_result($i);
            $stmt_i -> execute();

            ?>
            <th class="right aligned" colspan="5">
                <form action="carousel.php">
                    <input type="hidden" name="action" value="add" />
                    <div style="display: inline-block;" class="inline field">
                        <label>影像 ID</label>
                        <select name="id">
                            <?php
                            while ($stmt_i -> fetch()) {
                                echo "<option value=\"{$i}\">{$i}</option> \n";
                            }

                            $stmt_i -> close();

                            include './../util/close.php';
                            ?>
                        </select>
                    </div>
                    <button class="inline field ui basic blue button">
                        新增
                    </button>
                </form>
            </th>
        </tr>
        </tfoot>
    </table>

</div>
</body>
</html>

<!-- 用 http://php.net/manual/en/function.uniqid.php 生成亂數檔案名稱 -->