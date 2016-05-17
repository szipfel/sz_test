/*
jQuery(document).ready(function () {
    //on any change to the form in the lf-test-vote-form check to see if everything is filled out
    jQuery('#lf-test-vote-form input').blur(function()
    {
        // Check all teh fields we care about..
        jQuery('input#edit-voter-name, input#edit-voter-email, input#edit-select-city').each(function ()
        {

            if (jQuery(this).val())
            {
                var filled = 'TRUE';
            }

            if (filled)
            {
                jQuery('input#edit-submit').removeAttr('disabled').removeClass('form-button-disabled');
            }
        })
    });

});
*/