<?php
/**
 * @version 4.0.0
 * @package JEM
 * @copyright (C) 2013-2023 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license https://www.gnu.org/licenses/gpl-3.0 GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

// HTMLHelper::_('behavior.keepalive');
// HTMLHelper::_('behavior.tooltip');
// HTMLHelper::_('behavior.calendar');
// HTMLHelper::_('behavior.formvalidation');

$app = Factory::getApplication();
$document = $app->getDocument();
$wa = $document->getWebAssetManager();
		$wa->useScript('keepalive')
			->useScript('form.validate');
			//->useScript('behavior.calendar');

// Create shortcut to parameters.
$params		= $this->params;
// $settings	= json_decode($this->item->attribs);

?>

<script type="text/javascript">
	jQuery(document).ready(function($){
		function checkmaxplaces(){
			var maxplaces = $('jform_maxplaces');

			if (maxplaces != null){
				$('#jform_maxplaces').on('change', function(){
					if ($('#event-available')) {
						var val = parseInt($('#jform_maxplaces').val());
						var booked = parseInt($('#event-booked').val());
						$('event-available').val() = (val-booked);
					}
				});

				$('#jform_maxplaces').on('keyup', function(){
					if ($('event-available')) {
						var val = parseInt($('jform_maxplaces').val());
						var booked = parseInt($('event-booked').val());
						$('event-available').val() = (val-booked);
					}
				});
			}
		}
		checkmaxplaces();
	});
</script>
<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'event.cancel' || document.formvalidator.isValid(document.getElementById('adminForm'))) {
			Joomla.submitform(task);
		} else {
			alert('<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<script type="text/javascript">
	jQuery(document).ready(function($){
		var showUnregistraUntil = function(){
			var unregistra = $("#jform_unregistra");
			var unregistramode = unregistra.val();

			if (unregistramode == 2) {
				document.getElementById('jform_unregistra_until').style.display = '';
				document.getElementById('jform_unregistra_until2').style.display = '';
			} else {
				document.getElementById('jform_unregistra_until').style.display = 'none';
				document.getElementById('jform_unregistra_until2').style.display = 'none';
			}
		}

		$("#jform_unregistra").on('change', showUnregistraUntil);
		showUnregistraUntil();
	})
</script>

<div id="jem" class="jem_editevent<?php echo $this->pageclass_sfx; ?>">
	<div class="edit item-page">
		<?php if ($params->get('show_page_heading')) : ?>
		<h1>
			<?php echo $this->escape($params->get('page_heading')); ?>
		</h1>
		<?php endif; ?>

		<form enctype="multipart/form-data" action="<?php echo Route::_('index.php?option=com_jem&a_id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
			<div class="row event-buttons">
				<button type="submit" class="btn btn-primary w-50" onclick="Joomla.submitbutton('event.save')"><?php echo Text::_('JSAVE') ?></button>
				<button type="cancel" class="btn btn-secondary w-50" onclick="Joomla.submitbutton('event.cancel')"><?php echo Text::_('JCANCEL') ?></button>
			</div>

			<?php if ($this->item->recurrence_type > 0) : ?>
			<div class="description">
				<div style="float:left;">
					<?php echo JemOutput::recurrenceicon($this->item, false, false); ?>
				</div>
				<div class="floattext" style="margin-left:36px;">
					<strong><?php echo Text::_('COM_JEM_EDITEVENT_WARN_RECURRENCE_TITLE'); ?></strong>
					<br>
					<?php
						if (!empty($this->item->recurrence_type) && empty($this->item->recurrence_first_id)) {
							echo nl2br(Text::_('COM_JEM_EDITEVENT_WARN_RECURRENCE_FIRST_TEXT'));
						} else {
							echo nl2br(Text::_('COM_JEM_EDITEVENT_WARN_RECURRENCE_TEXT'));
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
				<legend><?php echo Text::_('COM_JEM_EDITEVENT_DETAILS_LEGEND'); ?></legend>
				<div class="adminformlist">
					<div class="mb-3">
						<?php echo $this->form->getLabel('title'); ?>
						<?php echo $this->form->getInput('title'); ?>
					</div>
					<?php if (is_null($this->item->id)):?>
					<div class="mb-3">
						<?php echo $this->form->getLabel('alias'); ?>
						<?php echo $this->form->getInput('alias'); ?>
					</div>
					<?php endif; ?>
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
						<div><?php echo $this->form->getInput('times'); ?></div>
					</div>
					<div class="mb-3">
						<?php echo $this->form->getLabel('endtimes'); ?>
						<div><?php echo $this->form->getInput('endtimes'); ?></div>
					</div>
					<div class="mb-3">
						<?php echo $this->form->getLabel('cats'); ?>
						<div><?php echo $this->form->getInput('cats'); ?></div>
					</div>
					<div class="mb-3">
						<?php echo $this->form->getLabel('locid'); ?>
                      	<div><?php echo $this->form->getInput('locid'); ?></div>
					</div>
				</div>
			</fieldset>

			<fieldset class="mb-3">
				<legend><?php echo Text::_('COM_JEM_EVENT_DESCRIPTION'); ?></legend>
				<?php echo $this->form->getLabel('articletext'); ?>
				<?php echo $this->form->getInput('articletext'); ?>
			</fieldset>

			<?php if ($this->item->datimage || $this->jemsettings->imageenabled != 0) : ?>
			<fieldset class="jem_fldst_image">
				<legend><?php echo Text::_('COM_JEM_IMAGE'); ?></legend>
				<?php
				if ($this->item->datimage) :
					echo JemOutput::flyer($this->item, $this->dimage, 'event', 'datimage');
					?><input type="hidden" name="datimage" id="datimage" value="<?php echo $this->item->datimage; ?>" /><?php
				endif;
				?>
				<?php if ($this->jemsettings->imageenabled != 0) : ?>
				<ul class="adminformlist">
					<li>
						<?php /* We get field with id 'jform_userfile' and name 'jform[userfile]' */ ?>
						<?php echo $this->form->getLabel('userfile'); ?> <?php echo $this->form->getInput('userfile'); ?>
					</li>
					<li>
						<button type="button" class="button3" onclick="document.getElementById('jform_userfile').val() = ''"><?php echo Text::_('JSEARCH_FILTER_CLEAR') ?></button>
					</li>
					<?php if ($this->item->datimage) :
						echo HTMLHelper::image('media/com_jem/images/publish_r.png', null, array('id' => 'userfile-remove', 'data-id' => $this->item->id, 'data-type' => 'events', 'title' => Text::_('COM_JEM_REMOVE_IMAGE')));
					endif; ?>
					<input type="hidden" name="removeimage" id="removeimage" value="0" />
				</ul>
				<?php endif; ?>
			</fieldset>
			<?php endif; ?>

			<?php 
			// Extended contains: recurrence, contact and registration
            // Must be shown otherwise an error is thrown on submission due to an invalid recurrence value
			echo $this->loadTemplate('extended');
            // Must be shown otherwise events are unpublished by default...
			echo $this->loadTemplate('publish'); 
			?>
			
			<?php if (!empty($this->item->attachments) || ($this->jemsettings->attachmentenabled != 0)) : ?>
				<?php echo $this->loadTemplate('attachments'); ?>
			<?php endif; ?>

			<?php echo $this->loadTemplate('other'); ?>

			<input type="hidden" name="task" value="" />
			<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
			<input type="hidden" name="author_ip" value="<?php echo $this->item->author_ip; ?>" />
			<?php if($this->params->get('enable_category', 0) == 1) :?>
			<input type="hidden" name="jform[catid]" value="<?php echo $this->params->get('catid', 1);?>"/>
			<?php endif;?>
			<?php echo HTMLHelper::_('form.token'); ?>
		</form>
	</div>
</div>
