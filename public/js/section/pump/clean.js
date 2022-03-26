$(document).ready(function () {
    $(".run-pumps").click(function () {
        let pumpsId = $(".pump-check-box").serializeArray().reduce(function (obj, item, key) {
            obj[key] = item.value;
            return obj;
        }, {});

        let PumpsIdArray = Object.keys(pumpsId).map((key) => pumpsId[key]);

        run(PumpsIdArray.toString());
    });

    $(".stop-pumps").click(function () {
        stop();
    });

    function run(pumps) {
        let url = "/pump/clean/run"
        $.ajax({
            type: 'post',
            async: true,
            url: url,
            data: {pumps: pumps},
            success: function (d) {
                console.log("udalo sie: ");
                console.log(d);
            },
            error: function (d) {
                console.log("error: ");
                console.log(d);
            }

        });

        console.log("Włączam");
    }

    function stop() {
        let url = "/pump/clean/stop"
        $.ajax({
            type: 'post',
            async: true,
            url: url,
            data: {pumps: 'pumps'},
            success: function (d) {
                console.log("udalo sie: ");
                console.log(d);
            },
            error: function (d) {
                console.log("error: ");
                console.log(d);
            }

        });
    }

    function responseProvider(event){
        const jsonData = JSON.parse(event.data);
        console.log(jsonData);
        const pumpId = jsonData.id;
        if(jsonData.status === "end"){
            $("#pump-"+pumpId).prop("checked", false);
            console.log("end");
        }

    }

    //const url = new URL(window.location.protocol+"//"+window.location.hostname+":"+window.location.port+'/.well-known/mercure');
    const url = new URL(window.location.protocol+"//"+window.location.hostname+":"+3000+'/.well-known/mercure');
    url.searchParams.append('topic', 'http://drunkmachine.com/pump/clean/status');
    const eventSource = new EventSource(url);

    eventSource.onmessage = e => responseProvider(e);
});