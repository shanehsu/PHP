<?php
include "AdminAuthenticationRequired.php";
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
        分類
    </h1>

    <?php
    include './../util/connect.php';
    ?>

    <?php
    $result = $mysqli->query("SELECT * FROM categories WHERE parent IS NULL");
    $total = mysqli_num_rows($result);
    $categories = array();

    for ($i = 0; $i < $total; $i++) {
        $row = mysqli_fetch_row($result);

        array_push($categories, array(
            "name" => $row[1],
            "id" => $row[0],
            "parent" => $row[2],
            "depth" => 0,
            "children" => array()
        ));
    }

    function organize($id)
    {
        global $mysqli;
        $result = $mysqli->query("SELECT * from categories WHERE parent = {$id}");
        if ($result == false) {
            return array();
        }
        $row_count = mysqli_num_rows($result);
        $data = array();
        for ($i = 0; $i < $row_count; $i++) {
            $row = mysqli_fetch_row($result);

            array_push($data, array(
                "name" => $row[1],
                "id" => $row[0],
                "parent" => $row[2],
                "depth" => 0,
                "children" => array()
            ));
        }

        return $data;
    }

    function recurseOnCategory(array &$category)
    {
        $category["children"] = organize($category["id"]);
        $depth = 1;
        foreach ($category["children"] as $key => &$value) {
            $newDepth = recurseOnCategory($value) + 1;
            if ($newDepth > $depth) {
                $depth = $newDepth;
            }
        }

        $category["depth"] = $depth;
        return $depth;
    }

    foreach ($categories as &$category) {
        recurseOnCategory($category);
    }

    unset($category);

    ?>

    <?php
    print_r($categories);
    ?>
    <?php
    function category_count($categoryID) {
        include './../util/connect.php';

        $stmt = $mysqli -> prepare('SELECT COUNT(*) FROM group_12.products WHERE categories = ' . intval($categoryID));
        $stmt -> bind_result($c);
        $stmt -> execute();
        $stmt -> fetch();

        include './../util/close.php';

        return $c;
    }
    ?>
    <?php
    // 先自己，再小孩
    function render($depth, array $self) {
        $catcount = category_count($self['id']);
        ?>
        <tr>
            <?php
            if ($depth > 0) {
                ?>
                <td colspan="<?=$depth?>"></td>
                <?php
            }
            ?>
            <td colspan="<?=(4 - $depth)?>"><?=$self['name']?></td>
            <td><?=$catcount?></td>
            <td>
                <?php
                if ($depth != 2 && $catcount == 0 || !empty($self['children'])) {
                    ?>
                    <a href="category_new.php?id=<?$self['id']?>">新增子分類</a>
                    <?php
                }
                ?>
                <a href="category_edit.php?id=<?$self['id']?>">編輯名稱</a>
                <?php
                if ($catcount == 0 && empty($self['children'])) {
                    ?>
                    <a href="category_delete.php?id=<?$self['id']?>">刪除分類</a>
                    <?php
                }
                ?>
            </td>
        </tr>
        <?php

        if (!empty($self['children'])) {
            foreach ($self['children'] as $child) {
                render($depth + 1, $child);
            }
        }
    }
    ?>

    <?php
    foreach ($categories as $category) {
        ?>
        <table class="ui celled structured table">
            <thead>
            <tr>
                <th colspan="4">名稱</th>
                <th style="width: 25%;">產品數量</th>
                <th style="width: 25%;">動作</th>
            </tr>
            <tr style="">
                <th style="width: 12.5%;">第一層</th>
                <th style="width: 12.5%;">第二層</th>
                <th style="width: 12.5%;">第三層</th>
                <th colspan="3" style="width: 62.5%;"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            render(0, $category);
            ?>
            </tbody>
        </table>
        <?php
    }
    ?>

    <?php
    include './../util/close.php';
    ?>
</div>
</body>
</html>
