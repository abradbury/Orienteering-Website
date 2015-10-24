<?php
/**
 * @version 2.0.0
 * @package JEM
 * @copyright (C) 2013-2014 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;


?>
<div id="jem" class="jem_eventslist<?php echo $this->pageclass_sfx;?>">
	<div class="buttons">
		<?php
			echo JemOutput::submitbutton($this->dellink, $this->params);
			echo JemOutput::archivebutton($this->params, $this->task);
			echo JemOutput::printbutton($this->print_link, $this->params);
		?>
	</div>

	<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	<?php endif; ?>

	<div class="clr"></div>

	<?php if ($this->params->get('showintrotext')) : ?>
		<div class="description no_space floattext">
			<?php echo $this->params->get('introtext'); ?>
		</div>
	<?php endif; ?>

	<!--table-->

	<form action="<?php echo $this->action; ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
		<?php echo $this->loadTemplate('events_table'); ?>

		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
		<input type="hidden" name="task" value="<?php echo $this->task; ?>" />
		<input type="hidden" name="view" value="eventslist" />
	</form>

	
	
	<?php if ($this->params->get('showfootertext')) : ?>
		<div class="description no_space floattext">
			<?php echo $this->params->get('footertext'); ?>
		</div>
	<?php endif; ?>
	<!--footer-->

	<div class="pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<!-- <div id="iCal" class="iCal">
	<?php echo JemOutput::icalbutton('', 'eventslist'); ?>
	</div> -->
</div>