<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/3
 * Time: 下午6:11
 */

// GET request with a ID query (id)

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET["id"])) {
        // 抓取資料庫內容

        include "util/connect.php";

        global $mysqli;

        $id = intval($_GET["id"]);

        $statement = $mysqli -> prepare("SELECT * FROM images WHERE id = ?");

        $statement -> bind_param("d", $id);
        $statement -> execute();

        $statement -> bind_result($id, $original, $filename);
        $statement -> fetch();

        include "util/close.php";

        // echo $filename;
        // echo "<br />";

        // 確認檔案存在
        $path = $_SERVER["DOCUMENT_ROOT"] . "/images/{$filename}";

        if (!file_exists($path)) {
            die("圖片檔案不存在。");
        }

        $image = fopen($path, 'rb');
        $size  = filesize($path);

        //  寫 Header
        header("Content-Type: image/jpeg");
        // header("Content-Length: {$size}");
        // header("Content-Disposition: inline");
        // header("filename={$original}");

        // 回傳檔案
        fpassthru($image);
        // echo $path;
        // echo "<br />";
        // echo file_exists($path) ? "true" : "false";
    } else {
        die("必須有 id 查詢。");
    }
} else {
    die("錯誤的 HTTP 方法，必須是 GET。");
}
?>