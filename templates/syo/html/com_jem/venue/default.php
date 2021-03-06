<?php
/**
 * @version 2.1.7
 * @package JEM
 * @copyright (C) 2013-2016 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

?>
<div id="jem" class="jem_venue<?php echo $this->pageclass_sfx;?>" itemscope="itemscope" itemtype="http://schema.org/Place">

	<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<div class="row">
			<div class="col-sm-8">
				<h1>
					<span itemprop="name"><?php echo $this->escape($this->params->get('page_heading')); ?></span>
					<?php echo JemOutput::editbutton($this->venue, $this->params, NULL, $this->permissions->canEditVenue, 'venue'); ?>
				</h1>
			</div>
			<div class="col-sm-4 buttons">
				<?php
				$btn_params = array('id' => $this->venue->slug, 'slug' => $this->venue->slug, 'task' => $this->task, 'print_link' => $this->print_link);
				echo str_replace('class=" hasTooltip"', 'class="btn btn-primary pull-right btn-block" role="button"', JemOutput::createButtonBar($this->getName(), $this->permissions, $btn_params));
				?>
			</div>
		</div>
	<?php endif; ?>

	<?php
	if ($this->settings->get('global_show_mapserv')== 2) {
		echo JemOutput::mapicon($this->venue,null,$this->settings);
	}
	?>
		<?php $this->show_status = false; if (isset($this->venue->published) && !empty($this->show_status)) : ?>
	<!-- PUBLISHING STATE -->
		<dl>
			<dt class="published"><?php echo JText::_('JSTATUS'); ?>:</dt>
			<dd class="published">
				<?php switch ($this->venue->published) {
				case  1: echo JText::_('JPUBLISHED');   break;
				case  0: echo JText::_('JUNPUBLISHED'); break;
				case  2: echo JText::_('JARCHIVED');    break;
				case -2: echo JText::_('JTRASHED');     break;
				} ?>
			</dd>
		</dl>
	<?php endif; ?>

	<?php if ($this->settings->get('global_show_mapserv')== 3) : ?>
		<input type="hidden" id="latitude" value="<?php echo $this->venue->latitude;?>">
		<input type="hidden" id="longitude" value="<?php echo $this->venue->longitude;?>">

		<input type="hidden" id="venue" value="<?php echo $this->venue->venue;?>">
		<input type="hidden" id="street" value="<?php echo $this->venue->street;?>">
		<input type="hidden" id="city" value="<?php echo $this->venue->city;?>">
		<input type="hidden" id="state" value="<?php echo $this->venue->state;?>">
		<input type="hidden" id="postalCode" value="<?php echo $this->venue->postalCode;?>">
		<?php echo JemOutput::mapicon($this->venue,null,$this->settings); ?>
		<?php if($this->venue->map == "1"): ?>
		<p class="mapcaveat small">Please note the map above is just to give an indication of where the venue is, specific details should be given in an event's details.</p>
		<?php endif; ?>
	<?php endif; ?>


	<?php if ($this->settings->get('global_show_locdescription',1) && $this->venuedescription != '' &&
	          $this->venuedescription != '<br />') : ?>

		<h2 class="description"><?php echo JText::_('COM_JEM_VENUE_DESCRIPTION'); ?></h2>
		<div class="description no_space floattext" itemprop="description">
			<?php echo $this->venuedescription; ?>
		</div>
	<?php endif; ?>

	<?php $this->attachments = $this->venue->attachments; ?>
	<?php echo $this->loadTemplate('attachments'); ?>

	<!--table-->
	<form action="<?php echo htmlspecialchars($this->action); ?>" method="post" id="adminForm" class="form-inline">
		<?php echo $this->loadTemplate('table'); ?>

		<p>
		<input type="hidden" name="option" value="com_jem" />
		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
		<input type="hidden" name="view" value="venue" />
		<input type="hidden" name="id" value="<?php echo $this->venue->id; ?>" />
		</p>
	</form>

	<!--pagination-->
	<div class="pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>

	<?php echo JemOutput::icalbutton($this->venue->id, 'venue'); ?>

</div>
