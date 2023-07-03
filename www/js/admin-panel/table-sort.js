(function($) {

    /**
     * on document ready
     */
    $(document).ready(function() {

        /* inti sorting for the accounts table */
        $(".sort-list-table").tablesorter({
            // //https://mottie.github.io/tablesorter/docs/#Examples
            widgets: ["saveSort"],
            // widgetOptions : {
            //     saveSort : true  // by default is true
            // },
            theme : 'blue',
            //sortList : [[2,0]],  // setup in table-html-tag
            headers : {
                '.no-sort': {sorter: false}
            },
        });

    });

})(jQuery);
