<?php
// today, plan, anytime, finished, create
    header('Content-Type:application/json');

    $type = $_POST["type"];
    $conn = mysqli_connect("localhost", "root", "wsz-dashuaige");
    if (!$conn) {
        echo json_encode(["mysql" => 0]);
    } else {
        if ($type === "today") {
            $data = ["today" => "lalala"];
            echo json_encode("lala");
        } else if ($type === "plan") {
            echo json_encode("lalalla");
        } else if ($type === "anytime") {

        } else if ($type === "finished") {

        } else if ($type === "create") {

        }
    }
    mysqli_close($conn);

?>
