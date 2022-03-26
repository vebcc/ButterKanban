  
$(document).ready(function(){
    // FIlter anything
    $("#anythingSearch").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#drinkdiv .cocktail").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    // Filter table
    $('#tabledynamic').DataTable({
        "scrollY": "50vh",
        "scrollCollapse": true,
    });
    $('.dataTables_length').addClass('bs-select');

});


