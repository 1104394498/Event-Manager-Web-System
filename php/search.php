<?php
require_once "functions.php";
require_once "params.php";
require_once "generateHTML.php";

$json_string = file_get_contents('../mysql_account.json');
$mysql_account = json_decode($json_string, true);

$conn = mysqli_connect($mysql_account["host"], $mysql_account["user"], $mysql_account["password"]);

$type = $_POST["type"];
if (!$conn) {
    mysqli_close($conn);
    die(json_encode(["status" => "fail"]));
}

global $database_name;
mysqli_select_db($conn, $database_name);

$html = generateHTML($conn, $type);

echo $html;
mysqli_close($conn);

global $currentStatus;
$currentStatus = $type;
?>
