
	var eaventDate = '<?php echo $this->item->dates; ?>';
	var avenueAlias = '<?php echo $this->item->localias; ?>';
	alert(eaventDate + '  ' + avenueAlias);

	$('.uploadifyfile').uploadify(
	{
		'swf'			: 'http://localhost/syo/templates/syo/uploadify/uploadify.swf',
		'uploader'		: 'http://localhost/syo/templates/syo/uploadify/uploadify.php',
		'auto'			: true,		// automatically upload files when added to the queue
		'height'		: 15,
		'fileSizeLimit'	: '20MB',
		'fileTypeExts'	: '*.pdf; *.jpg; *.jpeg; *.txt; *.rtf; *.doc; *.xls; *.htm; *.html;',
		'fileTypeDesc'	: 'Upload only the following files: \n .pdf, .jpg, .jpeg, .txt, .rtf, .doc, .xls, .htm, .html',
		'debug'			: false,
		'buttonText'	: 'Choose File',
		'multi'			: false,	// only 1 file allowed to be selected for upload at a time
		'uploadLimit'	: 10,		// max amount of files allowed to upload for each button
		'method'		: 'post',
		'formData'		: { 'eventDate' : 'notSet', 'eventVenue' : 'notSet', 'fileType' : 'notSet' },
		'onUploadSuccess' : function(file, data, response) 
		{	
			//console.log('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ' : ' + data);
			if(data != null){
				document.getElementById('adminForm')[buttonPressed].value = data;
			}
			else {
				alert('The file ' + file.name + 'did not upload successfully. If this problem persists please contact the website administrator (onUploadSuccess error).');
			}
		},
		'onUploadError' : function(file, errorCode, errorMsg, errorString) {
            alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
        },
		'onUploadStart' : function(file) 
		{			
			// This receives the date and venue of the event and passes this data to the server.
			// The server checks if there is a directory of the form yyyy-mm-dd-venue. If not, 
			// one is created. The file is placed in this directory.
			var eventDate = '<?php echo $this->item->dates; ?>';
			var eventVenue = 'test';

			$(uploadid).uploadify('settings','formData',{ 'eventDate' : eventDate, 'eventVenue' : eventVenue, 'fileType' : fileType });
		},
		'onSelect' : function(event, ID, fileObj)
		{
			//alert('event.id:' + event.id);	//SWF_Upload_n_0, n:0-infinite
			
			var eid = event.id;

			if(eid.indexOf('SWFUpload_0') != -1)		// Flyer
			{
				// To make the variable 'buttonPressed' global (and hence accessible from the 'onUploadSuccess' 
				// function) I assigned it to the window. Same with 'uploadid' and 'fileType.
				window.buttonPressed = 'jform_custom1';
				window.uploadid = '#file_upload1';
				window.fileType = 'flyer';
			}
			else if(eid.indexOf('SWFUpload_1') != -1)	// Final Details
			{
				window.buttonPressed = 'jform_custom2';
				window.uploadid = '#file_upload2';
				window.fileType = 'finalDetails';
			}
			else if(eid.indexOf('SWFUpload_2') != -1)	// Start List
			{
				window.buttonPressed = 'jform_custom3';
				window.uploadid = '#file_upload3';
				window.fileType = 'startList';
			}
			else if(eid.indexOf('SWFUpload_3') != -1)	// Results
			{
				window.buttonPressed = 'jform_custom4';
				window.uploadid = '#file_upload4';
				window.fileType = 'results';
			}
			else if(eid.indexOf('SWFUpload_4') != -1)	// Comments
			{
				window.buttonPressed = 'jform_custom8';
				window.uploadid = '#file_upload8';
				window.fileType = 'comments';
			}
			else if(eid.indexOf('SWFUpload_5') != -1)	// Other
			{
				window.buttonPressed = 'jform_custom10';
				window.uploadid = '#file_upload10';
				window.fileType = 'other';
			}
			else
			{
				alert('There was an error in uploading the file. If this problem persists please contact the website administrator (onSelect error).');
			}
		}
	});
