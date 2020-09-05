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

$document = JFactory::getDocument();
$app = JFactory::getApplication();

// For some reason none of the usual CCS gets included in modal windows
$document->addStyleSheet($this->baseurl.'/templates/syo/css/bootstrap.min.css?v=337');
$document->addStyleSheet($this->baseurl.'/templates/syo/css/template.css?v=451');
$document->addStyleSheet($this->baseurl.'/templates/syo/css/font-awesome.min.css?v=5130');
$document->addScript($this->baseurl.'/templates/syo/js/bootstrap.min.js?v=337');

$document->addScriptDeclaration("
	Joomla.submitbutton = function(pressbutton){
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if (\$K2.trim(\$K2('#title').val()) == '') {
			alert( '".JText::_('K2_ITEM_MUST_HAVE_A_TITLE', true)."' );
		}
		else if (\$K2.trim(\$K2('#catid').val()) == '0') {
			alert( '".JText::_('K2_PLEASE_SELECT_A_CATEGORY', true)."' );
		}
		else {
			syncExtraFieldsEditor();
			var validation = validateExtraFields();
			if(validation === true) {
				\$K2('#selectedTags option').attr('selected', 'selected');
				submitform( pressbutton );
			}
		}
	};
");

?>

<?php if($app->isSite()): ?>
<div id="k2ModalContainer">
<?php endif; ?>

<form class="form-horizontal" action="<?php echo JURI::root(true); ?>/index.php" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm" onkeypress="return event.keyCode != 13;">
	<?php if($app->isSite()): ?>
	<div id="k2Frontend">
		<div id="k2FrontendEditToolbar" <?php if(JRequest::getInt('cid')): ?>style="display: none"<?php endif; ?>>
			<div class="row event-buttons">
				<div class="col-sm-offset-2 col-sm-4 col-xs-6">
					<button id="saveEdit" type="button" class="btn btn-success btn-block" onclick="Joomla.submitbutton('save'); return false;"><?php echo JText::_('K2_SAVE'); ?></button>
				</div>
				<div class="col-sm-4 col-xs-6">
					<button id="cancelEdit" type="button" class="btn btn-danger btn-block" onclick="window.parent.closeModal();"><?php echo JText::_('K2_CLOSE'); ?></button>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-offset-2 col-sm-8">
					<small>When adding a new article, clicking the save button will save the article and cause the page to reload. If the save was successful, a green popup saying "Item saved" will briefly appear upon which you can safely navigate away from the page. Do not use the reloaded page to edit the saved article, instead navigate to where that article is and use the "Edit Item" link next to the article's title.</small>
				</div>
			</div>
		</div>
	<?php endif; ?>

		<fieldset>
			<legend>Basic Details</legend>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="title"><?php echo JText::_('K2_TITLE'); ?></label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="title" id="title" maxlength="250" value="<?php echo $this->row->title; ?>" required />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="alias"><?php echo JText::_('K2_TITLE_ALIAS'); ?></label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="alias" id="alias" maxlength="250" value="<?php echo $this->row->alias; ?>" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_CATEGORY'); ?></label>
				<div class="col-sm-8">
					<?php echo $this->lists['categories']; ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="tags"><?php echo JText::_('K2_TAGS'); ?></label>
				<div class="col-sm-8">
					<?php if($this->params->get('taggingSystem')): ?>
					<!-- Free tagging -->
					<ul class="tags">
						<?php if(isset($this->row->tags) && count($this->row->tags)): ?>
						<?php foreach($this->row->tags as $tag): ?>
						<li class="tagAdded">
							<?php echo $tag->name; ?>
							<span title="<?php echo JText::_('K2_CLICK_TO_REMOVE_TAG'); ?>" class="tagRemove">&times;</span>
							<input type="hidden" name="tags[]" value="<?php echo $tag->name; ?>" />
						</li>
						<?php endforeach; ?>
						<?php endif; ?>
						<li class="tagAdd">
							<input type="text" id="search-field" />
						</li>
						<li class="clr"></li>
					</ul>
					<p class="k2TagsNotice">
						<?php echo JText::_('K2_WRITE_A_TAG_AND_PRESS_RETURN_OR_COMMA_TO_ADD_IT'); ?>
					</p>
					<?php else: ?>
					<!-- Selection based tagging -->
					<?php if( !$this->params->get('lockTags') || $this->user->gid>23): ?>
					<div style="float:left;">
						<input type="text" name="tag" id="tag" />
						<input type="button" id="newTagButton" value="<?php echo JText::_('K2_ADD'); ?>" />
					</div>
					<div id="tagsLog"></div>
					<div class="clr"></div>
					<span class="k2Note">
						<?php echo JText::_('K2_WRITE_A_TAG_AND_PRESS_ADD_TO_INSERT_IT_TO_THE_AVAILABLE_TAGS_LISTNEW_TAGS_ARE_APPENDED_AT_THE_BOTTOM_OF_THE_AVAILABLE_TAGS_LIST_LEFT'); ?>
					</span>
					<?php endif; ?>
					<table cellspacing="0" cellpadding="0" border="0" id="tagLists">
						<tr>
							<td id="tagListsLeft">
								<span><?php echo JText::_('K2_AVAILABLE_TAGS'); ?></span> <?php echo $this->lists['tags'];	?>
							</td>
							<td id="tagListsButtons">
								<input type="button" id="addTagButton" value="<?php echo JText::_('K2_ADD'); ?> &raquo;" />
								<br />
								<br />
								<input type="button" id="removeTagButton" value="&laquo; <?php echo JText::_('K2_REMOVE'); ?>" />
							</td>
							<td id="tagListsRight">
								<span><?php echo JText::_('K2_SELECTED_TAGS'); ?></span> <?php echo $this->lists['selectedTags']; ?>
							</td>
						</tr>
					</table>
					<?php endif; ?>
				</div>
			</div>

			<?php if($app->isAdmin() || ($app->isSite() && $this->permissions->get('publish')  || ($this->permissions->get('editPublished') && $this->row->id && $this->row->published)  )): ?>
			<?php if($this->permissions->get('publish')): ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="featured"><?php echo JText::_('K2_IS_IT_FEATURED'); ?></label>
				<div class="col-sm-8 form-radio">
					<?php echo $this->lists['featured']; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_PUBLISHED'); ?></label>
				<div class="col-sm-8 form-radio">
					<?php echo $this->lists['published']; ?>
				</div>
			</div>
			<?php endif; ?>
		</fieldset>

		<!-- Tab content -->
		<fieldset>
			<legend><?php echo JText::_('K2_CONTENT'); ?></legend>
		
			<label for="editor" class="sr-only"><?php echo JText::_('K2_CONTENT'); ?></label>

			<?php if($this->params->get('mergeEditors')): ?>
			<div class="k2ItemFormEditor col-sm-12" id="editor"> <?php echo $this->text; ?>
				<div class="dummyHeight"></div>
				<div class="clr"></div>
			</div>
			<?php else: ?>
			<div class="k2ItemFormEditor col-sm-8" id="editor"> <span class="k2ItemFormEditorTitle"> <?php echo JText::_('K2_INTROTEXT_TEASER_CONTENTEXCERPT'); ?> </span> <?php echo $this->introtext; ?>
				<div class="dummyHeight"></div>
				<div class="clr"></div>
			</div>
			<div class="k2ItemFormEditor col-sm-8" id="editor"> <span class="k2ItemFormEditorTitle"> <?php echo JText::_('K2_FULLTEXT_MAIN_CONTENT'); ?> </span> <?php echo $this->fulltext; ?>
				<div class="dummyHeight"></div>
				<div class="clr"></div>
			</div>
			<?php endif; ?>
			<?php if (count($this->K2PluginsItemContent)): ?>
			<div class="itemPlugins">
				<?php foreach($this->K2PluginsItemContent as $K2Plugin): ?>
				<?php if(!is_null($K2Plugin)): ?>
				<fieldset>
					<legend><?php echo $K2Plugin->name; ?></legend>
					<?php echo $K2Plugin->fields; ?>
				</fieldset>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<div class="clr"></div>
		</fieldset>

		<!-- Tab extra fields -->
		<?php if ($this->params->get('showExtraFieldsTab')): ?>
		<fieldset>
			<legend><?php echo JText::_('K2_EXTRA_FIELDS'); ?></legend>
			<div id="extraFieldsContainer">
				<?php if (count($this->extraFields)): ?>
				<table class="admintable" id="extraFields">
					<?php foreach($this->extraFields as $extraField): ?>
					<?php if($extraField->type == 'header'): ?>
					<tr>
						<td colspan="2" ><h4 class="k2ExtraFieldHeader"><?php echo $extraField->name; ?></h4></td>
					</tr>
					<?php else: ?>
					<tr>
						<td align="right" class="key">
							<label class="col-sm-2 control-label" for="K2ExtraField_<?php echo $extraField->id; ?>"><?php echo $extraField->name; ?></label>
						</td>
						<td>
							<?php echo $extraField->element; ?>
						</td>
					</tr>
					<?php endif; ?>
					<?php endforeach; ?>
				</table>
				<?php else: ?>
					<?php if (K2_JVERSION == '15'): ?>
						<dl id="system-message">
							<dt class="notice"><?php echo JText::_('K2_NOTICE'); ?></dt>
							<dd class="notice message fade">
								<ul>
									<li><?php echo JText::_('K2_PLEASE_SELECT_A_CATEGORY_FIRST_TO_RETRIEVE_ITS_RELATED_EXTRA_FIELDS'); ?></li>
								</ul>
							</dd>
						</dl>
					<?php elseif (K2_JVERSION == '25'): ?>
					<div id="system-message-container">
						<dl id="system-message">
							<dt class="notice"><?php echo JText::_('K2_NOTICE'); ?></dt>
							<dd class="notice message">
								<ul>
									<li><?php echo JText::_('K2_PLEASE_SELECT_A_CATEGORY_FIRST_TO_RETRIEVE_ITS_RELATED_EXTRA_FIELDS'); ?></li>
								</ul>
							</dd>
						</dl>
					</div>
					<?php else: ?>
					<div class="alert">
						<h4 class="alert-heading"><?php echo JText::_('K2_NOTICE'); ?></h4>
						<div>
							<p><?php echo JText::_('K2_PLEASE_SELECT_A_CATEGORY_FIRST_TO_RETRIEVE_ITS_RELATED_EXTRA_FIELDS'); ?></p>
						</div>
					</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<?php if (count($this->K2PluginsItemExtraFields)): ?>
			<div class="itemPlugins">
				<?php foreach($this->K2PluginsItemExtraFields as $K2Plugin): ?>
				<?php if(!is_null($K2Plugin)): ?>
				<fieldset>
					<legend><?php echo $K2Plugin->name; ?></legend>
					<?php echo $K2Plugin->fields; ?>
				</fieldset>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</fieldset>
		<?php endif; ?>

		<fieldset>
			<legend><?php echo JText::_('K2_PUBLISHING_AND_METADATA'); ?></legend>
			
			<?php if(isset($this->lists['language'])): ?>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_LANGUAGE'); ?></label>
				<div class="col-sm-8">
					<?php echo $this->lists['language']; ?>
				</div>
			</div>
			<?php endif; ?>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_AUTHOR'); ?></label>
				<div class="col-sm-4">
					<p class="form-control-static" id="k2Author"><?php echo $this->row->author; ?></p>
				</div>	
				<?php if($app->isAdmin() || ($app->isSite() && $this->permissions->get('editAll'))): ?>
				<div class="col-sm-4">
					<a class="modal" rel="{handler:'iframe', size: {x: 800, y: 460}}" href="index.php?option=com_k2&amp;view=users&amp;task=element&amp;tmpl=component"><?php echo JText::_('K2_CHANGE'); ?></a>
					<input type="hidden" name="created_by" value="<?php echo $this->row->created_by; ?>" />
				</div>
				<?php endif; ?>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_AUTHOR_ALIAS'); ?></label>
				<div class="col-sm-8">
					<input class="text_area" type="text" name="created_by_alias" maxlength="250" value="<?php echo $this->row->created_by_alias; ?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_ACCESS_LEVEL'); ?></label>
				<div class="col-sm-8">
					<?php echo $this->lists['access']; ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_CREATION_DATE'); ?></label>
				<div class="col-sm-8 k2ItemFormDateField">
					<?php echo $this->lists['createdCalendar']; ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_START_PUBLISHING'); ?></label>
				<div class="col-sm-8 k2ItemFormDateField">
					<?php echo $this->lists['publish_up']; ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_FINISH_PUBLISHING'); ?></label>
				<div class="col-sm-8 k2ItemFormDateField">
					<?php echo $this->lists['publish_down']; ?>
				</div>
			</div>
		</fieldset>

		<?php if(!($app->isSite() && !$this->params->get('sideBarDisplayFrontend'))): ?>
		<fieldset id="adminFormK2Sidebar" class="xmlParamsFields">
			<legend>Item Information</legend>

			<?php if($this->row->id): ?>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_ITEM_ID'); ?></label>
				<div class="col-sm-8">
					<p class="form-control-static"><?php echo $this->row->id; ?></p>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_PUBLISHED'); ?></label>
				<div class="col-sm-8">
					<p class="form-control-static"><?php echo ($this->row->published > 0) ? JText::_('K2_YES') : JText::_('K2_NO'); ?></p>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_FEATURED'); ?></label>
				<div class="col-sm-8">
					<p class="form-control-static"><?php echo ($this->row->featured > 0) ? JText::_('K2_YES'):	JText::_('K2_NO'); ?></p>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_CREATED_DATE'); ?></label>
				<div class="col-sm-8">
					<p class="form-control-static"><?php echo $this->lists['created']; ?></p>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_CREATED_BY'); ?></label>
				<div class="col-sm-8">
					<p class="form-control-static"><?php echo $this->row->author; ?></p>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_MODIFIED_DATE'); ?></label>
				<div class="col-sm-8">
					<p class="form-control-static"><?php echo $this->lists['modified']; ?></p>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_MODIFIED_BY'); ?></label>
				<div class="col-sm-8">
					<p class="form-control-static"><?php echo $this->row->moderator; ?></p>
				</div>
			</div>
				
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_HITS'); ?></label>
				<div class="col-sm-6">
					<p class="form-control-static"><?php echo $this->row->hits; ?></p>
				</div>
				
				<?php if($this->row->hits): ?>
				<div class="col-sm-2">
					<input id="resetHitsButton" type="button" value="<?php echo JText::_('K2_RESET'); ?>" class="btn btn-default btn-block" name="resetHits" />
				</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php if($this->row->id): ?>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo JText::_('K2_RATING'); ?></label>
				<div class="col-sm-6">
					<p class="form-control-static"><?php echo $this->row->ratingCount; ?> <?php echo JText::_('K2_VOTES'); ?>
					<?php if($this->row->ratingCount): ?>
						(<?php echo JText::_('K2_AVERAGE_RATING'); ?>: <?php echo number_format(($this->row->ratingSum/$this->row->ratingCount),2); ?>/5.00)
					<?php endif; ?>
					</p>
				</div>

				<div class="col-sm-2">
					<input id="resetRatingButton" type="button" value="<?php echo JText::_('K2_RESET'); ?>" class="btn btn-default btn-block" name="resetRating" />
				</div>
			</div>
			<?php endif; ?>
		</fieldset>

		<fieldset>
			<legend><?php echo JText::_('K2_METADATA_INFORMATION'); ?></legend>
			<div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo JText::_('K2_DESCRIPTION'); ?></label>
					<div class="col-sm-8">
						<textarea class="form-control" name="metadesc" rows="5" cols="20"><?php echo $this->row->metadesc; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo JText::_('K2_KEYWORDS'); ?></label>
					<div class="col-sm-8">
						<textarea class="form-control" name="metakey" rows="5" cols="20"><?php echo $this->row->metakey; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo JText::_('K2_ROBOTS'); ?></label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="meta[robots]" value="<?php echo $this->lists['metadata']->get('robots'); ?>" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo JText::_('K2_AUTHOR'); ?></label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="meta[author]" value="<?php echo $this->lists['metadata']->get('author'); ?>" />
					</div>
				</div>
			</div>
		</fieldset>

		<?php endif; ?>		

		<input type="hidden" name="isSite" value="<?php echo (int)$app->isSite(); ?>" />
		<?php if($app->isSite()): ?>
		<input type="hidden" name="lang" value="<?php echo JRequest::getCmd('lang'); ?>" />
		<?php endif; ?>
		<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
		<input type="hidden" name="option" value="com_k2" />
		<input type="hidden" name="view" value="item" />
		<input type="hidden" name="task" value="<?php echo JRequest::getVar('task'); ?>" />
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getInt('Itemid'); ?>" />
		<?php echo JHTML::_('form.token'); ?>		

		<div class="clr"></div>
		<?php if($app->isSite()): ?>
	</div>
	<?php endif; ?>
</form>

<?php if($app->isSite()): ?>
</div>
<?php endif; ?>