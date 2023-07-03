(function($) {
    'use strict';

    $(document).on('submit', 'form.delete-item', function() {
        return confirm('Are you sure?');
    });

    $(document).on('click', 'a.delete-item', function() {
        return confirm('Are you sure?');
    });

})(jQuery);
