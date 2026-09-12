"use strict";

document.addEventListener('DOMContentLoaded', function () {

    /* --- Login modal -----------------------------------------------------
     * Workaround for the button element's form attribute. Bootstrap 5 fires
     * show.bs.modal as a native event, so no jQuery needed.
     *
     * The old version re-bound the click handler every time the modal opened,
     * stacking duplicate handlers. The `bound` flag fixes that.
     */
    var loginModal = document.getElementById('login');

    if (loginModal) {
        var bound = false;

        loginModal.addEventListener('show.bs.modal', function () {
            if (bound) {
                return;
            }
            var submitButton = loginModal.querySelector('#login-form-submit-button');

            if (submitButton) {
                submitButton.addEventListener('click', function () {
                    var form = document.getElementById('login-form');
                    if (form && form.reportValidity()) {
                        form.submit();
                    }
                });
                bound = true;
            }
        });
    }

    /* --- Submit the login form on Enter ----------------------------------
     * keypress is deprecated; keydown with event.key is the modern
     * equivalent and behaves identically here.
     */
    document.querySelectorAll('#login-form input').forEach(function (input) {
        input.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter') {
                return;
            }
            event.preventDefault();
            var form = document.getElementById('login-form');
            if (form && form.reportValidity()) {
                form.submit();
            }
        });
    });

    /* --- Image captions --------------------------------------------------
     * Wrap each content image and append its alt text as a caption.
     *
     * Security note: the old version built the caption with string
     * concatenation into .after(), so an alt attribute containing markup was
     * injected as HTML. textContent makes that impossible.
     */
    var images = document.querySelectorAll(
        'img:not(.noCaption):not([src*="darkmode"]):not([src*="com_jem"])'
    );

    images.forEach(function (image) {
        if (!image.parentNode) {
            return;
        }

        var float = window.getComputedStyle(image).float;
        var classes = 'imgWrap';

        if (float === 'right') {
            classes += ' float-end ms-3';
        } else if (float === 'left') {
            classes += ' float-start me-3';
        }

        var wrapper = document.createElement('div');
        wrapper.className = classes;

        image.parentNode.insertBefore(wrapper, image);
        wrapper.appendChild(image);
        image.classList.add('img-fluid');

        var caption = document.createElement('small');
        caption.className = 'caption';
        caption.textContent = image.getAttribute('alt') || 'This image has no description';

        wrapper.appendChild(caption);
    });

    /* --- Sponsor logo hover ----------------------------------------------- */
    footerHover('aclo');
});


/* --------------------------------------------------------------------------
 * Sponsor logo: full colour on hover/focus, greyscale otherwise.
 *
 * The markup is:
 *     <a class="mainNavLogo" style="filter: grayscale(1);" href="...">
 *       <object id="aclo" type="image/svg+xml" data="compasssport.svg"> … </object>
 *     </a>
 *
 * So the handlers toggle the style attribute on the PARENT <a>. They never
 * touch the SVG's contents.
 *
 * -------------------------------------------------------------------------- */
function footerHover(elementID) {
    var svgObject = document.getElementById(elementID);

    if (!svgObject || !svgObject.parentElement) {
        return;
    }
    var svgParent = svgObject.parentElement;

    var showColour = function () {
        svgParent.setAttribute('style', '');
    };
    var showGreyscale = function () {
        svgParent.setAttribute('style', 'filter: grayscale(1);');
    };

    ['focusin', 'mouseenter'].forEach(function (evt) {
        svgParent.addEventListener(evt, showColour);
    });

    ['focusout', 'mouseleave'].forEach(function (evt) {
        svgParent.addEventListener(evt, showGreyscale);
    });
}


/* ==========================================================================
   Results file upload - global scope, called from the JEM override's
   inline onchange= attribute. 

   NOTE: this still posts to /templates/syo/upload.php, which is the
   unauthenticated upload endpoint flagged during the incident review. The
   endpoint needs replacing before results uploading is re-enabled; this
   client-side code will need its URL updated to match at that point.
   ========================================================================== */

function handleFiles(input) {
    "use strict";

    var file = input.files[0];

    var eventDate = input.dataset.eventDate;
    var eventVenue = input.dataset.eventVenue;
    var customFieldIndex = input.id.replace('file_upload', '');
    var fileType = camelise(
        document.getElementById('jform_custom' + customFieldIndex + '-lbl').innerHTML.trim()
    );

    // Based on https://www.webcodegeeks.com/html5/html5-file-upload-example/
    var url = '/templates/syo/upload.php';
    var xhr = new XMLHttpRequest();
    var formData = new FormData();
    xhr.open("POST", url, true);

    formData.append('eventDate', eventDate);
    formData.append('eventVenue', eventVenue);
    formData.append('fileType', fileType);

    var progressBar = document.getElementById('progressbar' + customFieldIndex);
    var inputField = document.getElementById('jform_custom' + customFieldIndex);
    var errorMessage = document.getElementById('helpBlock' + customFieldIndex);
    var fileUpload = document.getElementById('file_upload' + customFieldIndex);

    if (file.size > 20971520) {
        errorState(inputField, progressBar, errorMessage, fileUpload,
                   "Error, file greater than limit of 20 MB");
        return;
    }

    xhr.upload.addEventListener("progress", function (e) {
        var pc = parseInt(e.loaded / e.total * 100);
        progressBar.parentElement.style.display = 'flex';
        progressBar.setAttribute('style', 'width: ' + pc + '%; display: flex;');
        progressBar.parentElement.setAttribute('aria-valuenow', pc);
    }, false);

    xhr.onloadstart = function () {
        resetState(inputField, progressBar, fileUpload, errorMessage);
    };

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if ((xhr.status == 200) && !((xhr.responseText).toLowerCase().includes("error"))) {
                successState(inputField, progressBar, fileUpload, xhr.responseText);
            } else {
                errorState(inputField, progressBar, errorMessage, fileUpload, xhr.responseText);
            }
        }
    };

    formData.append("upload_file", file);
    xhr.send(formData);
}

function errorState(inputField, progressBar, errorMessage, fileUpload, response) {
    console.error('The file did not upload successfully. If this problem persists please contact the website administrator.');

    inputField.setAttribute('aria-invalid', 'true');
    inputField.setAttribute('class', 'form-control inputbox is-invalid');

    fileUpload.value = '';

    progressBar.parentElement.style.display = 'flex';
    progressBar.parentElement.setAttribute('aria-valuenow', '100');
    progressBar.setAttribute('style', 'width: 100%; display: flex;');
    progressBar.setAttribute('class', 'progress-bar bg-danger');

    errorMessage.style.display = 'inherit';
    // textContent rather than innerHTML: the response is server output and
    // should never be parsed as markup.
    errorMessage.textContent = response;
}

function successState(inputField, progressBar, fileUpload, response) {
    console.log('The file was successfully uploaded with a response of: ' + response);

    inputField.value = response;
    inputField.setAttribute('aria-invalid', 'false');
    inputField.setAttribute('class', 'form-control inputbox is-valid');

    fileUpload.value = '';

    progressBar.parentElement.style.display = 'flex';
    progressBar.parentElement.setAttribute('aria-valuenow', '100');
    progressBar.setAttribute('style', 'width: 100%; display: flex;');
    progressBar.setAttribute('class', 'progress-bar bg-success');
}

function resetState(inputField, progressBar, fileUpload, errorMessage) {
    inputField.setAttribute('aria-invalid', 'false');
    inputField.setAttribute('class', 'form-control inputbox');

    fileUpload.value = '';

    progressBar.parentElement.style.display = 'flex';
    progressBar.setAttribute('aria-hidden', 'false');
    progressBar.parentElement.setAttribute('aria-valuenow', '0');
    progressBar.setAttribute('style', 'width: 0%; display: flex;');
    progressBar.setAttribute('class', 'progress-bar bg-info');

    errorMessage.style.display = 'none';
}

// From http://stackoverflow.com/a/2970667/1433614
function camelise(str) {
    return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function (letter, index) {
        return index == 0 ? letter.toLowerCase() : letter.toUpperCase();
    }).replace(/\s+/g, '');
}
