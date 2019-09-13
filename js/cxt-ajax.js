jQuery(document).ready(function($) {

  // When the form is submitted
  $('#cxt-form').submit(function() {

    $('#cxt-loading').show();                   // Loading animation
    $('#cxt-submit').attr('disabled', true);    // Submit button
    $('#cxt-old').hide();                 // Remove original terms table
    $('#cxt-results').empty();                  // Content box

    data = {
      action: 'cxt_get_results',
      cxt_nonce: cxt_vars.cxt_nonce
    };

    // Finish up
    $.post(ajaxurl, data, function(response) {   // Post cxt_get_results to wp-admin ajax, get response
      $('#cxt-loading').hide();                  // Loading animation
      $('#cxt-submit').attr('disabled', false);  // Submit button
      $('#cxt-results').html(response);          // Content box
    });

    return false;
  });
});