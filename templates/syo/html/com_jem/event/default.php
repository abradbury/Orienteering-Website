<?php
/**
 * @version 2.2.1 (OLD)
 * @package JEM
 * @copyright (C) 2013-2017 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params  = $this->item->params;
$images  = json_decode($this->item->datimage);
$attribs = json_decode($this->item->attribs);
$user    = JemFactory::getUser();

$btn_params = array('slug' => $this->item->slug, 'print_link' => $this->print_link);

JHtml::_('behavior.modal', 'a.flyermodal');
?>
<?php if ($params->get('access-view')) { /* This will show nothings otherwise - ??? */ ?>
<div id="jem" class="row event_id<?php echo $this->item->did; ?> jem_event<?php echo $this->pageclass_sfx;?>" itemscope="itemscope" itemtype="http://schema.org/SportsEvent">

	<div class="clr"> </div>

	<div class="col-sm-9">
		<?php if ($this->params->get('show_page_heading', 1)) : ?>
			<div class="row">
				<div class="col-sm-8">
					<h1>
						<span itemprop="name"><?php echo $this->escape($this->params->get('page_heading')); ?></span>
						<?php echo JemOutput::editbutton($this->item, $params, $attribs, $this->permissions->canEditEvent, 'editevent'); ?>
					</h1>
				</div>
				<div class="col-sm-4 buttons">
					<?php echo str_replace('class=" hasTooltip"', 'class="btn btn-primary btn-block pull-right" role="button"', JemOutput::createButtonBar($this->getName(), $this->permissions, $btn_params)); ?>
				</div>
			</div>
		<?php else : ?>
			<div class="buttons">
				<?php echo str_replace('class=" hasTooltip"', 'class="btn btn-primary btn-block pull-right" role="button"', JemOutput::createButtonBar($this->getName(), $this->permissions, $btn_params)); ?>
			</div>
		<?php endif; ?>
		
		<div class="clr"> </div>

		<?php 
		// Handle multiple categories with comma separation with 'and' for last category
		$category_count = count($this->categories);
		$category_names = array_map(function($category) {
			return "<span>" . $this->escape($category->catname) . "</span>";
		}, $this->categories);
		$last_category = array_pop($category_names);

		if ($category_count > 1) {
			$category_text = implode(', ', $category_names);
			if ($category_text) {
				$category_text .= ' and ';
			}
			$category_text .= $last_category;
		} else {
			$category_text = $last_category;
		}
		?>
		<p class="eventSubtitle">A <?php echo $category_text; ?> event at <span itemprop="location"><?php echo $this->escape($this->item->venue); ?></span></p>		
		<p class="eventSubtitle"><?php $is_multiday_event = strlen($this->item->enddates) > 0;
			echo $is_multiday_event ? JText::_('COM_JEM_SEARCH_FROM') : JText::_('COM_JEM_EVENT_ON'); ?> <span>
			<?php 
				$date_time_string = str_replace(" - ", "</span> " . strtolower(JText::_('COM_JEM_UNTIL')) . " <span>",  JemOutput::formatLongDateTime($this->item->dates, $this->item->times,$this->item->enddates, $this->item->endtimes));
				if ($is_multiday_event) {
					$date_time_string = str_replace(", ", "</span> at <span>",  $date_time_string);
				} else {
					$date_time_string = str_replace(", ", "</span> " . strtolower(JText::_('COM_JEM_SEARCH_FROM')) . " <span>",  $date_time_string);					
				}
				echo $date_time_string;
				echo JemOutput::formatSchemaOrgDateTime($this->item->dates, $this->item->times,$this->item->enddates, $this->item->endtimes);
			?>
		</span></p>

		<!-- Event -->
		<dl class="event_info floattext">
			<?php
			$first = false;

			for($cr = 1; $cr <= 10; $cr++) {
				$currentRow = $this->item->{'custom'.$cr};
				
				if($currentRow) {
					if(!$first) {
						$first = true;
						echo "<hr />";
					}

					$currentRowNew = '<a rel="nofollow" href="'.$this->escape($currentRow).'">'. JText::_('TPL_SYO_JEM_EVENT_LINK_TEXT') . JText::_('COM_JEM_EVENT_CUSTOM_FIELD'.$cr) .'</a>';
				?>
					<dt class="custom<?php echo $cr; ?>"><?php echo JText::_('COM_JEM_EVENT_CUSTOM_FIELD'.$cr).':'; ?></dt>
					<dd class="custom<?php echo $cr; ?>"><?php echo $currentRowNew; ?></dd>
				<?php
				}
			}
			?>

			<?php if ($params->get('event_show_hits')) : ?>
			<dt class="hits"><?php echo JText::_('COM_JEM_EVENT_HITS_LABEL'); ?>:</dt>
			<dd class="hits"><?php echo JText::sprintf('COM_JEM_EVENT_HITS', $this->item->hits); ?></dd>
			<?php endif; ?>

			<!-- AUTHOR -->
			<?php if ($params->get('event_show_author') && !empty($this->item->author)) : ?>
			<dt class="createdby"><?php echo JText::_('COM_JEM_EVENT_CREATED_BY_LABEL'); ?>:</dt>
			<dd class="createdby">
				<?php $author = $this->item->created_by_alias ? $this->item->created_by_alias : $this->item->author; ?>
				<?php if (!empty($this->item->contactid2) && $params->get('event_link_author') == true) :
					$needle = 'index.php?option=com_contact&view=contact&id=' . $this->item->contactid2;
					$menu = JFactory::getApplication()->getMenu();
					$item = $menu->getItems('link', $needle, true);
					$cntlink = !empty($item) ? $needle . '&Itemid=' . $item->id : $needle;
					echo JText::sprintf('COM_JEM_EVENT_CREATED_BY', JHtml::_('link', JRoute::_($cntlink), $author));
				else :
					echo JText::sprintf('COM_JEM_EVENT_CREATED_BY', $author);
				endif;
				?>
			</dd>
			<?php endif; ?>

		<!-- PUBLISHING STATE -->
			<?php $this->showeventstate = false; if (!empty($this->showeventstate) && isset($this->item->published)) : ?>
			<dt class="published"><?php echo JText::_('JSTATUS'); ?>:</dt>
			<dd class="published">
				<?php switch ($this->item->published) {
				case  1: echo JText::_('JPUBLISHED');   break;
				case  0: echo JText::_('JUNPUBLISHED'); break;
				case  2: echo JText::_('JARCHIVED');    break;
				case -2: echo JText::_('JTRASHED');     break;
				} ?>
			</dd>
			<?php endif; ?>
		</dl>

		<hr />

		<!-- DESCRIPTION -->
		<?php if ($params->get('event_show_description','1') && ($this->item->fulltext != '' && $this->item->fulltext != '<br />' || $this->item->introtext != '' && $this->item->introtext != '<br />')) { ?>
		<h2 class="description"><?php echo JText::_('COM_JEM_EVENT_DESCRIPTION'); ?></h2>
		<div class="description event_desc" itemprop="description">

			<?php
			if ($params->get('access-view')) {
				echo $this->item->text;
			}
			/* optional teaser intro text for guests - NOT SUPPORTED YET */
			elseif (0 /*$params->get('event_show_noauth') == true and  $user->get('guest')*/ ) {
				echo $this->item->introtext;
				// Optional link to let them register to see the whole event.
				if ($params->get('event_show_readmore') && $this->item->fulltext != null) {
					$link1 = JRoute::_('index.php?option=com_users&view=login');
					$link = new JUri($link1);
					echo '<p class="readmore">';
						echo '<a href="'.$link.'">';
						if ($params->get('event_alternative_readmore') == false) {
							echo JText::_('COM_JEM_EVENT_REGISTER_TO_READ_MORE');
						} elseif ($readmore = $params->get('alternative_readmore')) {
							echo $readmore;
						}

						if ($params->get('event_show_readmore_title', 0) != 0) {
						    echo JHtml::_('string.truncate', ($this->item->title), $params->get('event_readmore_limit'));
						} elseif ($params->get('event_show_readmore_title', 0) == 0) {
						} else {
							echo JHtml::_('string.truncate', ($this->item->title), $params->get('event_readmore_limit'));
						} ?>
						</a>
					</p>
				<?php
				}
			} /* access_view / show_noauth */
			?>
		</div>
		<?php } ?>

	</div>

	<?php $this->attachments = $this->item->attachments; ?>
	<?php echo $this->loadTemplate('attachments'); ?>

	<!--  	Venue  -->
	<div class="col-sm-3">
		<?php if ($this->item->locid != 0) : ?>

		<div class="inner-events syo-module">
		  <div class="eventsHeader">
		    <h3 class="panel-title"><?php echo JText::_('TPL_SYO_JEM_VENUE_DESC'); ?></h3> 
		  </div>
			<?php echo $this->item->locdescription; ?>
			<a href="<?php echo JRoute::_(JemHelperRoute::getVenueRoute($this->item->venueslug)); ?>">More details about <?php echo $this->escape($this->item->venue); ?>...</a>
		</div>

		<?php $this->attachments = $this->item->vattachments; ?>
		<?php echo $this->loadTemplate('attachments'); ?>

		</div>
		<?php endif; ?>
	</div>

	<!-- Registration -->
	<?php if ($this->showAttendees) : ?>
		<h2 class="register"><?php echo JText::_('COM_JEM_REGISTRATION'); ?>:</h2>
		<?php echo $this->loadTemplate('attendees'); ?>
	<?php endif; ?>

	<?php if (!empty($this->item->pluginevent->onEventEnd)) : ?>
		<hr>
		<?php echo $this->item->pluginevent->onEventEnd; ?>
	<?php endif; ?>

</div>

<?php }
?>
