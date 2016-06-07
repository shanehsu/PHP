<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/8
 * Time: 上午4:37
 */

// 確認權限
include 'AdminAuthenticationRequired.php';

// header('Content-Type: application/json');
// echo json_encode($result);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // 取得所有分類
        include_once './../util/connect.php';

        $select_stmt = $mysqli -> prepare('SELECT id, name, parent from categories');
        $select_stmt -> bind_result($id, $name, $parent);
        $select_stmt -> execute();

        $categories = [];

        while ($select_stmt -> fetch()) {
            $categories[] = [
                'id'     => $id,
                'name'   => $name,
                'parent' => $parent
            ];
        }

        $select_stmt -> close();

        foreach ($categories as &$category) {
            $id = $category['id'];

            $stmt_aggr = $mysqli -> prepare('SELECT COUNT(*) FROM group_12.products WHERE categories = ?');
            $stmt_aggr -> bind_param('d', $id);
            $stmt_aggr -> bind_result($count);
            $stmt_aggr -> execute();
            $stmt_aggr -> fetch();
            $stmt_aggr -> close();

            if (is_null($count)){
                $c = 0;
            }

            $category['itemCount'] = $count;
        }

        header('Content-Type: application/json');
        echo json_encode($categories);

        include_once './../util/close.php';

        break;
    case 'POST':
        // 擷取 JSON
        $requestBody = file_get_contents('php://input');
        $body = json_decode($requestBody, true);

        // 確認有 action
        if (!isset($body['action'])) {
            throw new Exception('POST 主體缺乏動作種類（action）');
        }

        $action = $body['action'];

        switch ($action) {
            case 'insert':
                if (!isset($body['name'])) {
                    throw new Exception('POST 主體缺乏新分類名稱（name）');
                }
                if (isset($body['parent'])) {
                    // 是一個子分類
                    $parent = intval($body['parent']);
                    $name = $body['name'];

                    include_once './../util/connect.php';

                    $insert_stmt = $mysqli -> prepare('INSERT INTO categories (name, parent) VALUES (?, ?)');
                    $insert_stmt -> bind_param('sd', $name, $parent);

                    if ($insert_stmt -> execute()) {
                        header('Content-Type: application/json');
                        echo json_encode([
                            'success' => true
                        ]);
                    } else {
                        throw new Exception('資料庫插入失敗');
                    }

                    include_once './../util/close.php';
                } else {
                    // 是頂層分類
                    $name = $body['name'];

                    include_once './../util/connect.php';

                    $insert_stmt = $mysqli -> prepare('INSERT INTO categories (name, parent) VALUES (?, NULL)');
                    $insert_stmt -> bind_param('s', $name);

                    if ($insert_stmt -> execute()) {
                        header('Content-Type: application/json');
                        echo json_encode([
                            'success' => true
                        ]);
                    } else {
                        throw new Exception('資料庫插入失敗');
                    }

                    include_once './../util/close.php';
                }
                break;
            case 'delete':
                if (!isset($body['id'])) {
                    throw new Exception('POST 主體缺乏要被刪除的分類 ID（id）');
                }

                $id = intval($body['id']);

                include_once './../util/connect.php';

                $delete_stmt = $mysqli -> prepare('DELETE FROM categories WHERE id = ?');
                $delete_stmt -> bind_param('d', $id);

                if ($delete_stmt -> execute()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true
                    ]);
                } else {
                    throw new Exception('資料庫刪除失敗');
                }

                include_once './../util/close.php';

                break;
            case 'edit':
                if (!isset($body['id'])) {
                    throw new Exception('POST 主體缺乏新的分類 ID（id）');
                }
                if (!isset($body['name'])) {
                    throw new Exception('POST 主體缺乏新的分類名稱（name）');
                }

                $id = intval($body['id']);
                $newName = $body['name'];

                include_once './../util/connect.php';

                $update_stmt = $mysqli -> prepare('UPDATE categories SET name = ? WHERE id = ?');
                $update_stmt -> bind_param('sd', $newName, $id);

                if ($update_stmt -> execute()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true
                    ]);
                } else {
                    throw new Exception('資料庫更新失敗');
                }

                include_once './../util/close.php';

                break;
            default:
                throw new Exception('伺服器不認識的動作');
        }
        break;
    default:
        throw new Exception("僅支援 GET 或是 POST");
}
