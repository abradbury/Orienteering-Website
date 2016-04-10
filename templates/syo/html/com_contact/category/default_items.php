<?php
/**
* @package     Joomla.Site
* @subpackage  com_contact
*
* @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/
defined('_JEXEC') or die;
JHtml::_('behavior.core');
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?>
<?php if (empty($this->items)) : ?>
<p> <?php echo JText::_('COM_CONTACT_NO_CONTACTS'); ?>   </p>
<?php else : ?>
<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
	<?php if ($this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) :?>
	<fieldset class="filters btn-toolbar">
		<?php if ($this->params->get('filter_field') != 'hide') :?>
		<div class="btn-group">
			<label class="filter-search-lbl element-invisible" for="filter-search"><span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span><?php echo JText::_('COM_CONTACT_FILTER_LABEL') . '&#160;'; ?></label>
			<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_CONTACT_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo JText::_('COM_CONTACT_FILTER_SEARCH_DESC'); ?>" />
		</div>
		<?php endif; ?>
		<?php if ($this->params->get('show_pagination_limit')) : ?>
		<div class="btn-group pull-right">
			<label for="limit" class="element-invisible">
				<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
			</label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		<?php endif; ?>
	</fieldset>
	<?php endif; ?>
	<div class="row link-grid">
		<?php foreach ($this->items as $i => $item) : ?>
		<?php if (in_array($item->access, $this->user->getAuthorisedViewLevels())) : ?>
		<?php if ($this->items[$i]->published == 0) : ?>
		<a class="col-sm-3 col-xs-6 system-unpublished cat-list-row<?php echo $i % 2; ?> contact" href="<?php echo JRoute::_(ContactHelperRoute::getContactRoute($item->slug, $item->catid)); ?>">
		<?php else: ?>
		<a class="col-sm-3 col-xs-6 cat-list-row<?php echo $i % 2; ?> contact" href="<?php echo JRoute::_(ContactHelperRoute::getContactRoute($item->slug, $item->catid)); ?>">
			<?php endif; ?>
			<div class="contactText">
				<?php if ($this->params->get('show_position_headings')) : ?>
				<h4 class="contactRole"><?php echo $item->con_position; ?></h4>
				<?php endif; ?>
				<p class="contactName"><?php echo $item->name; ?></p>
			</div>
		</a>
		<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<?php if ($this->params->get('show_pagination', 2)) : ?>
	<div class="pagination">
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
		<p class="counter">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
		<?php endif; ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>
	<div>
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</div>
</form>
<?php endif; ?>