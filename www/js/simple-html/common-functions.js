(function($) {
    'use strict';

    /**
     * @param {boolean} status
     * @param {string} message
     * @returns {boolean}
     */
    function showPopup(status, message)
    {
        let $popup;
        if (status) {
            $popup = $('#success-popup');
        } else {
            $popup = $('#error-popup');
        }
        console.log($popup);
        if ($popup) {
            $popup.find('.response-text').html(message);
            $popup.fadeIn(500);
            return true;
        }

        return false;
    }

    /**
     * @param xhr
     * @param status
     * @param error
     * @param $loading_div
     * @param form
     */
    function processValidationResponse(xhr, status, error, $loading_div, form)
    {
        if (status === 'success') {
            if ('status' in xhr && 'message' in xhr) {
                if (showPopup(xhr.status, xhr.message)) {
                    form.reset();
                }
            } else
                if ('errors' in xhr) {
                    $.each(xhr.errors, function(i, v) {
                        //console.log(i, v);
                        $(form).find(`[name=${i}]`).each(function() {
                            $(this).parent().find('label.js-error').remove();
                            $(this).parent().append('<label class="error active js-error">' + v.join(';') + '</label>');
                        });
                    });
                }
        } else {
            //console.log(xhr, status, error);
            if ('responseJSON' in xhr && 'message' in xhr.responseJSON) {
                showPopup(false, xhr.responseJSON.message)
            }
        }
    }

    /**
     *
     */
    $(document).ready(function() {

        /**
         * collect all messages
         */
        let messages = {};
        $(document).find('.js-validation-form').each(function() {
            let $form = $(this);
            let form_inputs = $form.serializeArray();
            $.each(form_inputs, function(i, v) {
                $form.find(`[name=${v.name}]`).each(function() {
                    let $inp = $(this);
                    let text = $inp.data('error-message');
                    if (text !== undefined) {
                        messages[v.name] = text;
                    }
                });
            });
        });

        /**
         * any form with class js-validation-form will be validated here
         */
        $('.js-validation-form').validate({
            rules: {},
            //messages: {},
            messages: messages,
            errorPlacement: function(error, element) {
                //console.log(element);
                error.appendTo( element.parent() );
            },
            //ignore: "",
            submitHandler: function(form) {
                let $loading = $('.loading');
                $loading.fadeIn('slow').html('Vorbereitung...');
                $.ajax({
                    type: $(form).attr('method'),
                    data: $(form).serialize(),
                    dataType: 'json',
                    url: $(form).attr('action'),
                    cache: false,
                }).always(function(xhr, status, error) {
                    $loading.hide();
                    processValidationResponse(xhr, status, error, $loading, form);
                });
                return false;
            },
        });

        /**
         * close popup
         */
        $(document).on('click', '.void-0', function() {
            return false;
        });

        /**
         * close popup
         */
        $(document).on('click', '.js-close-popup', function() {
            $('.form-popup').fadeOut(500);
        });

    });

})(jQuery);