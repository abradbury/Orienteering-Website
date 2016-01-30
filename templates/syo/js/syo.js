// Submit the login form - JavaScript workaround for IE's lack of support for 
// the form attribute of the button element
jQuery('#login').on('show.bs.modal', function (event) {
  var modal = jQuery(this);
  modal.find('#login-form-submit-button').on('click', function() {
    modal.find('#login-form').submit();
  });
});

jQuery(document).ready(function() {
  // Add HTML content for image caption
  jQuery('img').not('.noCaption').each(function(i, obj) {
    var image = jQuery(this);
    image.wrap("<div class='imgWrap'></div>");
    image.after("<small class='caption'>"+image.attr("alt")+"</small>");
  });

  // Header image
  jQuery('.banner').each(function(i, obj) {
    var banner = jQuery(this);
    banner.css('background-image', 'url(' + banner.attr('data-img-name') + ')');
  });
});