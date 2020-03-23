$(document).ready(function () {
    $("li.all").click(function () {
        $.post("php/search.php",
            {type: "all"},
            function (data) {
                $(".container").html(data);
            })
    });
    $("li.plan").click(function () {
        $.post("php/search.php",
            {type: "plan"},
            function (data, status) {
                //alert('数据:\n' + data + "\n状态" + status);
            })
    });
    $("li.anytime").click(function () {
        $.post("php/search.php",
            {type: "anytime"},
            function (data, status) {
                alert('数据:\n' + data + "\n状态" + status);
            })
    });
    $("li.finished").click(function () {
        $.post("php/search.php",
            {type: "finished"},
            function (data, status) {
                alert('数据:\n' + data + "\n状态" + status);
            })
    });
    $("li.create").click(function () {
        $.post("php/search.php",
            {type: "create"},
            function (data, status) {
                alert('数据:\n' + data + "\n状态" + status);
            })
    });

    // 新建日程的响应
    $("#createEventForm").ajaxForm(function (data, status) {
        // 已经解码了
        alert(data["status"]);
    });

    function addEventButton() {

    }
});