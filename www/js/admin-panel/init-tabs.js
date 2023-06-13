(function($) {
    'use strict';

    $(document).ready(function() {
        $(".ad-panel-tab").click(function() {
            var tabId = $(this).attr("data-tab");
            $(".ad-panel-tab").removeClass("active");
            $(this).addClass("active");
            $(".ad-panel-content").removeClass("active");
            $("#" + tabId).addClass("active");
        });
    });

})(jQuery);
