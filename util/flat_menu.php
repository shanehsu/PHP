<pre>
<?php
include("connect.php");

$debug = true;

$result = $mysqli->query("select * from categories where parent is null");
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

if ($debug) {
    // print_r($categories);
}

include("close.php");
?>
</pre>

<div class="ui vertical menu" style="max-width: 30rem;">
    <a class="item">
        特惠專區
    </a>
    <?php
    foreach ($categories as $category) {
        // print_r($category);
        switch ($category["depth"]) {
            case 1:
                ?>
                <a class="item"><?php echo $category["name"]; ?></a>
                <?php
                break;
            case 2:
                ?>
                <div class="item">
                    <div class="header"><?php echo $category["name"]; ?></div>
                    <div class="menu">
                        <?php
                        foreach ($category["children"] as $child) {
                            ?>
                            <a class="item"><?php echo $child["name"]; ?></a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                break;
            case 3:
                ?>
                <div class="item">
                    <div class="header"><?php echo $category["name"]; ?></div>
                    <div class="menu">
                        <?php
                        foreach ($category["children"] as $child) {
                            ?>
                            <div class="ui dropdown item">
                                <i class="dropdown icon"></i> <?php echo $child["name"]; ?>
                                <div class="menu">
                                    <?php
                                    foreach ($child["children"] as $grandchild) {
                                        ?>
                                        <a class="item"><?php echo $grandchild["name"]; ?></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                break;
            default:
                die("目錄深度太深。");
        }
    }
    ?>
</div>

<div class="ui fluid secondary vertical menu">
    <a class="active item">特惠專區</a>
    <a class="item">生鮮食品</a>
    <a class="item">加工食品</a>
    <a id="world-popup-toggle" class="browse item">
        世界美食特區
        <i class="dropdown icon"></i>
    </a>
    <div id="world-popup" class="ui flowing popup bottom left transition hidden" style="min-width: 30em;">
        <div class="ui four column relaxed equal height divided grid">
            <div class="column">
                <h4 class="ui header">亞洲</h4>
                <div class="ui link list">
                    <a class="item">日本</a>
                    <a class="item">南韓</a>
                </div>
            </div>
            <div class="column">
                <h4 class="ui header">歐洲</h4>
                <div class="ui link list">
                    <a class="item">英國</a>
                    <a class="item">法國</a>
                    <a class="item">義大利</a>
                </div>
            </div>
            <div class="column">
                <h4 class="ui header">美洲</h4>
                <div class="ui link list">
                    <a class="item">美國</a>
                    <a class="item">加拿大</a>
                    <a class="item">墨西哥</a>
                </div>
            </div>
            <div class="column">
                <h4 class="ui header">其他</h4>
                <div class="ui link list">
                    <a class="item">澳洲</a>
                    <a class="item">紐西蘭</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!--
<div class="ui vertical menu" style="max-width: 30rem;">
    <a class="item">
        特惠專區
    </a>
    <div class="item">
        <div class="header">生鮮專區</div>
        <div class="menu">
            <a class="item">蔬菜</a>
            <a class="item">水果</a>
            <a class="item">肉品</a>
            <a class="item">海鮮</a>
            <a class="item">乳製品</a>
        </div>
    </div>
    <div class="item">
        <div class="header">加工食品</div>
        <div class="menu">
            <a class="item">油品</a>
            <a class="item">甜點</a>
            <a class="item">零食</a>
            <a class="item">飲品</a>
        </div>
    </div>
    <div class="item">
        <div class="header">世界美食</div>
        <div class="menu">
            <div class="ui dropdown item">
                <i class="dropdown icon"></i> 亞洲
                <div class="menu">
                    <a class="item">日本</a>
                    <a class="item">南韓</a>
                </div>
            </div>
            <div class="ui dropdown item">
                <i class="dropdown icon"></i> 歐洲
                <div class="menu">
                    <a class="item">美國</a>
                    <a class="item">法國</a>
                    <a class="item">義大利</a>
                </div>
            </div>
            <div class="ui dropdown item">
                <i class="dropdown icon"></i> 美洲
                <div class="menu">
                    <a class="item">美國</a>
                    <a class="item">加拿大</a>
                    <a class="item">墨西哥</a>
                </div>
            </div>
            <div class="ui dropdown item">
                <i class="dropdown icon"></i> 其他
                <div class="menu">
                    <a class="item">澳洲</a>
                    <a class="item">紐西蘭</a>
                </div>
            </div>
        </div>
    </div>
</div>
-->
