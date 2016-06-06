<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nameless Apps 收支管理系統</title>
    <link rel="stylesheet" type="text/css" href="../semantic/semantic.css">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <script src="../scripts/jquery-2.2.2.js"></script>
    <script src="../semantic/semantic.js"></script>
</head>
<body>
<div class="ui container">
    <!-- 選單 -->
    <?php
    include 'navigation.php';
    ?>

    <!-- 標題 -->
    <h1 class="ui teal header">
        會員
    </h1>

    <?php
    include './../util/connect.php';
    ?>

    <?php
    // 取得會員列表

    $stmt = $mysqli->prepare('SELECT id, name, username, email FROM member');
    $stmt->bind_result($id, $name, $username, $email);
    $stmt->execute();
    ?>

    <table class="ui celled padded table">
        <thead>
        <tr>
            <th>ID</th>
            <th>名字</th>
            <th>使用者</th>
            <th>電子郵件</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($stmt->fetch()) {
            ?>
            <tr>
                <td style="text-align: center;">
                    <?php echo $id; ?>
                </td>
                <td>
                    <?php echo $name; ?>
                </td>
                <td class="single line">
                    <?php echo $username; ?>
                </td>
                <td>
                    <?php echo $email; ?>
                </td>
                <td class="center aligned">
                    <a href="delete_member.php?id=<?php echo $id; ?>">刪除</a>
                </td>
            </tr>
            <?php
        }
        $stmt -> close();
        ?>
        </tbody>
    </table>


    <?php
    include './../util/close.php';
    ?>
</div>
</body>
</html>
