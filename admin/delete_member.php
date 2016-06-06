<?php

include './../util/connect.php';

$id = intval($_GET['id']);

$stmt = $mysqli -> prepare('DELETE FROM member ? WHERE id = ?');
$stmt -> bind_param('d', $id);

if ($stmt -> execute()) {
    header('Location: members.php');
} else {
    ?>
    <script>
        alert('刪除失敗！')
        window.location.assign('members.php')
    </script>
    <?php
}

include './../util/close.php';
