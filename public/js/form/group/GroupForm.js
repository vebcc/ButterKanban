$(function () {
    $("div.droptrue").sortable({
        connectWith: ".task-list",
    });

    $("div.dropfalse").sortable({
        connectWith: ".task-list",
        dropOnEmpty: false
    });

    let sortable = $(".ui-sortable");

    sortable.disableSelection();

    sortable.on('sortchange', function (event, ui) {
        updateHiddenForm(event, ui);
    });

});