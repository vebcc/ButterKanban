$(".compare-edit-button").click(function (){
    let id = this.id.split("_")[1];
    console.log(id);
    $("#compare_edit_form").attr("action", "/group/"+id+"/edit");
})