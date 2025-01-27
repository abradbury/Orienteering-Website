"use strict";

// Submit the login form - JavaScript workaround for IE's lack of support for
// the form attribute of the button element
jQuery('#login').on('show.bs.modal', function (event) {
  "use strict";
  var modal = jQuery(this);
  modal.find('#login-form-submit-button').on('click', function () {
    var form = document.getElementById('login-form')

    if (form.reportValidity()) {
      form.submit();
    }
  });
});

// Submit the login form on enter key press
jQuery("#login-form input").keypress(function (event) {
  if (event.which == 13) {
    event.preventDefault();
    var form = document.getElementById('login-form')

    if (form.reportValidity()) {
      form.submit();
    }
  }
});

// Add HTML content for image caption
jQuery('img').not('.noCaption,[src*=darkmode],[src*=com_jem]').each(function (i, obj) {
  var image = jQuery(this);

  var classes = "imgWrap";
  if (image.css('float') == 'right') {
    classes = classes + " float-end ms-3";
  } else if (image.css('float') == 'left') {
    classes = classes + " float-start me-3";
  }

  var imageAlt = image.attr("alt");
  if (!imageAlt) {
    imageAlt = "This image has no description"
  }

  image.wrap("<div class='" + classes + "'></div>");
  image.addClass('img-fluid');
  image.after("<small class='caption'>" + imageAlt + "</small>");
});

// Header image
jQuery('.banner').each(function (i, obj) {
  var banner = jQuery(this);
  banner.css('background-image', 'url(' + banner.attr('data-img-name') + ')');
});

// Hover effect on sponsor logo
function footerHover(elementID) {
  var svgObject = document.getElementById(elementID);
  var svgParent = svgObject.parentElement;

  // How to access SVG innards via JS: https://stackoverflow.com/a/6794343/1433614
  // jQuery bug in add/remove class functions on SVGs: https://stackoverflow.com/a/10257755/1433614
  svgObject.addEventListener("load", function () {
    jQuery(svgParent).on("focusin mouseenter", function () {
      jQuery(svgParent).attr("style", "");
    })

    jQuery(svgParent).on("focusout mouseleave", function () {
      jQuery(svgParent).attr("style", "filter: grayscale(1);");
    })
  }, false);
}

footerHover("aclo");

function handleFiles(input) {
  "use strict";

  var file = input.files[0];

  // Get additional file data
  var eventDate = input.dataset.eventDate;
  var eventVenue = input.dataset.eventVenue;
  var customFieldIndex = input.id.replace('file_upload', '');
  var fileType = camelise(document.getElementById('jform_custom' + customFieldIndex + '-lbl').innerHTML.trim());

  // Based on https://www.webcodegeeks.com/html5/html5-file-upload-example/
  var url = '/templates/syo/upload.php';
  var xhr = new XMLHttpRequest();
  var formData = new FormData();
  xhr.open("POST", url, true);

  // Add POST data
  formData.append('eventDate', eventDate);
  formData.append('eventVenue', eventVenue);
  formData.append('fileType', fileType);

  var progressBar = document.getElementById('progressbar' + customFieldIndex);
  var inputField = document.getElementById('jform_custom' + customFieldIndex);
  var errorMessage = document.getElementById('helpBlock' + customFieldIndex);
  var fileUpload = document.getElementById('file_upload' + customFieldIndex);

  if (file.size > 20971520) {
    errorState(inputField, progressBar, errorMessage, fileUpload, "Error, file greater than limit of 20 MB");
    return;
  }

  xhr.upload.addEventListener("progress", function (e) {
    var pc = parseInt(e.loaded / e.total * 100);
    progressBar.parentElement.style.display = 'flex';
    progressBar.setAttribute('style', 'width: ' + pc + '%; display: flex;');
    progressBar.parentElement.setAttribute('aria-valuenow', pc);
  }, false);

  xhr.onloadstart = function () {
    resetState(inputField, progressBar, fileUpload, errorMessage)
  };

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if ((xhr.status == 200) && !((xhr.responseText).toLowerCase().includes("error"))) {
        // The file uploaded ok
        successState(inputField, progressBar, fileUpload, xhr.responseText);
      } else {
        // The file did not upload ok
        errorState(inputField, progressBar, errorMessage, fileUpload, xhr.responseText);
      }
    }
  };

  formData.append("upload_file", file);
  xhr.send(formData);
}

function errorState(inputField, progressBar, errorMessage, fileUpload, response) {
  console.error('The file did not upload successfully. If this problem persists please contact the website administrator.');

  // Label --------------------------------------------------------------------

  // Input --------------------------------------------------------------------
  inputField.setAttribute('aria-invalid', 'true');
  inputField.setAttribute('class', 'form-control inputbox is-invalid');

  // Button -------------------------------------------------------------------
  fileUpload.value = ''

  // Progress -----------------------------------------------------------------
  progressBar.parentElement.style.display = 'flex';
  progressBar.parentElement.setAttribute('aria-valuenow', '100');
  progressBar.setAttribute('style', 'width: 100%; display: flex;');
  progressBar.setAttribute('class', 'progress-bar bg-danger');

  // Alert --------------------------------------------------------------------
  errorMessage.style.display = 'inherit';
  errorMessage.innerHTML = response;
  // FIXME: Remove empty br tags
}

function successState(inputField, progressBar, fileUpload, response) {
  console.log('The file was successfully uploaded with a response of: ' + response);

  // Label --------------------------------------------------------------------

  // Input --------------------------------------------------------------------
  inputField.value = response;
  inputField.setAttribute('aria-invalid', 'false');
  inputField.setAttribute('class', 'form-control inputbox is-valid');

  // Button -------------------------------------------------------------------
  fileUpload.value = ''

  // Progress -----------------------------------------------------------------
  progressBar.parentElement.style.display = 'flex';
  progressBar.parentElement.setAttribute('aria-valuenow', '100');
  progressBar.setAttribute('style', 'width: 100%; display: flex;');
  progressBar.setAttribute('class', 'progress-bar bg-success');

  // Alert --------------------------------------------------------------------

}

function resetState(inputField, progressBar, fileUpload, errorMessage) {

  // Label --------------------------------------------------------------------

  // Input --------------------------------------------------------------------
  inputField.setAttribute('aria-invalid', 'false');
  inputField.setAttribute('class', 'form-control inputbox');

  // Button -------------------------------------------------------------------
  fileUpload.value = ''

  // Progress -----------------------------------------------------------------
  progressBar.parentElement.style.display = 'flex';
  progressBar.setAttribute('aria-hidden', 'false');
  progressBar.parentElement.setAttribute('aria-valuenow', '0');
  progressBar.setAttribute('style', 'width: 0%; display: flex;');
  progressBar.setAttribute('class', 'progress-bar bg-info');

  // Alert --------------------------------------------------------------------
  errorMessage.style.display = 'none';
}

// From http://stackoverflow.com/a/2970667/1433614
function camelise(str) {
  return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function (letter, index) {
    return index == 0 ? letter.toLowerCase() : letter.toUpperCase();
  }).replace(/\s+/g, '');
}
