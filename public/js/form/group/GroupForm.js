$(function () {
    $("ul.droptrue").sortable({
        connectWith: "ul",
    });

    $("ul.dropfalse").sortable({
        connectWith: "ul",
        dropOnEmpty: false
    });

    let sortable = $("#sortable1, #sortable2, #sortable3");

    sortable.disableSelection();

    sortable.on('sortchange', function (event, ui) {
        updateHiddenForm(event, ui);
    });

    function updateHiddenForm(event, ui) {
        if (ui.sender) {
            let id = ui.item[0].id.split('-')[1];
            //let id = $(ui.item[0]).html(); // zrobione na razie po nazwie :(
            switch (ui.sender[0].id) {
                case 'sortable1':
                case 'sortable3':
                    addNewCocktailForm(id);
                    break;
                case 'sortable2':
                    findAndDeleteCocktailForm(id);
                    break;
            }
        }
    }

    function findAndDeleteCocktailForm(id) {
        //let item = $("#hidden-cocktails-form").find('.hidden_single_form[value="' + id + '"]')[0]; // dlatego ze zmieniony custom type na hiddentype
        let item = $("#hidden-cocktails-form").find('.hidden_single_form_div[value="' + id + '"]')[0];

        let hiddenCocktailsForm = $('#hidden-cocktails-form');
        let index = hiddenCocktailsForm.data('index');
        hiddenCocktailsForm.data('index', index - 1);

        //$(item).parent().remove();
        $(item).remove(); // dlatego ze zmieniony custom type na hiddentype

    }

    function addNewCocktailForm(id) {
        let hiddenCocktailsForm = $('#hidden-cocktails-form');

        console.log(hiddenCocktailsForm);

        let prototype = hiddenCocktailsForm.data('prototype');
        let index = hiddenCocktailsForm.data('index');
        let newForm = prototype.replace(/__name__/g, index);
        hiddenCocktailsForm.data('index', index + 1);

        hiddenCocktailsForm.append(newForm);
        $('#group_edit_cocktail_' + index).val(id);
        console.log($('#group_edit_cocktail_' + index).val());
    }
});