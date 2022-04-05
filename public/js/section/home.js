$(document).ready(function () {
    let mainModal;

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
                taskGroup{
                    name
                }
                taskComments{
                    edges{
                      node{
                        comment
                      }
                    }
                }
            }
        }`;

    $(".card-body").click(function () {
        let modal = $("#TaskModal");
        mainModal = modal;
        let id = $(this).data("id");
        data = parseToSend(superQuery, id, "/api/tasks/")
        sendAjaxRequest("POST", "/api/graphql", data, 'application/json', modal);
    });

    function sendAjaxRequest(method, url, data, contentType, modal) {
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
        modal.find(".taskName").html(data["data"]["task"]["tittle"]);
        modal.find(".taskComment").html(data["data"]["task"]["comment"]);
        modal.find(".taskGroup").html(data["data"]["task"]["taskGroup"]["name"]);

        modal.find(".taskDate").html(parseDate(data["data"]["task"]["startData"]));

        data["data"]["task"]["taskUsers"].forEach(findUsers)
    }


    function parseToSend(data, id, repository){
        return JSON.stringify({
            query: data,
            variables: {
                "id": repository+id
            }
        });
    }

    function findUsers(item){
        switch(item["taskUserType"]["name"]){
            case "Zglaszajacy":
                mainModal.find(".weryfikator").html(item["user"]["name"]);
                break;
            case "Weryfikator":
                mainModal.find(".zglaszajacy").html(item["user"]["name"]);
                break;
        }
    }

    function parseDate(dateString){
        let date = new Date(dateString)
        let month = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Pazdziernik", "Listopad", "Grudzień"];
        return date.getDate() + " " + month[date.getMonth()] + " " + date.getFullYear();
    }
});

//TODO: kolorowanie grup