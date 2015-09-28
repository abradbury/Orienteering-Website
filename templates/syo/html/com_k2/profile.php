<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- K2 user profile form -->
<form action="<?php echo JURI::root(true); ?>/index.php" enctype="multipart/form-data" method="post" name="userform" autocomplete="off" class="form-horizontal form-validate">
	<?php if($this->params->def('show_page_title',1)): ?>
	<h1 class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</h1>
	<?php endif; ?>
	<div id="k2Container" class="k2AccountPage">

		<fieldset>
			<div class="form-group">
				<label for="username" class="col-sm-2 control-label"><?php echo JText::_('K2_USER_NAME'); ?></label>
				<div class="col-sm-8">
					<p class="form-control-static"><?php echo $this->user->get('username'); ?></p>
				</div>
			</div>

			<div class="form-group">
				<label id="namemsg" for="name" class="col-sm-2 control-label"><?php echo JText::_('K2_NAME'); ?></label>
				<div class="col-sm-8">
					<input type="text" name="<?php echo $this->nameFieldName; ?>" id="name" size="40" value="<?php echo $this->escape($this->user->get( 'name' )); ?>" class="inputbox form-control required" maxlength="50" />
				</div>
			</div>

			<div class="form-group">
				<label id="emailmsg" for="email" class="col-sm-2 control-label"><?php echo JText::_('K2_EMAIL'); ?></label>
				<div class="col-sm-8">
					<input type="text" id="email" name="<?php echo $this->emailFieldName; ?>" size="40" value="<?php echo $this->escape($this->user->get( 'email' )); ?>" class="inputbox form-control required validate-email" maxlength="100" />
				</div>
			</div>

			<?php if(version_compare(JVERSION, '2.5', 'ge')): ?>
			<div class="form-group">
				<label id="email2msg" for="email2" class="col-sm-2 control-label"><?php echo JText::_('K2_CONFIRM_EMAIL'); ?> *</label>
				<div class="col-sm-8">
					<input type="text" id="email2" name="jform[email2]" size="40" value="<?php echo $this->escape($this->user->get( 'email' )); ?>" class="inputbox form-control required validate-email" maxlength="100" />
				</div>
			</div>
			<?php endif; ?>

			<div class="form-group">
				<label id="pwmsg" for="password" class="col-sm-2 control-label"><?php echo JText::_('K2_PASSWORD'); ?></label>
				<div class="col-sm-8">
					<input class="inputbox form-control validate-password" type="password" id="password" name="<?php echo $this->passwordFieldName; ?>" size="40" value="" />
				</div>
			</div>

			<div class="form-group">
				<label id="pw2msg" for="password2" class="col-sm-2 control-label"><?php echo JText::_('K2_VERIFY_PASSWORD'); ?></label>
				<div class="col-sm-8">
					<input class="inputbox form-control validate-passverify" type="password" id="password2" name="<?php echo $this->passwordVerifyFieldName; ?>" size="40" value="" />
				</div>
			</div>

			<div class="form-group">
				<label id="pw2msg" for="password2" class="col-sm-2 control-label"><?php echo JText::_('K2_VERIFY_PASSWORD'); ?></label>
				<div class="col-sm-8">
					<input class="inputbox form-control validate-passverify" type="password" id="password2" name="<?php echo $this->passwordVerifyFieldName; ?>" size="40" value="" />
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend><?php echo JText::_('K2_PERSONAL_DETAILS'); ?></legend>

			<div class="form-group">
				<label id="gendermsg" for="gender" class="col-sm-2 control-label"><?php echo JText::_('K2_GENDER'); ?></label>
				<div class="col-sm-8">
					<?php echo $this->lists['gender']; ?>
				</div>
			</div>

			<div class="form-group">
				<label id="descriptionmsg" for="description" class="col-sm-2 control-label"><?php echo JText::_('K2_DESCRIPTION'); ?></label>
				<div class="col-sm-8">
					<?php echo $this->editor; ?>
				</div>
			</div>	

			<div class="form-group">
				<label id="imagemsg" for="image" class="col-sm-2 control-label"><?php echo JText::_( 'K2_USER_IMAGE_AVATAR' ); ?></label>
				<div class="col-sm-8">
					<input type="file" id="image" class="form-control" name="image"/>
					<?php if ($this->K2User->image): ?>
					<img class="k2AccountPageImage" src="<?php echo JURI::root(true).'/media/k2/users/'.$this->K2User->image; ?>" alt="<?php echo $this->user->name; ?>" />
					<input type="checkbox" name="del_image" id="del_image" />
					<label for="del_image"><?php echo JText::_('K2_CHECK_THIS_BOX_TO_DELETE_CURRENT_IMAGE_OR_JUST_UPLOAD_A_NEW_IMAGE_TO_REPLACE_THE_EXISTING_ONE'); ?></label>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group">
				<label id="urlmsg" for="url" class="col-sm-2 control-label"><?php echo JText::_('K2_URL'); ?></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" size="50" value="<?php echo $this->K2User->url; ?>" name="url" id="url"/>
				</div>
			</div>
		</fieldset>

		<?php if(count(array_filter($this->K2Plugins))): ?>
		<!-- K2 Plugin attached fields -->
		<fieldset>
			<legend><?php echo JText::_('K2_ADDITIONAL_DETAILS'); ?></legend>

			<?php foreach($this->K2Plugins as $K2Plugin): ?>
			<?php if(!is_null($K2Plugin)): ?>
			<div class="form-group">
					<?php echo $K2Plugin->fields; ?>
			</div>
			<?php endif; ?>
			<?php endforeach; ?>

		</fieldset>
		<?php endif; ?>

		<?php if(isset($this->params) && version_compare(JVERSION, '1.6', 'lt')): ?>
		<fieldset>
			<legend><?php echo JText::_('K2_ADMINISTRATIVE_DETAILS'); ?></legend>
			<div class="form-group">
				<?php echo $this->params->render('params'); ?>
			</div>
		</fieldset>
		<?php endif; ?>

		<?php if(isset($this->form)): ?>
		<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
			<?php if($fieldset->name != 'core'): ?>
			<?php $fields = $this->form->getFieldset($fieldset->name);?>
			<?php if (count($fields)):?>
				<?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.?>
				<fieldset>
					<legend><?php echo JText::_($fieldset->label);?></legend>
				</fieldset>
				<?php endif;?>
				<?php foreach($fields as $field):// Iterate through the fields in the set and display them.?>
					<?php if ($field->hidden):// If the field is hidden, just display the input.?>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-8">
								<?php echo $field->input;?>
							</div>
						</div>
					<?php else:?>
						<div class="form-group">
							<div class="col-sm-2">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer'): ?>
								<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
							<div class="col-sm-8">
								<?php echo $field->input;?>
							</div>
						</div>
					<?php endif;?>
				<?php endforeach;?>
			<?php endif;?>
			<?php endif; ?>
		<?php endforeach;?>
		<?php endif; ?>

		<div class="k2AccountPageUpdate">
			<div class="col-sm-2"></div>
			<button class="btn btn-success validate" type="submit" onclick="submitbutton( this.form );return false;">
				<?php echo JText::_('K2_SAVE'); ?>
			</button>
		</div>
	</div>
	<input type="hidden" name="<?php echo $this->usernameFieldName; ?>" value="<?php echo $this->user->get('username'); ?>" />
	<input type="hidden" name="<?php echo $this->idFieldName; ?>" value="<?php echo $this->user->get('id'); ?>" />
	<input type="hidden" name="gid" value="<?php echo $this->user->get('gid'); ?>" />
	<input type="hidden" name="option" value="<?php echo $this->optionValue; ?>" />
	<input type="hidden" name="task" value="<?php echo $this->taskValue; ?>" />
	<input type="hidden" name="K2UserForm" value="1" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
