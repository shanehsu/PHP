<?php

// POST ONY WITH id PARAMETER for Product ID

$productID = $_GET['id'];
session_start();
$userID = $_SESSION['_ID'];
session_write_close();

$rating = intval($_POST['rating']);
$comment = $_POST['comment'];

include 'util/connect.php';

$stmt = $mysqli -> prepare('INSERT INTO group_12.comments(rating, comment, product, member) VALUES (?, ?, ?, ?)');
$stmt -> bind_param('dsdd', $rating, $comment, $productID, $userID);

if ($stmt -> execute()) {
    header('Location: product.php?id=' . $productID);

    $stmt -> close();

    // 計算評分
    $stmt_r = $mysqli -> prepare('SELECT rating FROM group_12.comments WHERE product = ?');
    $stmt_r -> bind_param('d', $productID);
    $stmt_r -> bind_result($commentRating);
    $stmt_r -> execute();

    $counts = 0;
    $cumulative = 0;

    while ($stmt_r -> fetch()) {
        $counts = $counts + 1;
        $cumulative = $cumulative + $commentRating;
    }

    $stmt_r -> close();

    $average = $cumulative / $counts;

    $stmt_u = $mysqli -> prepare('UPDATE group_12.products SET rating = ? WHERE id = ?');
    echo $mysqli -> error;
    $stmt_u -> bind_param('dd', $average, $productID);
    $stmt_u -> execute();
    $stmt_u -> close();
} else {
    ?>
    <script>
        alert('評論失敗。')
        window.location.assign('product.php?id='.$productID)
    </script>
    <?php
}

include 'util/close.php';