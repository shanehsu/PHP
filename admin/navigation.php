<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/5
 * Time: 上午10:39
 */

$_ADMIN_NAVIGATION_CONFIGURATION = array(
    array(
        'name' => '公告',
        'href' => 'posts'
    ),
    array(
        'name' => '靜態圖片',
        'href' => 'statics'
    ),
    array(
        'name' => '首頁輪播',
        'href' => 'carousel'
    ),
    array(
        'name' => '分類',
        'href' => 'categories'
    ),
    array(
        'name' => '產品',
        'href' => 'products'
    ),
    array(
        'name' => '會員',
        'href' => 'members'
    ),
    array(
        'name' => '評論',
        'href' => 'comments'
    )
);

// _ADMIN_NAVIGATION_COUNT
$ANC = count($_ADMIN_NAVIGATION_CONFIGURATION);

/*
 * 其實還有這些
 *
 * - 首頁輪播
 * - 產品
 * - 訂單
 * - 會員
 * - 管理者
 */

$_COLUMN_NUMBER_STYLE_CLASSES = array(
    'zero', 'one', 'two', 'three', 'four',
    'five', 'six', 'seven', 'eight', 'nine'
);

$CNSC = $_COLUMN_NUMBER_STYLE_CLASSES;

?>

<div class="ui <?php echo $CNSC[$ANC]; ?> item menu">
    <?php
    foreach ($_ADMIN_NAVIGATION_CONFIGURATION as $item) {
        ?>
        <a href="<?php echo $item['href']; ?>.php" class="item">
            <?php
            echo $item['name'];
            ?>
        </a>
        <?php
    }
    ?>
</div>
