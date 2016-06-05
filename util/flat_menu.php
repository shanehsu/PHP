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

<?php
$column_style_classes = array(
    "zero", "one", "two", "three", "four", "five", "six", "seven", "eight"
);
?>

<div class="ui secondary fluid vertical menu" style="max-width: 30rem;">
    <a class="item">
        特惠專區
    </a>
    <?php
    foreach ($categories as $category) {
        switch ($category["depth"]) {
            case 1:
                ?>
                <a href="category.php?id=<?php echo $category["id"]; ?>" class="item"><?php echo $category["name"]; ?></a>
                <?php
                break;
            case 2:
                ?>
                <a class="dropdown toggle browse item">
                    <?php echo $category["name"]; ?>
                    <i class="dropdown icon"></i>
                </a>
                <div class="ui flowing popup bottom left transition hidden">
                    <div class="">
                        <?php
                        foreach ($category["children"] as $child) {
                            ?>
                            <a href="category.php?id=<?php echo $child["id"]; ?>" class="item"><?php echo $child["name"]; ?></a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                break;
            case 3:
                ?>
                <a class="multiple dropdown toggle browse item">
                    <?php echo $category["name"]; ?>
                    <i class="dropdown icon"></i>
                </a>
                <div class="ui flowing popup bottom left transition hidden" style="min-width: <?php echo count($category["children"]) * 8;?>em;">
                    <div class="ui <?php echo $column_style_classes[count($category["children"])]; ?> column relaxed equal height divided grid">
                        <?php
                        foreach ($category["children"] as $child) {
                            ?>
                            <div class="column">
                                <h4 class="ui header"><?php echo $child["name"]; ?></h4>
                                <div class="ui link list">
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
