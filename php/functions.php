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

function diffBetweenTwoDays($day1, $day2)
{
    // 计算day1 - day2相差的天数
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);
    /*
    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }
    */
    return ($second1 - $second2) / 86400;
}

function searchDDL($conn)
{
    // 需要保证$conn已经连接了table
    global $table_name;
    $sql = "SELECT * FROM " . $table_name;
    $result = mysqli_query($conn, $sql);

    $ret = array();
    while ($row = mysqli_fetch_array($result)) {
        $endTime = $row['EndTime'];
        $today = date("Y-m-d H:i");
        $dayGap = diffBetweenTwoDays($endTime, $today);
        if ($dayGap >= 0 && $dayGap <= 3)
            $ret[] = ['ID' => $row['ID'], 'EventName' => $row['EventName'], 'BeginTime' => $row['BeginTime'], 'EndTime' => $row['EndTime']];
    }

    return json_encode($ret);
}


function searchExpired($conn)
{
    // 需要保证$conn已经连接了table
    global $table_name;
    $sql = "SELECT * FROM " . $table_name;
    $result = mysqli_query($conn, $sql);

    $ret = array();
    while ($row = mysqli_fetch_array($result)) {
        $endTime = $row['EndTime'];
        $today = date("Y-m-d H:i");
        $dayGap = diffBetweenTwoDays($endTime, $today);
        if ($dayGap < 0)
            $ret[] = ['ID' => $row['ID'], 'EventName' => $row['EventName'], 'BeginTime' => $row['BeginTime'], 'EndTime' => $row['EndTime']];
    }

    return json_encode($ret);
}

function searchFinished($conn)
{
    global $finished_table_name;
    $sql = "SELECT * FROM " . $finished_table_name;
    $result = mysqli_query($conn, $sql);

    $ret = array();
    while ($row = mysqli_fetch_array($result)) {
        $ret[] = ['ID' => $row['ID'], 'EventName' => $row['EventName'], 'BeginTime' => $row['BeginTime'], 'EndTime' => $row['EndTime']];
    }

    return json_encode($ret);
}

function send_post($url, $post_data)
{
    $postdata = http_build_query($post_data);
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

