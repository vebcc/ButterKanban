$(document).ready(function () {
    let runPumpButton = $("#run-pump");
    let runPumpTimeButton = $("#run-pump-time");
    let pump = $("#pump_calibration_pump");
    let time = $("#pump_calibration_calibrationTime");

    runPumpButton.mouseup(function () {
        stop(pump.val());
    });
    runPumpButton.mousedown(function () {
        run(pump.val());
    });

    runPumpTimeButton.click(function () {
        run(pump.val(), time.val());
    });

    function stop(id) {
        execute(id, '/pump/manual/stop');
        console.log("Wylaczam");
    }

    function run(id, time = null) {
        execute(id, '/pump/manual/run', time*1000);
        console.log("Włączam");
    }

    function execute(id, url, time = null) {
        let data = [];
        if (time) {
            data = {id: id, time: time};
        } else {
            data = {id: id};
        }
        console.log(data);
        $.ajax({
            type: 'post',
            url: url,
            data: data,
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