$(document).ready(function () {
    $(".updatebutton").click(function () {

        let row = $("#tr-"+$(this).val());

        row.find(".current-capacity").val(row.find(".container-capacity").val());

        row.find(".container-status").html("Oczekuje na zatwierdzenie").removeClass("alert-danger alert-warning alert-success").addClass("alert-primary");
    });
});