<?php
require_once "params.php";
require_once "functions.php";
require_once "generateHTML.php";

$json_string = file_get_contents('../mysql_account.json');
$mysql_account = json_decode($json_string, true);

$conn = mysqli_connect($mysql_account["host"], $mysql_account["user"], $mysql_account["password"]);

global $database_name, $table_name, $finished_table_name;
mysqli_select_db($conn, $database_name);

$field = "ID, EventName, BeginTime, EndTime";

if (!check_table_is_exist($conn, $finished_table_name)) {
    // 创建已完成表
    $sql = "CREATE TABLE " . $finished_table_name . " (
    ID varchar(256),
    EventName varchar(128),
    BeginTime varchar(64), 
    EndTime varchar(64))";
    if (!mysqli_query($conn, $sql)) {
        // die("creating table " . $table_name . " fails\n");
        $ret = ["status" => "fail"];
        echo json_encode($ret);
        return;
    }
}
// echo "lalala";
if (!empty($_POST)) {
    foreach ($_POST["id"] as $id) {
        $sql = "INSERT INTO " . $finished_table_name . "(" . $field . ")" . " SELECT " . $field . " FROM " . $table_name . " WHERE " . "ID='" . $id . "'";
        // echo $sql."\n";
        mysqli_query($conn, $sql);
        $sql = "DELETE FROM " . $table_name . " WHERE " . "ID='" . $id . "'";
        mysqli_query($conn, $sql);
    }
}

/*
$html = file_get_contents("../index.html");
$html = preg_replace("/[\t\n\r]+/", "", $html); // 去除空白符
//(?<=expr1)
$pattern = '/(?<=<div class="container" style="overflow: scroll">)(.*)(?=<\/div>)/';
// $decode_html = htmlspecialchars_decode($html);
preg_match_all($pattern, $html, $match);

global $currentStatus;
$replacement = generateHTML($conn, $currentStatus);

if (!empty($match[1])) {
    echo preg_replace($pattern, $replacement, $html);
}
*/

mysqli_close($conn);


$url = $_SERVER['PHP_SELF'];

$url = substr($url, 0, strlen($url) - strlen("php/finishEvents.php"));

$html = sprintf("
    <html>   
<head>   
<meta http-equiv=\"refresh\" content=\"0;url=%s\">   
</head>   
<body> 
It's transit station.
</body>
</html>
", $url);

echo $html;
