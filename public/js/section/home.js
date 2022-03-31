$(document).ready(function () {
    let superQuery = `query ($id: ID!){
            task(id: $id){
                id
                tittle
                startData
                comment
                taskUsers {
                    user{
                        name
                    }
                    taskUserType{
                        name
                    }
                }
                taskComments{
                    comment
                }
            }
        }`;

    $(".card-body").click(function () {
        let modal = $("#TaskModal");
        let id = $(this).data("id");
        console.log(id);
        data = parseToSend(superQuery, id, "/api/tasks/")
        sendAjaxRequest("POST", "/api/graphql", data, 'application/json', modal);
    });

    function sendAjaxRequest(method, url, data, contentType, modal) {
        console.log(data);
        $.ajax({
            method: method,
            url: url,
            data: data,
            contentType: contentType,
            success: function (data) {
                console.log(data);
                writeToModal(modal, data);
            }
        });
    }

    function writeToModal(modal, data) {
        modal.find(".taskName").html(data["tittle"]);
        modal.find(".taskComment").html(data["comment"]);
    }


    function parseToSend(data, id, repository){
        return JSON.stringify({
            query: data,
            variables: {
                "id": repository+id
            }
        });
    }
});