// Submit the login form - JavaScript workaround for IE's lack of support for
// the form attribute of the button element
jQuery('#login').on('show.bs.modal', function (event) {
  "use strict";
  var modal = jQuery(this);
  modal.find('#login-form-submit-button').on('click', function() {
    modal.find('#login-form').submit();
  });
});

jQuery(document).ready(function() {
  "use strict";
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


function handleFiles(input) {
  "use strict";

  var file = input.files[0];

  // Get additional file data
  var eventDate = input.dataset.eventDate;
  var eventVenue = input.dataset.eventVenue;
  var customFieldIndex = input.id.replace('file_upload', '');
  var fileType = camelise(document.getElementById('jform_custom' + customFieldIndex + '-lbl').innerHTML.trim());

  console.log(fileType);

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

  if (file.size > 20971520) {
    errorState(inputField, progressBar, errorMessage, "Error, file greater than limit of 20 MB");
    return;
  }

  xhr.upload.addEventListener("progress", function(e) {
    var pc = parseInt(100 - (e.loaded / e.total * 100));
    progressBar.style.width = pc + "%";
    progressBar.childNodes[1].innerHTML = pc + "% Complete (in progress)"
  }, false);

  xhr.onloadstart = function() {
    console.log('upload started');
    resetState(inputField, progressBar, errorMessage)
  };

  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
      if ((xhr.status == 200) && !(xhr.responseText.includes("error"))) {
        // The file uploaded ok
        successState(inputField, progressBar, xhr.responseText);
      } else {
        // The file did not upload ok
        errorState(inputField, progressBar, errorMessage, xhr.responseText);
      }
    }
  };

  formData.append("upload_file", file);
  xhr.send(formData);
}

function errorState(inputField, progressBar, errorMessage, response) {
  console.error('The file did not upload successfully. If this problem persists please contact the website administrator.');

  inputField.parentNode.parentNode.setAttribute('class', 'form-group has-error');

  // Label --------------------------------------------------------------------
  
  // Input --------------------------------------------------------------------
  inputField.setAttribute('aria-invalid', 'true');

  // Button -------------------------------------------------------------------
   
  
  // Progress -----------------------------------------------------------------
  progressBar.setAttribute('aria-valuenow', '100');
  progressBar.setAttribute('style', 'width: 100%');
  progressBar.setAttribute('class', 'progress-bar progress-bar-danger');
  progressBar.childNodes[1].innerHTML = "100% Complete (failure)"

  // Alert --------------------------------------------------------------------
  errorMessage.style.display = 'inherit';
  errorMessage.innerHTML = response;
  // FIXME: Remove empty br tags
}

function successState(inputField, progressBar, response) {
  console.log(response); // handle response.
  console.log('The file was successfully uploaded with a response of: ' + response);

  // Label --------------------------------------------------------------------
  
  // Input --------------------------------------------------------------------
  inputField.value = response;
  inputField.setAttribute('aria-invalid', 'false');

  // Button -------------------------------------------------------------------
  
  // Progress -----------------------------------------------------------------
  progressBar.setAttribute('aria-valuenow', '100');
  progressBar.setAttribute('style', 'width: 100%');
  progressBar.setAttribute('class', 'progress-bar progress-bar-success');
  progressBar.childNodes[1].innerHTML = "100% Complete (success)"

  // Alert --------------------------------------------------------------------

}

function resetState(inputField, progressBar, errorMessage) {
  inputField.parentNode.parentNode.setAttribute('class', 'form-group');
  
  // Label --------------------------------------------------------------------
  
  // Input --------------------------------------------------------------------
  inputField.setAttribute('aria-invalid', 'false');

  // Button -------------------------------------------------------------------
  
  // Progress -----------------------------------------------------------------
  progressBar.parentNode.style.display = 'initial';
  progressBar.setAttribute('aria-hidden', 'false');
  progressBar.setAttribute('aria-valuenow', '0');
  progressBar.setAttribute('style', 'width: 0%');
  progressBar.setAttribute('class', 'progress-bar progress-bar-info');
  progressBar.childNodes[1].innerHTML = "0% Complete (pending)"

  // Alert --------------------------------------------------------------------
  errorMessage.style.display = 'none';
}

// From http://stackoverflow.com/a/2970667/1433614
function camelise(str) {
  return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(letter, index) {
    return index == 0 ? letter.toLowerCase() : letter.toUpperCase();
  }).replace(/\s+/g, '');
}





