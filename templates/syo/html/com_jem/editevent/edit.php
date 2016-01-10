<?php
/**
 * @version 2.1.4
 * @package JEM
 * @copyright (C) 2013-2015 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');

// Add uploadify code
$document = JFactory::getDocument();
$document->addStyleSheet($this->baseurl.'/templates/syo/uploadify/uploadify.css');
// Need to add jQuery again as Joomla jQuery isn't ready at this point
$document->addScript('http://code.jquery.com/jquery-1.11.3.min.js');
$document->addScript($this->baseurl."/templates/syo/uploadify/jquery.uploadify-3.1.min.js");

// Create shortcut to parameters.
$params		= $this->params;
$settings	= json_decode($this->item->attribs);

$max_custom_fields = $this->settings->get('global_editevent_maxnumcustomfields', -1); // default to All
?>

<script type="text/javascript">
	// This can't be placed in an external JS file and included nicely in the header because the 
	// inline PHP statements do not execute.
	jQuery.noConflict();
	jQuery(document).ready(function() 
	{
		jQuery('.uploadifyfile').uploadify(
		{
			'buttonClass'   : 'btn btn-default btn-block',
			'hideButton'	: true,
  			'transparent'   : true,
			'swf'			: '<?php echo $this->baseurl; ?>/templates/syo/uploadify/uploadify.swf',
			'uploader'		: '<?php echo $this->baseurl; ?>/templates/syo/uploadify/uploadify.php',
			'auto'			: true,		// automatically upload files when added to the queue
  			'height'     	: '34',
  			'width'			: '100',
			'fileSizeLimit'	: '20MB',
			'fileTypeExts'	: '*.pdf; *.jpg; *.jpeg; *.txt; *.rtf; *.doc; *.docx; *.xlsx; *.xls; *.htm; *.html;',
			'fileTypeDesc'	: 'Upload only the following files: \n .pdf, .jpg, .jpeg, .txt, .rtf, .doc(x), .xls(x), .htm, .html',
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
				var eventVenue = '<?php echo $this->item->localias; ?>';

				jQuery(uploadid).uploadify('settings','formData',{ 'eventDate' : eventDate, 'eventVenue' : eventVenue, 'fileType' : fileType });
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
	});
</script>

<script type="text/javascript">
	window.addEvent('domready', function(){
	checkmaxplaces();
	});

	function checkmaxplaces(){
		var maxplaces = $('jform_maxplaces');

		if (maxplaces != null){
			$('jform_maxplaces').addEvent('change', function(){
				if ($('event-available')) {
					var val = parseInt($('jform_maxplaces').value);
					var booked = parseInt($('event-booked').value);
					$('event-available').value = (val-booked);
				}
			});

			$('jform_maxplaces').addEvent('keyup', function(){
				if ($('event-available')) {
					var val = parseInt($('jform_maxplaces').value);
					var booked = parseInt($('event-booked').value);
					$('event-available').value = (val-booked);
				}
			});
		}
	}
</script>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'event.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			<?php echo $this->form->getField('articletext')->save(); ?>
			Joomla.submitform(task);
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<div class="<?php echo $this->pageclass_sfx; ?>">
	<div class="edit item-page">
		<?php if ($params->get('show_page_heading')) : ?>
		<h1>
			<?php echo $this->escape($params->get('page_heading')); ?>
		</h1>
		<?php endif; ?>

		<form enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_jem&a_id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-horizontal form-validate">
			<div class="row event-buttons">
				<div class="col-sm-offset-2 col-sm-4 col-xs-6">
					<button type="button" class="btn btn-success btn-block" onclick="Joomla.submitbutton('event.save')"><?php echo JText::_('JSAVE') ?></button>
				</div>
				<div class="col-sm-4 col-xs-6">
					<button type="button" class="btn btn-danger btn-block" onclick="Joomla.submitbutton('event.cancel')"><?php echo JText::_('JCANCEL') ?></button>
				</div>
			</div>

			<?php if ($this->item->recurrence_type > 0) : ?>
			<div class="description">
				<div class="pull-left;">
					<?php echo JemOutput::recurrenceicon($this->item, false, false); ?>
				</div>
				<div class="floattext" style="margin-left:36px;">
					<strong><?php echo JText::_('COM_JEM_EDITEVENT_WARN_RECURRENCE_TITLE'); ?></strong>
					<br>
					<?php
						if (!empty($this->item->recurrence_type) && empty($this->item->recurrence_first_id)) {
							echo nl2br(JText::_('COM_JEM_EDITEVENT_WARN_RECURRENCE_FIRST_TEXT'));
						} else {
							echo nl2br(JText::_('COM_JEM_EDITEVENT_WARN_RECURRENCE_TEXT'));
						}
					?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($this->params->get('showintrotext')) : ?>
			<div class="description no_space floattext">
				<?php echo $this->params->get('introtext'); ?>
			</div>
			<?php endif; ?>

			<fieldset>
				<legend><?php echo JText::_('COM_JEM_EDITEVENT_DETAILS_LEGEND'); ?></legend>
				<div class="form-group">
					<div class="col-sm-2 cantAccessLabel"><?php echo $this->form->getLabel('title'); ?></div>
					<div class="col-sm-8"><?php echo $this->form->getInput('title'); ?></div>
				</div>

				<div class="form-group">
					<div class="col-sm-2 cantAccessLabel"><?php echo $this->form->getLabel('locid'); ?></div>
					<div class="col-sm-6 col-xs-9"><?php echo $this->form->getInput('locid'); ?></div>
				</div>

				<div class="form-group">
					<div class="col-sm-2 cantAccessLabel"><?php echo $this->form->getLabel('cats'); ?></div>
					<div class="col-sm-8"><?php echo $this->form->getInput('cats'); ?></div>
				</div>

				<!--Calendar icon issue in html.php - core file...-->
				<div class="form-group">
					<div class="col-sm-2 cantAccessLabel"><?php echo $this->form->getLabel('dates'); ?></div>
					<div class="col-sm-8 col-xs-12"><?php echo $this->form->getInput('dates'); ?></div>
				</div>

				<div class="form-group">
					<div class="col-sm-2 cantAccessLabel"><?php echo $this->form->getLabel('enddates'); ?></div>
					<div class="col-sm-8 col-xs-12"><?php echo $this->form->getInput('enddates'); ?></div>
				</div>

				<div class="form-group">
					<div class="col-sm-2 cantAccessLabel"><?php echo $this->form->getLabel('times'); ?></div>
					<div class="col-sm-4 col-xs-6"><?php echo $this->form->getInput('times'); ?></div>
				</div>

				<div class="form-group">
					<div class="col-sm-2 cantAccessLabel"><?php echo $this->form->getLabel('endtimes'); ?></div>
					<div class="col-sm-4 col-xs-6"><?php echo $this->form->getInput('endtimes'); ?></div>
				</div>

				<div class="form-group">
					<div class="col-sm-2 cantAccessLabel"><?php echo $this->form->getLabel('published'); ?></div>
					<div class="col-sm-8"><?php echo $this->form->getInput('published'); ?></div>
				</div>

				<?php if ($max_custom_fields != 0) :
				$custom_file_fields =array(1, 2, 3, 4, 8, 10);

				$fields = $this->form->getFieldset('custom');
				if ($max_custom_fields < 0) :
					$max_custom_fields = count($fields);
				endif;
				$cnt = 0;
				
				foreach($fields as $field) :
				if (++$cnt <= $max_custom_fields) : ?>

				<div class="form-group">
					<div class="col-sm-2 cantAccessLabel"><?php echo $field->label; ?></div>
					<div class="col-sm-8 col-xs-10"><?php echo $field->input; ?></div>

				<?php if (in_array($cnt, $custom_file_fields)) : ?>
					<input type="file" name="file_upload" id="file_upload<?php echo $cnt; ?>" class="col-sm-2 col-xs-2 uploadifyfile" />
				<?php endif; ?>

				</div>
				<?php endif; endforeach; endif; ?>

				<div class="form-group">
					<div class="col-sm-2 cantAccessLabel"><?php echo $this->form->getLabel('articletext'); ?></div>
					<div class="col-sm-8"><?php echo $this->form->getInput('articletext'); ?></div>
				</div>
			</fieldset>
		
			<?php //echo $this->loadTemplate('other'); ?>
					
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
			<input type="hidden" name="author_ip" value="<?php echo $this->item->author_ip; ?>" />
			<?php if($this->params->get('enable_category', 0) == 1) :?>
			<input type="hidden" name="jform[catid]" value="<?php echo $this->params->get('catid', 1);?>"/>
			<?php endif;?>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>
</div>
