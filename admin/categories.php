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
        function add_new(id) {
            // 導向至新增畫面
        }

        function edit(id) {
            // 導向到編輯畫面
        }

        function del(id) {
            // 導向到刪除畫面
        }

        /*
         * 在 div 上面用 add_new(3) 或是 edit(5) 或是 del(5) 這樣
         * 之後用 location.href('edit_category.php?id=4') 寫在 JavaScript 函數內進行導向
         */
    </script>

    <style>
        /* 顯示 Segment 之間的邊線 */
        .ui.attached + .ui.attached.segment:not(.top) {
            border-top: 1px solid rgba(34, 36, 38, 0.15);
        }

        /* 增加階層的感覺 */
        .ui.segments > .segment + .segments:not(.horizontal) {
            margin-right: -1px;
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
        <!--                                                                  新的頂層類別不會有 ?id=xx -->
        <div class="ui right floated positive button" onclick="add_new('new')">新增</div>
    </h1>

    <!-- 內容 -->
    <!-- 若該類別的深度為 1 -->
    <div class="ui attached padded segment"> <!-- attached CSS 類別跟下面那一排按鈕有關係，當沒有子項目的時候才套用他 -->
        <p>
            <span>類別名稱在這裡</span>
            <span style="float: right;">共有 5 項商品</span>
        </p>
    </div>
    <!--
        因為這個按鈕部份，都是當沒有項目的時候才有，所以直接用 if 當沒子項目的時候顯示，
     -->
    <div class="ui bottom attached buttons">
        <!-- 刪除按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
        <div class="ui negative button" onclick="location.href='new_category.php'">刪除該類別</div>
        <!-- 新增按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
        <div class="ui positive button" onclick="location.href='new_category.php'">新增子類別</div>
    </div>

    <!-- 兩層的話 -->
    <div class="ui padded segments">
        <!-- 這是爸爸的名字 -->
        <div class="ui padded segment">
            <p>
                <span>母類別</span>
                <span style="float: right;">共有 5 項商品</span>
            </p>
        </div>
        <div class="ui attached padded segments">
            <div class="ui padded segment">
                <p>
                    <span>子類別</span>
                    <span style="float: right;">共有 5 項商品</span>
                </p>
            </div>
            <div class="ui bottom attached buttons">
                <!-- 刪除按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
                <div class="ui negative button" onclick="location.href='new_category.php'">刪除該類別</div>
                <!-- 新增按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
                <div class="ui positive button" onclick="location.href='new_category.php'">新增子類別</div>
            </div>
            <div class="ui attached padded segment">
                <p>
                    <span>子類別</span>
                    <span style="float: right;">共有 5 項商品</span>
                </p>
            </div>
            <div class="ui bottom attached buttons">
                <!-- 刪除按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
                <div class="ui negative button" onclick="location.href='new_category.php'">刪除該類別</div>
                <!-- 新增按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
                <div class="ui positive button" onclick="location.href='new_category.php'">新增子類別</div>
            </div>
        </div>
    </div>

    <!-- 三層的話 -->
    <div class="ui padded segments">
        <!-- 這是爸爸的名字 -->
        <div class="ui padded segment">
            <p>
                <span>母類別</span>
                <span style="float: right;">共有 5 項商品</span>
            </p>
        </div>
        <div class="ui attached padded segments">
            <div class="ui padded segment">
                <p>
                    <span>子類別</span>
                    <span style="float: right;">共有 5 項商品</span>
                </p>
            </div>
            <div class="ui attached padded segments">
                <div class="ui padded segment">
                    <p>
                        <span>孫子類別</span>
                        <span style="float: right;">共有 5 項商品</span>
                    </p>
                </div>
                <div class="ui bottom attached buttons">
                    <!-- 刪除按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
                    <div class="ui negative button" onclick="location.href='new_category.php'">刪除該類別</div>
                    <!-- 新增按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
                    <div class="ui positive button" onclick="location.href='new_category.php'">新增子類別</div>
                </div>
                <div class="ui attached padded segment">
                    <p>
                        <span>孫子類別</span>
                        <span style="float: right;">共有 5 項商品</span>
                    </p>
                </div>
                <div class="ui bottom attached buttons">
                    <!-- 刪除按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
                    <div class="ui negative button" onclick="location.href='new_category.php'">刪除該類別</div>
                    <!-- 新增按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
                    <div class="ui positive button" onclick="location.href='new_category.php'">新增子類別</div>
                </div>
            </div>
            <div class="ui attached padded segment">
                <p>
                    <span>子類別</span>
                    <span style="float: right;">共有 5 項商品</span>
                </p>
            </div>
            <div class="ui bottom attached buttons">
                <!-- 刪除按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
                <div class="ui negative button" onclick="location.href='new_category.php'">刪除該類別</div>
                <!-- 新增按鈕，不一定要有作用，只有在可以刪除的時候有用（沒有子項目） -->
                <div class="ui positive button" onclick="location.href='new_category.php'">新增子類別</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>