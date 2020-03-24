<?php
require_once "functions.php";

function generateHTML($conn, $type)
{
    if ($type === "all") {
        $html = "<h1>未完成日程</h1>";
        $data = searchAll($conn);
    } else if ($type === "ddl") {
        $html = "<h1>即将到期</h1>";
        $data = searchDDL($conn);
    } else if ($type === "expired") {
        $html = "<h1>已过期</h1>";
        $data = searchExpired($conn);
    } else { //$type === "finished"
        $html = "<h1>已完成</h1>";
        $data = searchFinished($conn);
    }

    $data = json_decode($data);
    if ($type === "all" || $type === "ddl") {
        $html .=
            "<div class=\"timeline-container\">
        <ul class=\"timeline\">
            <form id='selectEvents' action='' name='chooseEvents' method='post'>
                <center>
                <button onclick='finishEvents()' class=\"layui-btn layui-btn-normal\">完成日程</button>
                <button onclick='deleteEventsFromTable()' class=\"layui-btn layui-btn-normal\">删除日程</button>
                </center>>";

    } else if ($type === "finished") {
        $html .=
            "<div class=\"timeline-container\">
        <ul class=\"timeline\">
            <form id='selectEvents' action='' name='chooseEvents' method='post'>
                <center>
                <button onclick='' class=\"layui-btn layui-btn-disabled\">完成日程</button>
                <button onclick='deleteEventsFromFinishedTable()' class=\"layui-btn layui-btn-normal\">删除日程</button>
                </center>>";
    } else {
        $html .=
            "<div class=\"timeline-container\">
        <ul class=\"timeline\">
            <form id='selectEvents' action='' name='chooseEvents' method='post'>
                <center>
                <button onclick='' class=\"layui-btn layui-btn-disabled\">完成日程</button>
                <button onclick='deleteEventsFromTable()' class=\"layui-btn layui-btn-normal\">删除日程</button>
                </center>
          
                ";
    }
//<input name="checkbox" type="checkbox" value="checkbox" checked="checked" />
    $i1 = 0;
    foreach ($data as $item) {
        if ($type === "all" || $type === "ddl") {
            $i = $i1;
        } else {
            $i = $i1 + 2;
        }
        if ($i % 3 == 0) {
            $html .= sprintf(
                "<li class=\"timeline-item\">
                <div class=\"indicator\">
                    <div class=\"inner-dot\"></div>
                </div>
                <div class=\"event\">
                    <div class=\"icon-container tomato-red\">
                        <i class=\"fa fa-stethoscope fa-3x\"></i>
                        <input name=\"id[]\" value=\"%s\" type=\"checkbox\" />
                    </div>
                    <div class=\"description-container\">
                        <h4>%s</h4>
                        <span>%s 至 %s</span>
                    </div>
                </div>
            </li>", $item->ID, $item->EventName, $item->BeginTime, $item->EndTime);
        } else if ($i % 3 == 1) {
            $html .= sprintf(
                " <li class=\"timeline-item\">
                <div class=\"indicator\">
                    <div class=\"inner-dot\"></div>
                </div>
                <div class=\"event\">
                    <div class=\"icon-container bright-blue\">
                        <i class=\"fa fa-user fa-3x\"></i>
                        <input name=\"id[]\" value=\"%s\" type=\"checkbox\"  />
                    </div>
                    <div class=\"description-container\">
                        <h4>%s</h4>
                        <span>%s 至 %s</span>
                    </div>
                </div>
            </li>", $item->ID, $item->EventName, $item->BeginTime, $item->EndTime);
        } else {
            $html .= sprintf(
                " <li class=\"timeline-item\">
                <div class=\"indicator\">
                    <div class=\"inner-dot\"></div>
                </div>
                <div class=\"event\">
                    <div class=\"icon-container green-ish\">
                        <i class=\"fa fa-car fa-2x\"></i>
                        <input name=\"id[]\" value=\"%s\" type=\"checkbox\" />
                    </div>
                    <div class=\"description-container\">
                        <h4>%s</h4>
                        <span>%s 至 %s</span>
                    </div>
                </div>
            </li>", $item->ID, $item->EventName, $item->BeginTime, $item->EndTime);
        }

        $i1++;
    }

    $html .=
        "  </form>
       </ul>
    </div>";
    return $html;
}