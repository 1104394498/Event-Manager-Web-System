function finishEvents() {
    document.chooseEvents.action = "php/finishEvents.php";
    document.chooseEvents.submit();
}

function deleteEventsFromTable() {
    document.chooseEvents.action = "php/deleteEventsFromTable.php";
    document.chooseEvents.submit();
}

function deleteEventsFromFinishedTable() {
    document.chooseEvents.action = "php/deleteEventsFromFinishedTable.php";
    document.chooseEvents.submit();
}
