<?php
require_once "functions.php";

// today, plan, anytime, finished, create

$json_string = file_get_contents('../mysql_account.json');
$mysql_account = json_decode($json_string, true);

$conn = mysqli_connect($mysql_account["host"], $mysql_account["user"], $mysql_account["password"]);

$type = $_POST["type"];
if (!$conn) {
    mysqli_close($conn);
    die(json_encode(["status" => "fail"]));
}

$html = "";

if ($type === "all") {
    $html = "<h1>所有日程</h1>";
    global $database_name;
    mysqli_select_db($conn, $database_name);
    $data = searchAll($conn);
} else if ($type === "ddl") {
    $html = "<h1>即将到期</h1>";
    //未完成
} else { // if($type === "finished") {
    $html = "<h1>已完成</h1>";
    // 未完成
}

$data = json_decode($data);
$html .=
    "<div class=\"timeline-container\">
        <ul class=\"timeline\">";

$i = 0;
foreach ($data as $item) {
    if ($i % 3 == 0) {
        $html .= sprintf(
            "<li class=\"timeline-item\">
                <div class=\"indicator\">
                    <div class=\"inner-dot\"></div>
                </div>
                <div class=\"event\">
                    <div class=\"icon-container tomato-red\">
                        <i class=\"fa fa-stethoscope fa-3x\"></i>
                    </div>
                    <div class=\"description-container\">
                        <h4>%s</h4>
                        <span>%s 至 %s</span>
                    </div>
                </div>
            </li>", $item->EventName,  $item->BeginTime,  $item->EndTime);
    } else if ($i % 3 == 1) {
        $html .= sprintf(
            " <li class=\"timeline-item\">
                <div class=\"indicator\">
                    <div class=\"inner-dot\"></div>
                </div>
                <div class=\"event\">
                    <div class=\"icon-container bright-blue\">
                        <i class=\"fa fa-user fa-3x\"></i>
                    </div>
                    <div class=\"description-container\">
                        <h4>%s</h4>
                        <span>%s 至 %s</span>
                    </div>
                </div>
            </li>", $item->EventName,  $item->BeginTime,  $item->EndTime);
    } else {
        $html .= sprintf(
            " <li class=\"timeline-item\">
                <div class=\"indicator\">
                    <div class=\"inner-dot\"></div>
                </div>
                <div class=\"event\">
                    <div class=\"icon-container green-ish\">
                        <i class=\"fa fa-car fa-2x\"></i>
                    </div>
                    <div class=\"description-container\">
                        <h4>%s</h4>
                        <span>%s 至 %s</span>
                    </div>
                </div>
            </li>", $item->EventName, $item->BeginTime, $item->EndTime);
    }

    $i++;
}

$html .=
    "       </ul>
    </div>";
echo $html;
mysqli_close($conn);
?>
