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

// Create shortcut to parameters.
$params		= $this->params;
$settings	= json_decode($this->item->attribs);
$max_custom_fields = $this->settings->get('global_editevent_maxnumcustomfields', -1); // default to All
?>

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
				<div class="offset-2 col-4">
					<button type="button" class="w-100 btn btn-success" onclick="Joomla.submitbutton('event.save')"><?php echo JText::_('JSAVE') ?></button>
				</div>
				<div class="col-4">
					<button type="button" class="w-100 btn btn-danger" onclick="Joomla.submitbutton('event.cancel')"><?php echo JText::_('JCANCEL') ?></button>
				</div>
			</div>

			<?php if ($this->item->recurrence_type > 0) : ?>
			<div class="description">
				<div class="float-start;">
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
				
				<div class="mb-3">
					<?php echo $this->form->getLabel('title'); ?>
					<?php echo $this->form->getInput('title'); ?>
				</div>

				<div class="mb-3">
					<?php echo $this->form->getLabel('locid'); ?>
					<?php echo $this->form->getInput('locid'); ?>
				</div>

				<div class="mb-3">
					<?php echo $this->form->getLabel('cats'); ?>
					<?php echo $this->form->getInput('cats'); ?>
				</div>

				<div class="mb-3">
					<?php echo $this->form->getLabel('dates'); ?>
					<?php echo $this->form->getInput('dates'); ?>
				</div>

				<div class="mb-3">
					<?php echo $this->form->getLabel('enddates'); ?>
					<?php echo $this->form->getInput('enddates'); ?>
				</div>

				<div class="mb-3">
					<?php echo $this->form->getLabel('times'); ?>
					<?php echo $this->form->getInput('times'); ?>
				</div>

				<div class="mb-3">
					<?php echo $this->form->getLabel('endtimes'); ?>
					<?php echo $this->form->getInput('endtimes'); ?>
				</div>

				<div class="mb-3">
					<?php echo $this->form->getLabel('published'); ?>
					<?php echo $this->form->getInput('published'); ?>
				</div>

				<?php if ($max_custom_fields != 0) :
				$custom_file_fields = array(1, 2, 3, 4, 8, 10);

				$fields = $this->form->getFieldset('custom');
				if ($max_custom_fields < 0) :
					$max_custom_fields = count($fields);
				endif;
				$cnt = 0;
				
				foreach($fields as $field) :
					if (++$cnt <= $max_custom_fields) :
						$isCustomFileInput = in_array($cnt, $custom_file_fields);?>
						
						<div class="mb-3">
						<?php 
						echo $field->label;

						if ($isCustomFileInput) { ?>
							<div class="row">
								<div class="col-10">
						<?php }

									echo $field->input;

						if ($isCustomFileInput) : ?>
								</div>
								<div class="col-2">
									<input 
										type="file" 
										name="file_upload" 
										id="file_upload<?php echo $cnt; ?>" 
										accept=".pdf,.jpg,.jpeg,.txt,.rtf,.doc,.docx,.xlsx,.xls,.htm,.html"
										onchange="handleFiles(this);" 
										class="file_upload_button"
										data-event-date="<?php if(isset($this->item->dates)) : echo $this->item->dates; else: echo 'date'; endif; ?>"
										data-event-venue="<?php if (isset($this->item->localias)) : echo $this->item->localias; else : echo 'location'; endif; ?>"
									>
									<label class="btn btn-outline-secondary w-100" for="file_upload<?php echo $cnt; ?>">Choose a file</label>
								</div>
								
								<div class="col-10 progress" role="progressbar" aria-label="File upload progress bar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
									<div class="progress-bar bg-info progress-bar-striped progress-bar-animated" id="progressbar<?php echo $cnt; ?>" style="width: 100%"></div>
								</div>

								<div class="col-10">
									<div id="helpBlock<?php echo $cnt; ?>" class="alert alert-danger errorMsg" role="alert"></div>
								</div>
							</div>
						<?php endif; ?>
				<?php endif; ?>
					</div>
				<?php endforeach; endif; ?>

				<?php echo $this->form->getLabel('articletext'); ?>
				<?php echo $this->form->getInput('articletext'); ?>
			</fieldset>
							
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
