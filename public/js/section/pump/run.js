$(document).ready(function () {
    let runPumpButton = $(".run-pump");
    runPumpButton.mouseup(function(){
        stop(runPumpButton.val());
    });
    runPumpButton.mousedown(function(){
        run(runPumpButton.val());
    });

    function stop(id){
        execute(id, '/pump/manual/stop');
        console.log("Wylaczam");
    }

    function run(id) {
        execute(id, '/pump/manual/run');
        console.log("Włączam");
    }

    function execute(id, url){
        $.ajax({
            type: 'post',
            url: url,
            data: {id: id},
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

});