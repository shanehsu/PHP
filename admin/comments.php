<?php

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    // 刪除吧
    $cid = intval($_GET['id']);

    include './../util/connect.php';

    $stmt_d = $mysqli -> prepare('DELETE FROM comments WHERE id = ?');
    $stmt_d -> bind_param('d', $cid);

    if ($stmt_d -> execute()) {
        header('location: comments.php');
    } else {
        ?>
        <script>
            alert('刪除失敗。')
            window.location.assign('comments.php')
        </script>
        <?php
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
</head>
<body>
<div class="ui container">
    <!-- 選單 -->
    <?php
    include 'navigation.php';
    ?>

    <!-- 標題 -->
    <h1 class="ui teal header">
        評論
    </h1>

    <?php
    include './../util/connect.php';
    ?>

    <?php
    // 取得會員列表

    $stmt = $mysqli->prepare('SELECT group_12.comments.id, group_12.comments.date, group_12.products.name, group_12.comments.rating, group_12.comments.comment, group_12.member.name
              FROM group_12.comments, group_12.products, group_12.member
              WHERE group_12.products.id = group_12.comments.product AND group_12.member.id = group_12.comments.member');

    $stmt->bind_result($id, $date, $pname, $rating, $comment, $uname);
    $stmt->execute();
    ?>

    <table class="ui celled padded table">
        <thead>
        <tr>
            <th>時間</th>
            <th>產品</th>
            <th>評論及分數</th>
            <th>評論者</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($stmt->fetch()) {
            ?>
            <tr>
                <td style="text-align: center;">
                    <?php echo $date; ?>
                </td>
                <td>
                    <?php echo $pname; ?>
                </td>
                <td id="ppop_<?php echo $id; ?>" class="popping-comment" data-title="評論" data-content="">
                    <?php echo $rating; ?>
                </td>
                <td>
                    <?php echo $uname; ?>
                </td>
                <td class="center aligned">
                    <a href="comments.php?action=delete&id=<?php echo $id; ?>">刪除</a>
                </td>
            </tr>

            <script>
                $('#ppop_<?php echo $id; ?>').attr('data-content', <?php echo json_encode($comment); ?>)
            </script>
            <?php
        }
        $stmt -> close();
        ?>
        </tbody>
    </table>

    <script>
        $(function() {
            $('.popping-comment').popup()
        })
    </script>

    <?php
    include './../util/close.php';
    ?>
</div>
</body>
</html>
