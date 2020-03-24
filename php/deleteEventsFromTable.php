<?php
require_once "params.php";
require_once "functions.php";
require_once "generateHTML.php";

$json_string = file_get_contents('../mysql_account.json');
$mysql_account = json_decode($json_string, true);

$conn = mysqli_connect($mysql_account["host"], $mysql_account["user"], $mysql_account["password"]);

global $database_name, $table_name, $finished_table_name;
mysqli_select_db($conn, $database_name);

if (!empty($_POST)) {
    foreach ($_POST["id"] as $id) {
        $sql = "DELETE FROM " . $table_name . " WHERE " . "ID='" . $id . "'";
        mysqli_query($conn, $sql);
    }
}

mysqli_close($conn);

$url = $_SERVER['PHP_SELF'];

$url = substr($url, 0, strlen($url) - strlen("php/deleteEventsFromTable.php"));

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