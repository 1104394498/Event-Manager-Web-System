$(document).ready(function () {
    $("li.today").click(function () {
        $.post("php/click.php",
            {type: "today"},
            function (data, status) {
                alert('数据:\n' + data + "\n状态" + status);
            })
    });
    $("li.plan").click(function () {
        $.post("php/click.php",
            {type: "plan"},
            function (data, status) {
                //alert('数据:\n' + data + "\n状态" + status);
            })
    });
    $("li.anytime").click(function () {
        $.post("php/click.php",
            {type: "anytime"},
            function (data, status) {
                alert('数据:\n' + data + "\n状态" + status);
            })
    });
    $("li.finished").click(function () {
        $.post("php/click.php",
            {type: "finished"},
            function (data, status) {
                alert('数据:\n' + data + "\n状态" + status);
            })
    });
    $("li.create").click(function () {
        $.post("php/click.php",
            {type: "create"},
            function (data, status) {
                alert('数据:\n' + data + "\n状态" + status);
            })
    });
});