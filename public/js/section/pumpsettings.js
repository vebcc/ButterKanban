$(document).ready(function(){
    $(".pumpchangevalue").submit(function(){
        var id = $(this).attr('id').split("_")[1];

        var formdata = $('#pumpchangevalue_'+id).serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        $.get( "include/handler/PumpsHandler.php", {    changePumpSettings: id, 
                                                        mlPerMin: formdata["mlpermin"], 
                                                        pipeVolume: formdata["pipevolume"]}
        ).done(function(data){
            console.log(data);
        });
    });     
});