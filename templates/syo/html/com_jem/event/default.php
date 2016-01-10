<?php
/**
 * @version 2.1.4
 * @package JEM
 * @copyright (C) 2013-2015 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params		= $this->item->params;

$images 	= json_decode($this->item->datimage);
$canEdit	= $this->item->params->get('access-edit');
$user		= JFactory::getUser();
$attribs 	= json_decode($this->item->attribs);

JHtml::_('behavior.modal', 'a.flyermodal');
?>
<?php if ($params->get('access-view')) { /* This will show nothings otherwise - ??? */ ?>
<div id="jem" class="row event_id<?php echo $this->item->did; ?> jem_event<?php echo $this->pageclass_sfx;?>" itemscope="itemscope" itemtype="http://schema.org/SportsEvent">
	<div class="buttons">
		<?php
		if ($params->get('event_show_email_icon',1)) {
		echo JemOutput::mailbutton($this->item->slug, 'event', $this->params);
		}
		if ($params->get('event_show_print_icon',1)) {
		echo JemOutput::printbutton($this->print_link, $this->params);
		}
		if ($params->get('event_show_ical_icon',1)) {
		echo JemOutput::icalbutton($this->item->slug, 'event');
		}
		?>
	</div>

	<div class="clr"> </div>

	<div class="col-sm-9">
		<h1>
			<span itemprop="name"><?php echo $this->escape($this->params->get('page_heading')); ?></span>
			<?php echo JemOutput::editbutton($this->item, $params, $attribs, $this->allowedtoeditevent, 'editevent'); ?>
		</h1>
		
		<div class="clr"> </div>

		<p class="eventSubtitle">A <span><?php echo $this->escape($this->categories[0]->catname); ?></span> event at <span itemprop="location"><?php echo $this->escape($this->item->venue); ?></span></p>
		<p class="eventSubtitle">On <span>
			<?php echo JemOutput::formatLongDateTime($this->item->dates, $this->item->times,$this->item->enddates, $this->item->endtimes);?>
			<?php echo JemOutput::formatSchemaOrgDateTime($this->item->dates, $this->item->times,$this->item->enddates, $this->item->endtimes);?>
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
	<?php if ($this->item->registra == 1) : ?>
		<h2 class="register"><?php echo JText::_('COM_JEM_REGISTRATION').':'; ?></h2>
		<?php echo $this->loadTemplate('attendees'); ?>
	<?php endif; ?>

	<?php if (!empty($this->item->pluginevent->onEventEnd)) : ?>
		<hr>
		<?php echo $this->item->pluginevent->onEventEnd; ?>
	<?php endif; ?>

</div>

<?php }
?>
