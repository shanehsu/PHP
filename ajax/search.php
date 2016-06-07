<?php

// Function That Returns Search Result Of Some Query String

$queryString = $_GET['query'];

include './../util/connect.php';

$result = [];
$ids = [];

function search($field) {
    global $mysqli;
    global $queryString;
    global $result;
    global $ids;

    $field = 'products.' . $field;

    $q1 = "{$queryString}%";
    $q2 = "%{$queryString}%";
    $q3 = "%{$queryString}";

    $stmt = $mysqli -> prepare("SELECT products.id, products.name, products.price, products.description, products.detail, categories.name
      FROM group_12.products, group_12.categories
      WHERE categories.id = products.categories AND " . $field . " LIKE ? OR " . $field . " LIKE ? OR " . $field . " LIKE ?"); //AND ? LIKE ? AND ? LIKE ?');

    $stmt -> bind_param('sss', $q1, $q2, $q3);

    $stmt -> bind_result($id, $name, $price, $description, $detail, $category);
    $stmt -> execute();

    while ($stmt -> fetch()) {
        if (!in_array($id, $ids)) {
            $ids[] = $id;
            $result[] = [
                'url' => 'product.php?id=' . $id,
                'title' => $name,
                'price' => $price,
                'description' => $description,
                'category' => $category
            ];
        }
    }

    $stmt -> close();
}

search('name');
search('description');
search('detail');

$result = array_slice($result, 0, 10);
$categories = [];

// 先找出有哪幾個類別！
foreach ($result as $r) {
    $cat = $r['category'];
    if (!in_array($cat, $categories)) {
        $categories[] = $cat;
    }
}

// 把每個類別的資料傳進去！
$payload = [];
foreach ($categories as $category) {
    $payload[$category] = [];
    $payload[$category]['name'] = $category;

    foreach ($result as $r) {
        $cat = $r['category'];
        if ($cat == $category) {
            unset($r['category']);
            $payload[$category]['results'][] = $r;
        }
    }
}


header('Content-Type: application/json');
print_r(json_encode(['results' => $payload]));

include './../util/close.php';
