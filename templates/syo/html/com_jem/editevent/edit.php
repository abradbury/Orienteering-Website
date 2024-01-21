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
		   ->useScript('form.validate')
		   ->addInlineScript('
		   	function fixSelectInputs() {
		   		["starthours", "startminutes", "endhours", "endminutes"].map((id) => {
		   			const item = document.getElementById(id);
		   			item.classList.add("form-select");
		   			item.style.width = "auto";
		   			item.style.display = "inline";
		   		});
		   	}

			function fixVenueSelectInput() {
				var venueName = document.getElementById("jform_locid_name");
				venueName.classList.add("form-control");

				var parent = venueName.parentNode;
				var wrapper = document.createElement("div");
				wrapper.classList.add("input-group");

				var venueSelect = parent.getElementsByClassName("btn-link")[0] // Not the best way...
				venueSelect.classList = ["btn btn-outline-secondary"];

				parent.replaceChild(wrapper, venueName);
				wrapper.appendChild(venueName);
				wrapper.appendChild(venueSelect);
			}
		   
		   	window.onload = (event) => {
		   		fixSelectInputs();
				fixVenueSelectInput();
		   	}
		   ', [], ['defer' => true], []);

// Create shortcut to parameters.
$params		= $this->params;

?>

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'event.cancel' || document.formvalidator.isValid(document.getElementById('adminForm'))) {
			Joomla.submitform(task);
		} else {
			alert('<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<div id="jem" class="jem_editevent<?php echo $this->pageclass_sfx; ?>">
	<div class="edit item-page">
		<?php if ($params->get('show_page_heading')) : ?>
		<h1>
			<?php echo $this->escape($params->get('page_heading')); ?>
		</h1>
		<?php endif; ?>

		<form enctype="multipart/form-data" action="<?php echo Route::_('index.php?option=com_jem&a_id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
			<div class="mb-3">
				<button type="submit" class="btn btn-primary" onclick="Joomla.submitbutton('event.save')"><?php echo Text::_('JSAVE') ?></button>
				<button type="cancel" class="btn btn-secondary" onclick="Joomla.submitbutton('event.cancel')"><?php echo Text::_('JCANCEL') ?></button>
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
					<div class="row mb-3">
						<div class="col">
							<?php echo $this->form->getLabel('dates'); ?>
							<?php echo $this->form->getInput('dates'); ?>
						</div>
						<div class="col">
							<?php echo $this->form->getLabel('times'); ?>
							<div><?php echo $this->form->getInput('times'); ?></div>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col">
							<?php echo $this->form->getLabel('enddates'); ?>
							<?php echo $this->form->getInput('enddates'); ?>
						</div>
						<div class="col">
							<?php echo $this->form->getLabel('endtimes'); ?>
							<div><?php echo $this->form->getInput('endtimes'); ?></div>
						</div>
					</div>
					<div class="mb-3">
						<?php echo $this->form->getLabel('cats'); ?>
						<div><?php echo $this->form->getInput('cats'); ?></div>
					</div>
					<div class="mb-3">
						<?php echo $this->form->getLabel('locid'); ?>
                      	<div><?php echo $this->form->getInput('locid'); ?></div>
					</div>
					<div class="mb-3">
						<?php echo $this->form->getLabel('articletext'); ?>
						<?php echo $this->form->getInput('articletext'); ?>
					</div>
				</div>
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

			<?php echo $this->loadTemplate('other'); ?>
			<?php echo $this->loadTemplate('publish'); ?>
			<div style="display:none;">
				<?php echo $this->loadTemplate('extended'); ?>
			</div>
			
			<?php if (!empty($this->item->attachments) || ($this->jemsettings->attachmentenabled != 0)) : ?>
				<?php echo $this->loadTemplate('attachments'); ?>
			<?php endif; ?>

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
