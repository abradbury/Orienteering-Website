<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
?>
<div class="row reset-confirm<?php echo $this->pageclass_sfx?>">
	<div class="col-8 offset-2">

		<?php if ($this->params->get('show_page_heading')) : ?>
			<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		<?php endif; ?>

		<form action="<?php echo JRoute::_('index.php?option=com_users&task=reset.confirm'); ?>" method="post" class="form-validate form-horizontal well">
			<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
				<fieldset>
					<p><?php echo JText::_($fieldset->label); ?></p>
					<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
						<?php echo $field->label; ?>
						<?php echo $field->input; ?>
					<?php endforeach; ?>
				</fieldset>
			<?php endforeach; ?>

			<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JSUBMIT'); ?></button>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>
</div>
