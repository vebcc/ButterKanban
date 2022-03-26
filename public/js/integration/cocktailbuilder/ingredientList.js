(function ($) {
    $(document).ready(function() {
        var $wrapper = $('.ingredients');
        $wrapper.on('click', '.ingredient-list-remove', function(e) {
            e.preventDefault();
            $(this).closest('.ingredient-list-item')
                .fadeOut()
                .remove();
        });
        $wrapper.on('click', '.ingredient-list-add', function(e) {
            e.preventDefault();
            var prototype = $wrapper.data('prototype');
            var index = $wrapper.data('index');
            var newForm = prototype.replace(/__name__/g, index);
            $wrapper.data('index', index + 1);
            $(this).before(newForm);
        });
    });
})(jQuery);