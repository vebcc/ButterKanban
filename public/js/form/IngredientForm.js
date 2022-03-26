(function ($) {
    $(document).ready(function () {
        function updateUnit(converterSelect)
        {
            var name = converterSelect.val();
            var parent = converterSelect.parent().parent();
            $.ajax({
                dataType: 'json',
                url: '/converter/json?converter=' + name,
                method: 'GET',
                success: function (json) {
                    parent.find('.converter_unit').html(json['unit'])
                }
            });
        }

        var $wrapperR = $('.ingredient-replacements-table');
        $wrapperR.on('click', '.ingredient-replacements-remove', function (e) {
            var index = $wrapperR.data('index');
            e.preventDefault();
            $(this).closest('.ingredient-replacements-item')
                .fadeOut()
                .remove();
            $wrapperR.data('index', index - 1);
        });
        $wrapperR.on('click', '.ingredient-replacements-add', function (e) {
            e.preventDefault();
            var prototype = $wrapperR.data('prototype');
            var index = $wrapperR.data('index');
            var newForm = prototype.replace(/__name__/g, index);
            $wrapperR.data('index', index + 1);
            $(this).before(newForm);
        });

        var $wrapperCV = $('.ingredient-calibrationValues-table');
        $wrapperCV.on('click', '.ingredient-calibrationValues-remove', function (e) {
            var index = $wrapperCV.data('index');
            e.preventDefault();
            $(this).closest('.ingredient-calibrationValues-item')
                .fadeOut()
                .remove();
            $wrapperCV.data('index', index - 1);
        });
        $wrapperCV.on('click', '.ingredient-calibrationValues-add', function (e) {
            e.preventDefault();
            var prototype = $wrapperCV.data('prototype');
            var index = $wrapperCV.data('index');
            var newForm = prototype.replace(/__name__/g, index);
            $wrapperCV.data('index', index + 1);
            $(this).before(newForm);
            updateUnit($(this).prev().find('.converter_select'))
        });

        $wrapperCV.on('change', '.converter_select', function () {
            updateUnit($(this));
        });
    });
})(jQuery);

//TODO: po usunieciu nie ostatniego ingredient indexy sie dubluja