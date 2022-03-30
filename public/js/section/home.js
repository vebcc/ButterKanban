$(document).ready(function () {

    $(".card-body").click(function () {
        let modal = $("#TaskModal");
        let id = $(this).data("id");
        console.log(id);
        //modal.find("#cocktailid").val($(this).data("id"));
        sendAjaxRequest("GET", "/api/tasks/"+id, '', 'application/merge-patch+json', modal);

    });

    function sendAjaxRequest(method, url, data, contentType, modal)
    {
        $.ajax({
            method: method,
            url: url,
            data: data,
            dataType: 'json',
            contentType: contentType,
            success: function(data) {
                console.log(data);
                writeToModal(modal, data);
            }
        });
    }

    function writeToModal(modal, data){
        modal.find(".taskName").html(data["tittle"]);
        modal.find(".taskComment").html(data["comment"]);
    }

});