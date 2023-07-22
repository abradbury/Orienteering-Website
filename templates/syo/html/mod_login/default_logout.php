<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
?>

<form action="<?php echo JRoute::_(JUri::getInstance()->toString(), true, $params->get('usesecure')); ?>" method="post" id="login-form" class="form-inline nav-link">
	<span>
		<?php if ($params->get('greeting')) : ?>
		<?php if ($params->get('name') == 0) : {
			$uname = $user->get('name');
			$nameParts = explode(' ', $uname);
			echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($nameParts[0]));
		} else : {
			echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('username')));
		} endif; ?>
		<?php endif; ?>
	</span>

	<input type="submit" name="Submit" class="btn btn-link" id="logout-btn" value="<?php echo JText::_('JLOGOUT'); ?>" />
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
