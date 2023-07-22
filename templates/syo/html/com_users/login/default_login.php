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
?>
<div class="row login<?php echo $this->pageclass_sfx?>">
	<div class="col-8 offset-2">
		<?php if ($this->params->get('show_page_heading')) : ?>
			<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		<?php endif; ?>

		<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate">
			<?php foreach ($this->form->getFieldset('credentials') as $field) : ?>
				<?php if (!$field->hidden) : ?>
					<?php echo $field->label; ?>
					<?php echo $field->input; ?>
				<?php endif; ?>
			<?php endforeach; ?>

			<?php if ($this->tfa): ?>
				<?php echo $this->form->getField('secretkey')->label; ?>
				<?php echo $this->form->getField('secretkey')->input; ?>
			<?php endif; ?>

			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
				<div class="form-check">
					<input id="remember" type="checkbox" name="remember" class="form-check-input" value="yes"/>
					<label class="form-check-label"><?php echo JText::_('COM_USERS_LOGIN_REMEMBER_ME') ?></label>
				</div>
			<?php endif; ?>

			<div>
				<ul>
					<li>
						<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
						<?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
					</li>
					<li>
						<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
						<?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
					</li>
					<?php
					$usersConfig = JComponentHelper::getParams('com_users');
					if ($usersConfig->get('allowUserRegistration')) : ?>
					<li>
						<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
							<?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
					</li>
					<?php endif; ?>
				</ul>
			</div>

			<button type="submit" class="btn btn-primary">
				<?php echo JText::_('JLOGIN'); ?>
			</button>

			<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>
</div>
