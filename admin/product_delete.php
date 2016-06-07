<?php
include "AdminAuthenticationRequired.php";
?>

<?php
include './../util/connect.php';

$id = intval($_GET['id']);
$stmt = $mysqli -> prepare('DELETE FROM products WHERE id = ?');
$stmt -> bind_param('d', $id);

if ($stmt -> execute()) {
    header('location: products.php');
    $stmt -> close();

    // 刪除 Carousel 以及 Cart 資料
    $stmt = $mysqli -> prepare('DELETE FROM group_12.cart WHERE item = ?');
    $stmt -> bind_param('d', $id);
    $stmt -> execute();
    $stmt -> close();

    $stmt = $mysqli -> prepare('DELETE FROM group_12.product_carousel WHERE product = ?');
    $stmt -> bind_param('d', $id);
    $stmt -> execute();
    $stmt -> close();
} else {
    $stmt -> close();
    ?>
    <script>
        alert('刪除失敗！')
        window.location.assign('products.php')
    </script>
    <?php
}

include './../util/close.php';