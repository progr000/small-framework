<?php
/** @var $view Core\ViewDriver */
/** @var $vars array */

$view->firstInCssStack('
<style>
.lang-switcher {
    position: absolute;
    top: 60px;
    right: 60px;
    text-align: right;
}
.lang-switcher img {
    width: 30px;
    border: none;
}
.lang-switcher .current-lang {
    cursor: pointer;
}
.lang-switcher .available-lang.hidden {
    display: none;
}
</style>
');

$view->putInJsStack('
<script>
(function($) {
    "use strict";

    let $js_available_lang = $(".js-available-lang");
    
    $(document).on("click", ".js-current-lang", function() {
        $js_available_lang.toggleClass("hidden");
    });
    
    $(document).on("click", "body", function(e) {
        if (!$js_available_lang.hasClass("hidden")) {
            if ($(e.target).hasClass("lang-img")) {
                return;
            }
            $js_available_lang.addClass("hidden");
        }
    });

})(jQuery);
</script>
');

?>
<div class="lang-switcher">
    <?php
    $locales = config('localization->available-locales', []);
    $current_lang = session('locale', config('localization->default-locale', 'en'));
    ?>
    <div class="current-lang js-current-lang"><img class="lang-img" src="<?= asset("/images/admin-panel/flags/{$current_lang}.jpg") ?>" alt="<?= $locales[$current_lang] ?>"></div>
    <div class="available-lang hidden js-available-lang">
        <?php
        foreach ($locales as $k => $v) {
            if (session('locale', config('localization->default-locale', 'en')) !== $k) {
                ?>
                <a href="<?= url("/lang/{$k}") ?>">
                    <img class="lang-img" src="<?= asset("/images/admin-panel/flags/{$k}.jpg") ?>" alt="<?= $v ?>">
                </a>
                <br/>
                <?php
            }
        }
        ?>
    </div>
</div>

