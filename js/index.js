$(document).ready(function () {
    $("li.all").click(function () {
        $.post("php/search.php",
            {type: "all"},
            function (data) {
                $(".container").html(data);
            })
    });
    $("li.ddl").click(function () {
        $.post("php/search.php",
            {type: "ddl"},
            function (data) {
                $(".container").html(data);
            })
    });
    $("li.finished").click(function () {
        $.post("php/search.php",
            {type: "finished"},
            function (data) {
                $(".container").html(data);
            })
    });
    $("li.expired").click(function () {
        $.post("php/search.php",
            {type: "expired"},
            function (data) {
                $(".container").html(data);
            })
    });

    // 新建日程的响应
    $("#createEventForm").ajaxForm(function (data, status) {
        // 已经解码了
        if (data["status"] === "success") {
            alert("新建日程成功!");
        } else {
            alert("新建日程失败!");
        }

    });


    // 完成日程的响应
    $("#selectEvents").ajaxForm(function (data) {
        print("lalala");
        // $(".container").html(data);
        /*
        var css = document.getElementByIdx_x("indexCss");
        css.setAttribute("href", "css/style.css");
        $("body").html(data);
        */
        //document.location.href = location.href.substr(0, location.href.length - "php/finishEvents.php".length);
        //history.pushState(null, null, location.href.substr(0, location.href.length - "php/finishEvents.php".length));
        //$("html").html(data);
    });
});