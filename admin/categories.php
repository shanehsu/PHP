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
        var defaultResponseParser = function(response) {
            // 伺服器回傳資料，檢查是否成功
            if (response['success']) {
                return response['results']
            } else {
                return $.Deferred().reject(response['reason'])
            }
        }
        // 載入資料
        function newRoot() {
            var modal = $('#add-or-edit-category-modal')
            modal.data().operation = 'add'
            modal.modal('show')
        }
        function load() {
            return new Promise(function(resolve, reject) {
                $('#segment').addClass('loading')
                $.get('category_ajax.php').then(defaultResponseParser).then(function(results) {
                    // 摺疊成多層
                    // 先找出 Root
                    var roots = results.filter(function(category) {
                        return category.parent == null
                    })

                    console.dir(roots)

                    // 工具程式
                    var findChildren = function(id) {
                        children = []
                        var children = results.filter(function(category) {
                            return category.parent == id
                        })

                        for (var child of children) {
                            child.children = findChildren(child.id)
//                        child.depth = child.children.reduce(function(max, val) {
//                            return Math.max(val.depth + 1, max);
//                        }, 1)
                        }

                        return children
                    }

                    for (var root of roots) {
                        root.children = findChildren(root.id)
//                    root.depth = root.children.reduce(function(max, val) {
//                        return Math.max(val.depth + 1, max)
//                    }, 1)
                    }

                    $('#content').data(results);

                    return roots
                }).then(function(roots) {
                    var body = $('#content')

                    var htmlForElement = function(element, forwardDepth) {
                        var markup = `<tr data-id="${element.id}">`
                        if (forwardDepth > 0) {
                            markup += `<td colspan=${forwardDepth}></td>`
                        }
                        markup += `<td style="width: ${25 * (3 - forwardDepth)}%;"colspan=${3 - forwardDepth}>${element.name}</td>
                               <td>${element.itemCount}</td>
                               <td><div class="ui icon buttons">
                                   <button onclick="action(this, 'add')" class="basic green ui button">
                                       <i class="plus icon"></i>
                                   </button>
                                   <button onclick="action(this, 'edit')" class="basic yellow ui button">
                                       <i class="edit icon"></i>
                                   </button>
                                   <button onclick="action(this, 'remove')" class="basic red ui button">
                                       <i class="remove icon"></i>
                                   </button>
                               </div></td>
                               </tr>`;

                        return element.children.reduce(function(accu, child) {
                            return accu + htmlForElement(child, forwardDepth + 1)
                        }, markup);
                    }

                    body.empty()

                    for (var root of roots) {
                        body.append($(htmlForElement(root, 0)))
                    }

                    $('body div.ui.container').append($(`<div class="ui segment"><pre id="json"></pre></div>`))
                    $('#json').append(JSON.stringify(roots, null, 4))

                    $('#segment').removeClass('loading')
                    $('#operation-success-modal').modal('hide')

                    resolve()
                }).fail(function(reason) {
                    $('#load-error-modal').modal('show')
                    reject(reason)
                })
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
                    // TODO 應該在表格顯示畫面
                }

            })

            $('#add-or-edit-category-modal').modal({
                transition: 'drop',
                onShow: function() {
                    var host = $('#add-or-edit-category-modal')
                    // 從自我資料讀取設定
                    var operation = host.data().operation

                    switch (operation) {
                        case 'add':
                            host.find('div.header').text('新分類')
                            break
                        case 'edit':
                            host.find('div.header').text('編輯分類')
                            break
                    }
                },
                onApprove: function() {
                    var host = $('#add-or-edit-category-modal')
                    // 從自我資料讀取設定
                    var operation = host.data().operation
                    switch (operation) {
                        case 'add':
                            if (host.find('input').val() == '') {
                                $('#operation-failed-modal').data().message = '請輸入新分類名稱'
                                $('#operation-failed-modal').modal('show')
                            } else {
                                var id = host.data().parent
                                var payload = {
                                    action: 'insert',
                                    name: host.find('input').val()
                                }
                                if (id) {
                                    payload.parent = id
                                }
                                $.ajax({
                                    url: 'category_ajax.php',
                                    method: 'POST',
                                    data: JSON.stringify(payload),
                                    contentType: 'application/json; charset=utf-8',
                                    beforeSend: function() {
                                        host.find('div.approve').addClass('loading')
                                    }
                                }).then(defaultResponseParser).then(function() {
                                    load().then(function() {
                                        host.find('div.approve').removeClass('loading')
                                        host.modal('hide')
                                        $('#operation-success-modal').modal('show')
                                    })
                                }).fail(function() {
                                    $('#operation-failed-modal').modal('show')
                                })
                            }
                            break
                        case 'edit':
                            if (host.find('input').val() == '') {
                                $('#operation-failed-modal').data().message = '請輸入新分類名稱'
                                $('#operation-failed-modal').modal('show')
                            } else {
                                var id = host.data().id
                                var payload = {
                                    action: 'edit',
                                    name: host.find('input').val(),
                                    id: id
                                }
                                $.ajax({
                                    url: 'category_ajax.php',
                                    method: 'POST',
                                    data: JSON.stringify(payload),
                                    contentType: 'application/json; charset=utf-8',
                                    beforeSend: function() {
                                        host.find('div.approve').addClass('loading')
                                    }
                                }).then(defaultResponseParser).then(function() {
                                    load().then(function() {
                                        host.find('div.approve').removeClass('loading')
                                        host.modal('hide')
                                        $('#operation-success-modal').modal('show')
                                    })
                                }).fail(function() {
                                    $('#operation-failed-modal').modal('show')
                                })
                            }
                            break
                    }

                    return false
                }
            })

            $('#remove-category-modal').modal({
                transition: 'drop',
                onApprove: function() {
                    var host = $('#remove-category-modal')
                    var id = host.data().id

                    var payload = {
                        action: 'delete',
                        id: id
                    }

                    $.ajax({
                        url: 'category_ajax.php',
                        method: 'POST',
                        data: JSON.stringify(payload),
                        contentType: 'application/json; charset=utf-8',
                    }).then(defaultResponseParser).then(function() {
                        load()
                        $('#operation-success-modal').modal('show')
                    }).fail(function() {
                        $('#operation-failed-modal').modal('show')
                    })
                }
            })
            $('#operation-success-modal').modal({
                transition: 'drop'
            })
            $('#operation-failed-modal').modal({
                transition: 'drop'
            })
            load();
        })

        function action(element, operation) {
            var id = $(element).closest('tr').data('id')

            switch (operation) {
                case 'add':
                    var modal = $('#add-or-edit-category-modal')
                    modal.data().operation = 'add'
                    modal.data().parent = id
                    modal.modal('show')
                    break
                case 'edit':
                    var modal = $('#add-or-edit-category-modal')
                    modal.data().operation = 'edit';
                    modal.data().id = id
                    modal.modal('show')
                    break
                case 'remove':
                    var modal = $('#remove-category-modal')
                    modal.data().id = id
                    modal.modal('show')
                    break
            }
        }
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

    <div id="segment" class="basic loading ui segment">
        <table style="" class="ui celled structured table">
            <thead id="header">
            <tr>
                <th colspan="3" style="width: 75%">名稱</th>
                <th style="width: 10%;">產品</th>
                <th style="width: 15%; min-width: 15em;">編輯</th>
            </tr>
            </thead>
            <tbody id="content">
            </tbody>
            <tfoot>
            <tr>
                <th colspan="5">
                    <div class="ui blue button" onclick="newRoot()">新增</div>
                </th>
            </tr>
            </tfoot>
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
<div id="add-or-edit-category-modal" class="ui small modal">
    <div class="header"></div>
    <div class="content">
        <form class="ui form">
            <div class="required field">
                <label>分類名稱</label>
                <input type="text" name="name" placeholder="分類名稱">
            </div>
        </form>
    </div>
    <div class="actions">
        <div id="" class="approve ui green button">新增</div>
    </div>
</div>
<div id="remove-category-modal" class="ui basic small modal">
    <h2 class="ui red icon header">
        <i class="remove icon"></i>
        <div style="padding-left: 0;" class="content">刪除分類</div>
    </h2>
    <div class="centered content">
        <p>確定刪除此分類嗎？</p>
    </div>
    <div class="actions">
        <div class="ui red approve button">確定</div>
    </div>
</div>
<div id="operation-success-modal" class="ui small modal">
    <h2 class="ui green icon header">
        <i class="checkmark icon"></i>
        <div style="padding-left: 0;" class="content">操作成功</div>
    </h2>
</div>
<div id="operation-failed-modal" class="ui small modal">
    <h2 class="ui red icon header">
        <i class="warning icon"></i>
        <div style="padding-left: 0;" class="content">操作錯誤</div>
    </h2>
</div>
</body>
</html>
