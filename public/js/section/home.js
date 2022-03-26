$(document).ready(function () {
    $(".favourite").click(function () {
        //Nie pozwala sie uruchomic eventowi tworzenia drinka
        if (!e) var e = window.event;
        e.cancelBubble = true;
        if (e.stopPropagation) e.stopPropagation();

        let id = $(this).data("id");
        let status = $("#cocktail_" + id).data("favourite");

        $.get("cocktail/" + id + "/favourite/" + status).done(function () {
            if (status) {
                $("#cocktail_" + id).data("favourite", 0);
                $("#favourite_icon_" + id).addClass("text-warning").removeClass("text-gray-300");
            } else {
                $("#cocktail_" + id).data("favourite", 1);
                $("#favourite_icon_" + id).addClass("text-gray-300").removeClass("text-warning");
            }
            $("#drinkdiv").each(function () {
                let items = $(this).children("div").sort(function (a, b) {
                    let vA = $(a).data("favourite");
                    let vB = $(b).data("favourite");
                    return (vA < vB) ? -1 : (vA < vB) ? 0 : 1;
                });
                $(this).append(items);
            });
        });
    });

    $(".cocktail").click(function () {
        let modal = $("#ModalMakeCocktail");
        modal.find("#cocktailid").val($(this).data("id"));
        modal.find(".cocktailName").html($(this).data("name"));
        modal.find("#cocktailSizeValue").html("Zalecana dla drinka: " + parseInt($(this).data("size")) + "ml");
        modal.find("#input2").val(parseInt($(this).data("size")));
        modal.find("#alcohol").html($(this).data("alcohol"));
        modal.find("#multiplierversionvalue").val(parseInt($(this).data("alcohol")));
        modal.find(".cocktailDescription").html($(this).data("description"));
        modal.find(".cocktailSizeValue").html(parseInt($(this).data("size")));
        if (parseInt($(this).data("alcohol"))) {
            modal.find('#fullalcomultiplier').show();
        } else {
            modal.find('#fullalcomultiplier').hide();
        }
    });

    $("#amount").change(function () {
        let modal = $("#ModalMakeCocktail");
        let value = this.value;
        if (parseInt(value) == 2) {
            modal.find("#input2").show();
        } else {
            modal.find("#input2").hide();
        }
    });

    $("#multiplier").change(function () {
        let modal = $("#ModalMakeCocktail");
        var value = $(this).is(":checked");
        if (value) {
            modal.find('#multiplierextend').show();
            modal.find("#alcohol").html($("#multiplierversionvalue").val());


        } else {
            modal.find('#multiplierextend').hide();
            modal.find("#alcohol").html($(".cocktail").data("alcohol"));
        }
    });

    $("#multiplierversionvalue").change(function () {
        let modal = $("#ModalMakeCocktail");
        let value = this.value;
        modal.find("#alcohol").html(parseInt(value));
    });

    $(".sendcocktail").submit(function () {
        $('.allmodal').modal('hide');
        $("#ModalProgress").modal('show');

        $.ajax({
            type: 'post',
            async: true,
            url: 'cocktail/make',
            data: $('form').serialize(),
            success: function (d) {
                console.log("udalo sie: ");
            },
            error: function (d) {
                console.log(d);
            }

        });
    });

    const url = new URL(window.location.protocol+"//"+window.location.hostname+":"+3000+'/.well-known/mercure');
    //const url = new URL(window.location.protocol+"//"+window.location.hostname+":"+window.location.port+'/.well-known/mercure');
    url.searchParams.append('topic', 'http://drunkmachine.com/.well-known/mercure/cocktail/main');
    url.searchParams.append('topic', 'http://drunkmachine.com/.well-known/mercure/logs');
    const eventSource = new EventSource(url);

    eventSource.onmessage = e => responseProvider(e);
});

function runProgressBar(time) {
    const convertTime = time / 100;
    let i = 0;
    let counterBack = setInterval(function () {
        i++;
        if (i <= 100) {
            $('#cocktail-progress-bar-bar').css('width', i + '%');
        } else {
            clearInterval(counterBack);
        }

    }, convertTime);
}

function responseProvider(event) {
    const jsonData = JSON.parse(event.data);
    console.log(jsonData);

    switch (jsonData.status) {
        case "time":
            runProgressBar(jsonData.time);
            break;
        case "end":
            hideAndClearProgressBar();
            //refreshLogs();
            break;
        case "refreshLogs":
            refreshLogs(jsonData.logs);
            break;
    }

}

function hideAndClearProgressBar() {
    $("#ModalProgress").modal('hide');
    $('#cocktail-progress-bar-bar').css('width', 1 + '%');
}

function refreshLogs(logs) {
    $("#one-ingredient-div").html(logs["oneIngredientLog"]);
    $("#one-cocktail-div").html(logs["oneCocktailLog"]);
    $("#list-ingredients-div").html(logs["listIngredientLogs"]);
    $("#list-cocktails-div").html(logs["listCocktailLogs"]);
}