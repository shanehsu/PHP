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

    <style>
    </style>

    <script>
        // 載入資料
        function load() {
            $.get('category_ajax.php').then(function(response) {
                // 伺服器回傳資料，檢查是否成功
                if (response['success']) {
                    return response['results']
                } else {
                    return $.Deferred().reject(response['reason'])
                }
            }).then(function(results) {
                console.dir(results)
            }).fail(function(reason) {
                console.error(reason)
                $('#load-error-modal').modal('show');
            })
        }

        $(function() {
            // 設定無法載入資料時
            // 所顯示的 Modal
            $('#load-error-modal').modal({
                // 使用者一定要按其中兩個按鈕，才能夠繼續
                closable: false,

                // 只是好像很好玩而已
                transition: 'drop',

                // 因為使用 basic 樣式會變得很奇怪，
                // 所以關掉
                // blurring: true,

                // 按下重新載入的 Callback
                onApprove: function() {
                    // 再一次試圖載入
                    load()
                },

                // 按下取消的 Callback
                onDeny: function() {
                    // 應該在表格顯示畫面
                }

            })

            load();
        })
    </script>
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

    <div class="basic ui segment">
        <table class="ui celled structured table">
            <thead id="header">
            <tr>
                <th colspan="3" style="width: 45%">名稱</th>
                <th style="width: 25%;">產品數量</th>
                <th style="width: 30%;">動作</th>
            </tr>
            </thead>
            <tbody id="content">
            </tbody>
        </table>
    </div>
</div>

<div id="load-error-modal" class="ui basic small modal">
    <h2 class="ui red icon header">
        <i class="warning icon"></i>
        <div style="padding-left: 0;" class="content">錯誤</div>
    </h2>
    <div class="centered content">
        <p>載入資料時發生錯誤，是否重新載入？</p>
    </div>
    <div class="actions">
        <div style="color: black;" class="ui yellow cancel button">取消</div>
        <div class="ui blue approve button">重新載入</div>
    </div>
</div>
</body>
</html>
