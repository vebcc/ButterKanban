(function ($) {
    $(document).ready(function () {
        var $wrapper = $('.custom');

        $wrapper.on('click', '.custom-remove', function (e) {
            e.preventDefault();
            $(this).closest('.custom-item')
                .fadeOut()
                .remove();
        });
        $wrapper.on('click', '.custom-add', function (e) {
            e.preventDefault();
            var prototype = $wrapper.data('prototype');
            var index = $wrapper.data('index');
            var newForm = prototype.replace(/__name__/g, index);
            $wrapper.data('index', index + 1);
            $(this).before(newForm);
        });

        $(".form-type-selector").change(function () {
            let customDiv = $("#custom-div");
            if (parseInt(this.value)===4 || parseInt(this.value)===6 || parseInt(this.value)===7 || parseInt(this.value)===8) {
                customDiv.show();
            }else{
                customDiv.hide();
            }

            let entityTypeForm = $("#entity-type-form");
            let entityTypeFormPrototype = $("#entity-type-form-prototype");
            if(parseInt(this.value)===5 || parseInt(this.value)===6 || parseInt(this.value)===8){
                entityTypeForm.html(entityTypeFormPrototype.html());
                entityTypeForm.show();
            }else{
                entityTypeForm.html(' ');
                entityTypeForm.hide();
            }
        });

        var $dependentOn = $('#setting_dependentOn');

        $dependentOn.change(function () {
            var $form = $(this).closest('form');
            var data = {};
            data[$dependentOn.attr('name')] = $dependentOn.val();
            $.ajax({
                url : '/setting/form/dependent-on-value',
                type: $form.attr('method'),
                data : data,
                success: function(html) {
                    $('#dependent-on-value').html(
                        $(html).find('#dependent-on-value').children()
                    );
                }
            });
        });


    });
})(jQuery);