<?php
/** @var $view Core\ViewDriver */
/** @var $vars array */

$vars['title'] = 'KONTAKTE';

$view->putInJsStack(['async defer' => "https://www.google.com/recaptcha/api.js"]);
?>


<!-- CONTACTS-5
============================================= -->
<section id="contacts-5" class="contacts-section division">
    <div class="container">


        <!-- SECTION TITLE -->
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="section-title mb-40 text-center">

                    <!-- Title 	-->
                    <h2 class="h2-xl">Our contacts</h2>

                </div>
            </div>
        </div>


        <!-- CONTACT FORM -->
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="form-holder">
                    <form name="contact-form"
                          class="row contact-form js-validation-form"
                          method="post"
                          action="<?= url('save-contacts') ?>">

                        <input type="hidden" name="csrf" value="<?= csrf() ?>">

                        <!-- Form Input -->
                        <div class="col-md-12 col-lg-6">
                            <input type="text"
                                   name="name"
                                   data-off-data-error-message="Falschen Namen wurde gegeben"
                                   <?= Requests\ContactsRequest::getRulesForHtmlInput('name') ?>
                                   class="form-control name"
                                   placeholder="Ihr Name*"
                                   aria-label=""/>
                        </div>

                        <!-- Form Input -->
                        <div class="col-md-12 col-lg-6">
                            <input type="text"
                                   name="subject"
                                   <?= Requests\ContactsRequest::getRulesForHtmlInput('subject') ?>
                                   class="form-control subject"
                                   placeholder="Das Thema*"
                                   aria-label="">
                        </div>

                        <!-- Form Input -->
                        <div class="col-md-12 col-lg-6">
                            <input type="email"
                                   name="email"
                                   <?= Requests\ContactsRequest::getRulesForHtmlInput('email') ?>
                                   class="form-control email"
                                   placeholder="Email Addresse*"
                                   aria-label="">
                        </div>

                        <!-- Form Input -->
                        <div class="col-md-12 col-lg-6">
                            <input type="text"
                                   name="phone"
                                   <?= Requests\ContactsRequest::getRulesForHtmlInput('phone') ?>
                                   class="form-control"
                                   placeholder="Telefonnummer"
                                   aria-label="">
                        </div>

                        <!-- Form Textarea -->
                        <div class="col-md-12">
                                <textarea name="msg"
                                          class="form-control message"
                                          rows="6"
                                          <?= Requests\ContactsRequest::getRulesForHtmlInput('msg') ?>
                                          placeholder="Mitteilung"
                                          aria-label=""></textarea>
                        </div>

                        <div class="g-recaptcha" data-sitekey="<?= config('re-captcha-site-key') ?>"></div>

                        <!-- Form Button -->
                        <div class="col-md-12 mt-5 text-right">
                            <button type="submit" class="btn btn-md btn-red tra-red-hover submit">Send</button>
                        </div>

                        <!-- Form Message -->
                        <div class="col-md-12 contact-form-msg text-center">
                            <div class="sending-msg"><span class="loading"></span></div>
                        </div>

                    </form>

                </div>
            </div>
        </div> <!-- END CONTACT FORM -->


    </div> <!-- End container -->
</section> <!-- END CONTACTS-5 -->
<?php
//$view->putInJsStack('
//<script>
//    $.extend($.validator.messages, {
//        required: "' . __('This field is required!') . '",
//        remote: "' . __('Please fix this field.') . '",
//        email: "' . __('Please enter a valid email address.') . '",
//        url: "' . __('Please enter a valid URL.') . '",
//        date: "' . __('Please enter a valid date.') . '",
//        dateISO: "' . __('Please enter a valid date (ISO).') . '",
//        number: "' . __('Please enter a valid number.') . '",
//        digits: "' . __('Please enter only digits.') . '",
//        creditcard: "' . __('Please enter a valid credit card number.') . '",
//        equalTo: "' . __('Please enter the same value again.') . '",
//        accept: "' . __('Please enter a value with a valid extension.') . '",
//        maxlength: jQuery.validator.format("' . __('Please enter no more than {0} characters!') . '"),
//        minlength: jQuery.validator.format("' . __('Please enter at least {0} characters!') . '"),
//        rangelength: jQuery.validator.format("' . __('Please enter a value between {0} and {1} characters long!') . '"),
//        range: jQuery.validator.format("' . __('Please enter a value between {0} and {1}!') . '"),
//        max: jQuery.validator.format("' . __('Please enter a value less than or equal to {0}!') . '"),
//        min: jQuery.validator.format("' . __('Please enter a value greater than or equal to {0}!') . '")
//    });
//</script>
//');
