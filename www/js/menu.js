(function($) {

    /** @type {string} */
    let menu_id_prefix = 'menu-';

    /**
     * function for fold or unfold menu after page load or reload
     * state of folder stored in localStorage
     */
    function restoreUnfolded()
    {
        for (let i = 0; i < localStorage.length; i++) {
            let key = localStorage.key(i);
            let val = localStorage.getItem(key);
            if (key.indexOf(menu_id_prefix) >= 0) {
                $(`#${key}`).addClass(val);
            }
        }
    }

    /**
     * starts after document load
     */
    $(document).ready(function() {

        /* execute on load page */
        restoreUnfolded();

        /**/
        $(document).on('click', '.js-li-ordinal-menu', function(e) {
            e.stopPropagation();
        });

        /**/
        $(document).on('click', '.js-li-sub-menu', function(e) {
            let $d = $(this).find('.ul-level-up').first();
            $d.toggleClass('unfolded');
            if ($d.hasClass('unfolded')) {
                localStorage.setItem($d.attr('id'), 'unfolded');
            } else {
                localStorage.removeItem($d.attr('id'));
            }
            e.stopPropagation();
        });

    });

})(jQuery);