$(function () {

    let superLogQuery = `query {
          logs(last: 3){
            edges{
              node{
                id
                dateTime
                value
                task{
                  id
                  tittle
                }
                user{
                  id
                  name
                  email
                }
                comment{
                  id
                  comment
                }
                oldQueue{
                  id
                  name
                }
              }
            }
          }
        }`;

    let superCommentQuery = `query {
          taskComments(last: 3){
            edges{
              node{
                id
                date
                comment
                task{
                  id
                  tittle
                }
                user{
                  id
                  name
                  email
                }
              }
            }
          }
        }`;

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

    function sendAjaxRequest(method, url, data, contentType, requestId) {
        $.ajax({
            method: method,
            url: url,
            data: data,
            dataType: 'json',
            contentType: contentType,
            success: function(response) {
                responseController(response, requestId);
            }
        });
    }

    function responseController(response, requestId = 0){
        switch(requestId){
            case 0:
                data = parseToSend(superLogQuery);
                sendAjaxRequest("POST", "/api/graphql", data, 'application/json', 1);
                data = parseToSend(superCommentQuery);
                sendAjaxRequest("POST", "/api/graphql", data, 'application/json', 2);
                break;
            case 1:
                writeLogs(response);
                break;
            case 2:
                writeComments(response);
                break;
        }
    }

    function parseToSend(data){
        return JSON.stringify({
            query: data,
        });
    }

    function writeLogs(data){
        console.log(data);
        data['data']['logs']['edges'].forEach(writeLog)
    }

    function writeComments(data){
        console.log(data);
        data['data']['taskComments']['edges'].forEach(writeComment)
    }

    function writeLog(item, key){
        console.log(key);
        switch(item['node']['value']){
            case 'queueUpdate':
                if(key === 2) {
                    $("#historyLogInfoPrefix").html("Aktualizacja: ");
                }
                $("#historytypetextlist-"+(key+1)).html("Aktualizacja: ");
                break;
            default:

                break;
        }

        if(key === 2){
            $("#historyDate").html(parseDate(item['node']['dateTime']));
            $("#historyLogInfo").html(item['node']['task']['tittle']);
        }

        $("#historynametime-"+(key+1)).html(parseDate(item['node']['dateTime']));
        $("#historynamelist-"+(key+1)).html(item['node']['task']['tittle']);
        console.log("#historynamelist-"+(key+1));
    }

    function writeComment(item, key){
        if(key === 2){
            $("#historyCommentUser").html(item['node']['user']['name']);
            $("#historyCommentDate").html(parseDate(item['node']['date']));
            $("#historyCommentName").html(item['node']['task']['tittle']+': '+ item['node']['comment']);
        }
        $("#commentnameuser-"+(key+1)).html(item['node']['user']['name']);
        $("#commentnametime-"+(key+1)).html(parseDate(item['node']['date']));
        $("#commentnamelist-"+(key+1)).html(item['node']['task']['tittle']+': '+ item['node']['comment']);
    }

    function parseDate(dateString){
        let date = new Date(dateString)
        let month = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Pazdziernik", "Listopad", "Grudzień"];
        return date.getDate() + " " + month[date.getMonth()] + " " + date.getFullYear();
    }

    responseController('Fajnie jest');
});