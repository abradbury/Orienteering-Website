<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_users/helpers/route.php';

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

?>

<div class="modal fade" id="login" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
	  		<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h1 class="modal-title" id="exampleModalLabel"><?php echo $module->title; ?></h1>
	  		</div>

		  	<div class="modal-body">
				<form action="<?php echo JRoute::_(JUri::getInstance()->toString(), true, $params->get('usesecure')); ?>" method="post" id="login-form">
					<?php if ($params->get('pretext')) : ?>
						<div class="pretext">
							<p><?php echo $params->get('pretext'); ?></p>
						</div>
					<?php endif; ?>
					<div class="userdata">
						<div id="form-login-username" class="form-group">
							<?php if (!$params->get('usetext')) : ?>
								<div class="input-prepend">
									<span class="add-on">
										<span class="glyphicon glyphicon-user hasTooltip" title="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>"></span>
										<label for="modlgn-username" class="control-label element-invisible"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME'); ?></label>
									</span>
									<input required id="modlgn-username" type="text" name="username" class="form-control input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
								</div>
							<?php else: ?>
								<label class="control-label" for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label>
								<input required id="modlgn-username" type="text" name="username" class="form-control input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?>" />
							<?php endif; ?>
						</div>
						<div id="form-login-password" class="form-group">
							<?php if (!$params->get('usetext')) : ?>
								<div class="input-prepend">
									<span class="add-on">
										<span class="glyphicon glyphicon-lock hasTooltip" title="<?php echo JText::_('JGLOBAL_PASSWORD') ?>">
										</span>
											<label for="modlgn-passwd" class="control-label element-invisible"><?php echo JText::_('JGLOBAL_PASSWORD'); ?>
										</label>
									</span>
									<input required id="modlgn-passwd" type="password" name="password" class="form-control input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
								</div>
							<?php else: ?>
								<label class="control-label" for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
								<input required id="modlgn-passwd" type="password" name="password" class="form-control input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
							<?php endif; ?>
						</div>
						<?php if (count($twofactormethods) > 1): ?>
						<div id="form-login-secretkey" class="control-group">
							<div class="controls">
								<?php if (!$params->get('usetext')) : ?>
									<div class="input-prepend input-append">
										<span class="add-on">
											<span class="icon-star hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>">
											</span>
												<label for="modlgn-secretkey" class="element-invisible"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?>
											</label>
										</span>
										<input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
										<span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
											<span class="icon-help"></span>
										</span>
								</div>
								<?php else: ?>
									<label for="modlgn-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY') ?></label>
									<input id="modlgn-secretkey" autocomplete="off" type="text" name="secretkey" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY') ?>" />
									<span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
										<span class="icon-help"></span>
									</span>
								<?php endif; ?>

							</div>
						</div>
						<?php endif; ?>
						<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
						<div id="form-login-remember" class="checkbox">
							<label for="modlgn-remember" class="control-label">
								<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"> <?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?>
							</label>
						</div>
						<?php endif; ?>
						
						<?php
							$usersConfig = JComponentHelper::getParams('com_users'); ?>
							<ul class="unstyled">
							<?php if ($usersConfig->get('allowUserRegistration')) : ?>
								<li>
									<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration&Itemid=' . UsersHelperRoute::getRegistrationRoute()); ?>">
									<?php echo JText::_('MOD_LOGIN_REGISTER'); ?> <span class="icon-arrow-right"></span></a>
								</li>
							<?php endif; ?>
								<li>
									<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind&Itemid=' . UsersHelperRoute::getRemindRoute()); ?>">
									<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
								</li>
								<li>
									<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset&Itemid=' . UsersHelperRoute::getResetRoute()); ?>">
									<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
								</li>
							</ul>
						<input type="hidden" name="option" value="com_users" />
						<input type="hidden" name="task" value="user.login" />
						<input type="hidden" name="return" value="<?php echo $return; ?>" />
						<?php echo JHtml::_('form.token'); ?>
					</div>
					<?php if ($params->get('posttext')) : ?>
						<div class="posttext">
							<p><?php echo $params->get('posttext'); ?></p>
						</div>
					<?php endif; ?>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo JText::_('TPL_SYO_LOGIN_CLOSE') ?></button>
				<button type="submit" id="login-form-submit-button" class="btn btn-primary" name="Submit"><?php echo JText::_('JLOGIN') ?></button>
			</div>
		</div>
	</div>
</div>
