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
        updateDatabase(event, ui);
    });

    function updateDatabase(event, ui) {
        if (ui.sender) {
            let taskId = ui.item[0].id.split('-')[1];
            let oldQueueId = ui.sender[0].id.split('-')[1];
            let newQueueId = event.target.id.split('-')[1];
            console.log("Old queue ID: "+oldQueueId);
            console.log("New queue ID: "+newQueueId);
            console.log("Task ID: "+taskId);
            sendAjaxRequest("PATCH", "/api/tasks/"+taskId, '{"queue": "api/task_queues/'+newQueueId+'"}', 'application/merge-patch+json');
        }
    }

    function sendAjaxRequest(method, url, data, contentType) {
        $.ajax({
            method: method,
            url: url,
            data: data,
            dataType: 'json',
            contentType: contentType,
            success: function(msg) {
                console.log(msg);
            }
        });
    }

});