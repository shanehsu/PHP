<?php
include './../util/UserAuthenticationRequired.php';
?>

<?php
include './../util/connect.php';

session_start();
$uid = intval($_SESSION['_ID']);
session_write_close();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $mysqli -> prepare('SELECT item, name, thumbnail, quantity, price
              FROM group_12.cart, group_12.products
              WHERE products.id = item AND cart.member = ?');

    $stmt -> bind_param('d', $uid);
    $stmt -> bind_result($iid, $iname, $iimage, $quantity, $price);
    $stmt -> execute();

    $result = array();

    while ($stmt -> fetch()) {
        $result[] = array(
            'itemID' => $iid,
            'itemName' => $iname,
            'itemImage' => $iimage,
            'itemPrice' => $price,
            'quantity' => $quantity
        );
    }
    header('Content-Type: application/json');
    echo json_encode($result);

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = file_get_contents('php://input');
    $payload = json_decode($body, true);
    $action = $payload['action'];

    if ($action == 'insert') {
        $item = $payload['itemID'];

        $stmt = $mysqli -> prepare('SELECT item FROM group_12.cart WHERE item = ? AND member = ?');
        $stmt -> bind_param('dd', $item, $uid);
        $stmt -> bind_result($test_item);
        $stmt -> execute();
        $stmt -> fetch();
        $stmt -> close();

        if ($test_item == $item) { exit(); }

        $stmt = $mysqli -> prepare('INSERT INTO cart(member, item, quantity) VALUES (?, ?, 1)');
        $stmt -> bind_param('dd', $uid, $item);
        if ($stmt -> execute()) {
            echo 'true';
        } else {
            die($mysqli -> error);
        }
    } else if ($action == 'update') {
        $item = $payload['itemID'];
        $quantity = $payload['quantity'];

        if ($quantity > 0) {
            $stmt = $mysqli->prepare('UPDATE cart SET quantity = ? WHERE member = ? AND item = ?');
            $stmt->bind_param('ddd', $quantity, $uid, $item);
            if ($stmt->execute()) {
                echo 'true';
            } else {
                die($mysqli->error);
            }
        } else {
            $stmt = $mysqli->prepare('DELETE FROM cart WHERE member = ? AND item = ?');
            $stmt->bind_param('dd', $uid, $item);
            if ($stmt->execute()) {
                echo 'true';
            } else {
                die($mysqli->error);
            }
        }
    } else if ($action == 'remove') {
        $item = $payload['itemID'];

        $stmt = $mysqli->prepare('DELETE FROM cart WHERE member = ? AND item = ?');
        $stmt->bind_param('dd', $uid, $item);
        if ($stmt->execute()) {
            echo 'true';
        } else {
            die($mysqli->error);
        }
    } else if ($action == 'clear') {
        $stmt = $mysqli->prepare('DELETE FROM cart WHERE member = ?');
        $stmt -> bind_param('d', $uid);
        if ($stmt->execute()) {
            echo 'true';
        } else {
            die($mysqli->error);
        }
    }
}

include './../util/close.php';