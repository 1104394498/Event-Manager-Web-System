<?php
require_once "functions.php";
$json_string = file_get_contents('../mysql_account.json');
$mysql_account = json_decode($json_string, true);

$conn = mysqli_connect($mysql_account["host"], $mysql_account["user"], $mysql_account["password"]);
global $database_name;
mysqli_select_db($conn, $database_name);

searchDDL($conn);

mysqli_close($conn);