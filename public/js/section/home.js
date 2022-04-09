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
                        date
                        user{
                          name
                          email
                        }
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

    $(".show-comment").click(function () {
        $('.task-comments').show();
        $('.task-front').hide();
    });
    $(".hide-comment").click(function () {
        $('.task-comments').hide();
        $('.task-front').show();
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

        data["data"]["task"]["taskUsers"].forEach(findUsers);

        let comments = data["data"]["task"]["taskComments"]["edges"];
        $(".comment-one-row").remove();
        if(comments.length){
            $(".hidden-example-comment").show();
            data["data"]["task"]["taskComments"]["edges"].forEach(putComments);
        }else{
            $(".hidden-example-comment").hide();
        }


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

    function putComments(item, key){
        console.log(item);
        let exampleComment = $(".hidden-example-comment");
        if(key === 0){
            console.log(exampleComment);
            exampleComment.find(".comment-name-time").html(parseDate(item["node"]["date"]));
            exampleComment.find(".comment-user-name").html(item["node"]["user"]["name"]);
            exampleComment.find(".comment-name-list").html(item["node"]["comment"]);
        }else{
            let cloneComment = exampleComment.clone();
            cloneComment.find(".comment-name-time").html(parseDate(item["node"]["date"]));
            cloneComment.find(".comment-user-name").html(item["node"]["user"]["name"]);
            cloneComment.find(".comment-name-list").html(item["node"]["comment"]);
            cloneComment.removeClass("hidden-example-comment").addClass("comment-one-row");

            exampleComment.after(cloneComment);
        }
    }

    function parseDate(dateString){
        let date = new Date(dateString)
        let month = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Pazdziernik", "Listopad", "Grudzień"];
        return date.getDate() + " " + month[date.getMonth()] + " " + date.getFullYear();
    }
});

//TODO: kolorowanie grup