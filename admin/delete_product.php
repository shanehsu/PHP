<?php
include './../util/connect.php';

$id = intval($_GET['id']);
$stmt = $mysqli -> prepare('DELETE FROM products WHERE id = ?');
$stmt -> bind_param('d', $id);

if ($stmt -> execute()) {
    header('location: products.php');
} else {
    ?>
    <script>
        alert('刪除失敗！')
        window.location.assign('products.php')
    </script>
    <?php
}

include './../util/close.php';