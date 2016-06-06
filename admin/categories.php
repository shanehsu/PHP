<?php
include("./../util/connect.php");

$debug = true;

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
    $result = $mysqli->query("select * from categories where parent = {$id}");
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

include("./../util/close.php");
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
        /* 顯示 Segment 之間的邊線 */
        .ui.attached + .ui.attached.segment:not(.top) {
            border-top: 1px solid rgba(34, 36, 38, 0.15);
        }

        /* 增加階層的感覺 */
        .ui.segments > .segment + .segments:not(.horizontal) {
            margin-left: 3em;
        }
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
        分類
        <div class="ui right floated positive button" onclick="">新增</div>
    </h1>


    <?php
    include './../util/connect.php';

    foreach ($categories as $category) {
        switch ($category['depth']) {
            case 1:

                $result = $mysqli->query("SELECT * FROM products WHERE categories = " . $category['id']);
                $count = mysqli_num_rows($result);
                $hasProduct = mysqli_num_rows($result) > 0;
                mysqli_free_result($result);
                ?>
                <div class="ui attached padded segment">
                    <p>
                        <span><?php echo $category["name"]; ?></span>
                        <span style="float: right;">共有 <?php echo $count; ?> 項商品</span>
                    </p>
                </div>

                <?php
                if (!$hasProduct) {
                    ?>
                    <div class="ui bottom attached buttons">
                        <div class="ui negative button"
                             onclick="location.href='<?php echo "delete_categories.php?id=" . $category["id"]; ?>'">
                            刪除該類別
                        </div>
                        <div class="ui grey bottom attached button"
                             onclick="location.href='<?php echo "edit_category.php?id=" . $category["id"]; ?>'">
                            編輯該類別
                        </div>
                        <div class="ui positive button" onclick="location.href='new_category.php'">新增子類別</div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="ui bottom attached button"
                         onclick="location.href='<?php echo "edit_category.php?id=" . $category["id"]; ?>'">
                        編輯該類別
                    </div>
                    <?php
                }
                break;
            case 2:
                ?>
                <div class="ui padded segments">
                    <div class="ui padded segment">
                        <p>
                            <span><?php echo $category["name"]; ?></span>
                        </p>
                    </div>
                    <div class="ui attached padded segments">
                        <?php
                        foreach ($category["children"] as $child) {
                            $result = $mysqli->query("SELECT * FROM products WHERE categories = " . $child['id']);
                            $count = mysqli_num_rows($result);
                            $hasProduct = mysqli_num_rows($result) > 0;
                            mysqli_free_result($result);
                            ?>
                            <div class="ui padded segment">
                                <p>
                                    <span><?php echo $child["name"] ?></span>
                                    <span style="float: right;">共有 <?php echo $count; ?> 項商品</span>
                                </p>
                            </div>

                            <?php

                            if (!$hasProduct) {
                                ?>
                                <div class="ui bottom attached buttons">
                                    <div class="ui negative button"
                                         onclick="location.href='<?php echo "delete_categories.php?id=" . $child["id"]; ?>'">
                                        刪除該類別
                                    </div>
                                    <div class="ui grey bottom attached button"
                                         onclick="location.href='<?php echo "edit_category.php?id=" . $child["id"]; ?>'">
                                        編輯該類別
                                    </div>
                                    <div class="ui positive button" onclick="location.href='new_category.php'">新增子類別
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="ui grey bottom attached button"
                                     onclick="location.href='<?php echo "edit_category.php?id=" . $child["id"]; ?>'">
                                    編輯該類別
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="ui grey bottom attached button"
                         onclick="location.href='<?php echo "edit_category.php?id=" . $category["id"]; ?>'">
                        編輯該類別
                    </div>
                </div>
                <?php
                break;
            case 3:
                ?>

                <div class="ui padded segments">
                    <div class="ui padded segment">
                        <p>
                            <span><?php echo $category["name"]; ?></span>
                        </p>
                    </div>
                    <div class="ui attached padded segments">
                        <?php
                        foreach ($category["children"] as $child) {
                            ?>
                            <div class="ui padded segment">
                                <p>
                                    <span><?php echo $child["name"]; ?></span>
                                </p>
                            </div>
                            <div class="ui attached padded segments">
                                <?php
                                foreach ($child["children"] as $grandchild) {
                                    $result = $mysqli->query("SELECT * FROM products WHERE categories = " . $child['id']);
                                    $count = mysqli_num_rows($result);
                                    $hasProduct = mysqli_num_rows($result) > 0;
                                    mysqli_free_result($result);
                                    ?>

                                    <div class="ui padded segment">
                                        <p>
                                            <span><?php echo $grandchild["name"]; ?></span>
                                            <span style="float: right;">共有 <?php echo $count; ?> 項商品</span>
                                        </p>
                                    </div>
                                    <?php

                                    if (!$hasProduct) {
                                        ?>
                                        <div class="ui bottom attached buttons">
                                            <div class="ui grey bottom attached button"
                                                 onclick="location.href='<?php echo "edit_category.php?id=" . $grandchild["id"]; ?>'">
                                                編輯該類別
                                            </div>
                                            <div class="ui negative bottom attached button"
                                                 onclick="location.href='<?php echo "delete_categories.php?id=" . $grandchild["id"]; ?>'">
                                                刪除該類別
                                            </div>
                                        </div>

                                        <?php
                                    }

                                    ?>


                                    <?php
                                }
                                ?>
                            </div>
                            <div class="ui grey bottom attached button"
                                 onclick="location.href='<?php echo "edit_category.php?id=" . $child["id"]; ?>'">
                                編輯該類別
                            </div>

                            <?php
                        }
                        ?>
                    </div>
                    <div class="ui grey bottom attached button"
                         onclick="location.href='<?php echo "edit_category.php?id=" . $child["id"]; ?>'">
                        編輯該類別
                    </div>
                </div>

                <?php
                break;
            default:
                die("目錄深度太深。");
        }
    }

    include './../util/close.php';
    ?>
</body>
</html>