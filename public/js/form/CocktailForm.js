(function ($) {
    $(document).ready(function() {
        var $wrapper = $('.cocktail-ingredients');
        $wrapper.on('click', '.cocktail-ingredients-remove', function(e) {
            var index = $wrapper.data('index');
            e.preventDefault();
            $(this).closest('.cocktail-ingredients-item')
                .fadeOut()
                .remove();
            $wrapper.data('index', index - 1);
        });
        $wrapper.on('click', '.cocktail-ingredients-add', function(e) {
            e.preventDefault();
            var prototype = $wrapper.data('prototype');
            var index = $wrapper.data('index');
            var newForm = prototype.replace(/__name__/g, index);
            $wrapper.data('index', index + 1);
            $(this).before(newForm);
        });

        function fixFirstPrintedIngredient($wrapper){
            var index = $wrapper.data('index');
            var row = $wrapper.find(".cocktail-ingredients-item");

            if(row.length<=1) { //zapobieganie podmianie kiedy w trybie edycji jest wiecej niz 1 obiekt na liscie
                var data = row.html();

                data = data.replace(/__name__/g, index);

                $wrapper.data('index', index + 1);

                $(row).html(data);
            }
        }

        fixFirstPrintedIngredient($wrapper);

        //TODO: po usunieciu nie ostatniego ingredient indexy sie dubluja

    });
})(jQuery);