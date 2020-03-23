<?php
require_once "params.php";

function check_database_is_exist($conn, $dbname)
{
    $result = mysqli_query($conn, 'show databases;');
    $data = array();    //用来存在数据库名
    mysqli_data_seek($result, 0);
    while ($dbdate = mysqli_fetch_array($result)) {
        $data[] = $dbdate['Database'];
    }

    mysqli_data_seek($result, 0);
    if (in_array($dbname, $data)) {
        return true;
    } else {
        return false;
    }
}

function check_table_is_exist($conn, $table)
{
    if (mysqli_num_rows(mysqli_query($conn, "SHOW TABLES LIKE '" . $table . "'")) == 1) {
        return true;
    } else {
        return false;
    }
}

function searchAll($conn)
{
    // 需要保证$conn已经连接了table
    global $table_name;
    $sql = "SELECT * FROM " . $table_name;
    // echo $sql;
    $result = mysqli_query($conn, $sql);

    $ret = array();
    while ($row = mysqli_fetch_array($result)) {
        $ret[] = ['ID' => $row['ID'], 'EventName' => $row['EventName'], 'BeginTime' => $row['BeginTime'], 'EndTime' => $row['EndTime']];
    }

    return json_encode($ret);
}




