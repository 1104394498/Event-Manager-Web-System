<?php
require_once "params.php";
require_once "functions.php";

header('Content-Type:application/json; charset=utf-8');

$event_name = $_POST["eventName"];
$event_begin_time = $_POST["beginTime"];
$event_end_time = $_POST["endTime"];

$json_string = file_get_contents('../mysql_account.json');
$mysql_account = json_decode($json_string, true);

$conn = mysqli_connect($mysql_account["host"], $mysql_account["user"], $mysql_account["password"]);

if (!$conn) {
    // die("连接失败：" . mysqli_error($conn) . "\n");
    mysqli_close($conn);
    die(json_encode(["status" => "fail"]));
}

// 检查数据库是否存在，如果不存在则新建数据库
global $database_name;

if (!check_database_is_exist($conn, $database_name)) {
    // print("Database does not exist");
    $sql = "CREATE DATABASE " . $database_name;
    if (!mysqli_query($conn, $sql)) {
        // die("creating database " . $database_name . " fails\n");
        mysqli_close($conn);
        die(json_encode(["status" => "fail"]));
    }
}

mysqli_select_db($conn, $database_name);

global $table_name;

if (!check_table_is_exist($conn, $table_name)) {
    // 创建表
    $sql = "CREATE TABLE " . $table_name . " (
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

$sql = sprintf("INSERT INTO " . $table_name . " (ID, EventName, BeginTime, EndTime) VALUES ('%s', '" .
    $event_name . "', '" . $event_begin_time . "', '" . $event_end_time . "')", md5(uniqid()));

if (!mysqli_query($conn, $sql)) {
    // echo "insert fail\n";
    mysqli_close($conn);
    die(json_encode(['status' => 'fail']));
}

mysqli_close($conn);
?>