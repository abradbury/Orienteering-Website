<?php
/**
 * @version 4.0.0
 * @package JEM
 * @copyright (C) 2013-2023 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license https://www.gnu.org/licenses/gpl-3.0 GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params      = $this->item->params;
$images      = json_decode($this->item->datimage);
$attribs     = json_decode($this->item->attribs);
$user        = JemFactory::getUser();
$jemsettings = JemHelper::config();
$app         = Factory::getApplication();
$document    = $app->getDocument();
$uri         = Uri::getInstance();

// Add the "event safety and policy" module to the bottom of each event page.
// I'm not sure how this field is set otherwise, perhaps by developing a JEM plugin?
$this->item->pluginevent->onEventEnd = $this->item->pluginevent->onEventEnd . "{module 238}";

// Add expiration date, if old events will be archived or removed
if ($jemsettings->oldevent > 0) {
	$enddate = strtotime($this->item->enddates?:($this->item->dates?:date("Y-m-d")));
	$expDate = date("D, d M Y H:i:s", strtotime('+1 day', $enddate));
	$document->addCustomTag('<meta http-equiv="expires" content="' . $expDate . '"/>');
}

// HTMLHelper::_('behavior.modal', 'a.flyermodal');
?>
<?php if ($params->get('access-view')) { /* This will show nothings otherwise - ??? */ ?>
<div id="jem" class="row event_id<?php echo $this->item->did; ?> jem_event<?php echo $this->pageclass_sfx;?>"
	itemscope="itemscope" itemtype="https://schema.org/Event">
  
  <meta itemprop="url" content="<?php echo rtrim($uri->base(), '/').JRoute::_(JemHelperRoute::getEventRoute($this->item->slug)); ?>" />
  <meta itemprop="identifier" content="<?php echo rtrim($uri->base(), '/').JRoute::_(JemHelperRoute::getEventRoute($this->item->slug)); ?>" />

	<div class="clr"> </div>

	<div class="col-md-9">
		<div class="row">
			<div class="col-md-8">
			<?php if ($this->params->get('show_page_heading', 1)) : ?>
				<h1 class="componentheading mb-md-4">
					<?php echo $this->escape($this->params->get('page_heading')); ?>
				</h1>
			<?php endif; ?>
			</div>

			<div class="col-md-4 d-flex justify-content-between align-content-start mb-3 text-md-end d-md-grid justify-content-md-end">
				<?php
				$btn_params = array('slug' => $this->item->slug, 'print_link' => $this->print_link, 'hide' => array('addEvent', 'addVenue'));
				echo JemOutput::createButtonBar($this->getName(), $this->permissions, $btn_params);
				echo JemOutput::editbutton($this->item, $params, $attribs, $this->permissions->canEditEvent, 'editevent') .' ';
				echo JemOutput::copybutton($this->item, $params, $attribs, $this->permissions->canAddEvent, 'editevent');
				?>
			</div>
		</div>

		<!-- Event -->
		<dl class="event_info row">	
			<dt class="col-sm-3 when"><?php echo Text::_('COM_JEM_WHEN'); ?>:</dt>
			<dd class="col-sm-9 when">
				<?php
				echo JemOutput::formatLongDateTime($this->item->dates, $this->item->times,$this->item->enddates, $this->item->endtimes);
				echo JemOutput::formatSchemaOrgDateTime($this->item->dates, $this->item->times,$this->item->enddates, $this->item->endtimes);
				?>
			</dd>
			<?php if ($this->item->locid != 0) : ?>
			<dt class="col-sm-3 where"><?php echo Text::_('COM_JEM_WHERE'); ?>:</dt>
			<dd class="col-sm-9 where"><?php
				if (($params->get('event_show_detlinkvenue') == 1) && (!empty($this->item->url))) :
					?><a target="_blank" href="<?php echo $this->item->url; ?>"><?php echo $this->escape($this->item->venue); ?></a><?php
				elseif (($params->get('event_show_detlinkvenue') == 2) && (!empty($this->item->venueslug))) :
					?><a href="<?php echo JRoute::_(JemHelperRoute::getVenueRoute($this->item->venueslug)); ?>"><?php echo $this->item->venue; ?></a><?php
				else/*if ($params->get('event_show_detlinkvenue') == 0)*/ :
					echo $this->escape($this->item->venue);
				endif;

				# will show "venue" or "venue - city" or "venue - city, state" or "venue, state"
				$city  = $this->escape($this->item->city);
				$state = $this->escape($this->item->state);
				if ($city)  { echo ' - ' . $city; }
				if ($state) { echo ', ' . $state; }
				?>
			</dd>
			<?php
			endif;
			$n = is_array($this->categories) ? count($this->categories) : 0;
			?>

			<dt class="col-sm-3 category"><?php echo $n < 2 ? Text::_('COM_JEM_CATEGORY') : Text::_('COM_JEM_CATEGORIES'); ?>:</dt>
			<dd class="col-sm-9 category">
			<?php
			$i = 0;
			foreach ((array)$this->categories as $category) :
				?><a href="<?php echo JRoute::_(JemHelperRoute::getCategoryRoute($category->catslug)); ?>"><?php echo $this->escape($category->catname); ?></a><?php
				$i++;
				if ($i != $n) :
					echo ', ';
				endif;
			endforeach;
			?>
			</dd>

			<?php
			for ($cr = 1; $cr <= 10; $cr++) {
				$currentRow = $this->item->{'custom'.$cr};
				if ($currentRow) {
					$currentRow = '<a href="'.$this->escape($currentRow).'" target="_blank">'.Text::_('TPL_SYO_JEM_EVENT_LINK_TEXT') . Text::_('COM_JEM_EVENT_CUSTOM_FIELD'.$cr).'</a>';
				?>
					<dt class="col-sm-3 custom<?php echo $cr; ?>"><?php echo Text::_('COM_JEM_EVENT_CUSTOM_FIELD'.$cr); ?>:</dt>
					<dd class="col-sm-9 custom<?php echo $cr; ?>"><?php echo $currentRow; ?></dd>
				<?php
				}
			}
			?>
		</dl>

		<!-- DESCRIPTION -->
		<?php if ($params->get('event_show_description','1')) { ?> 
			<h2 class="description"><?php echo Text::_('COM_JEM_EVENT_DESCRIPTION'); ?></h2>
			<?php if ($this->item->fulltext != '' && $this->item->fulltext != '<br />' || $this->item->introtext != '' && $this->item->introtext != '<br />') { ?>
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
							echo Text::_('COM_JEM_EVENT_REGISTER_TO_READ_MORE');
						} elseif ($readmore = $params->get('alternative_readmore')) {
							echo $readmore;
						}

						if ($params->get('event_show_readmore_title', 0) != 0) {
							echo HTMLHelper::_('string.truncate', ($this->item->title), $params->get('event_readmore_limit'));
						} elseif ($params->get('event_show_readmore_title', 0) == 0) {
						} else {
							echo HTMLHelper::_('string.truncate', ($this->item->title), $params->get('event_readmore_limit'));
						} ?>
						</a>
					</p>
				<?php
				}
			} /* access_view / show_noauth */
			?>
			</div>
			<?php } else { ?>
				<p><?php echo Text::_('COM_JEM_EVENT_NO_DETAILS'); ?></p>
			<?php } ?>
		<?php } ?>

		<?php if (!empty($this->item->pluginevent->onEventEnd)) : ?>
			<p></p>
			<?php echo $this->item->pluginevent->onEventEnd; ?>
		<?php endif; ?>
	</div>

	<!--  	Venue  -->
	<div class="col-md-3">
		<?php if (($this->item->locid != 0) && !empty($this->item->venue)) : ?>
		<div class="inner-events" itemprop="location" itemscope="itemscope" itemtype="https://schema.org/Place">
		<meta itemprop="name" content="<?php echo $this->escape($this->item->venue); ?>" />
			<?php $itemid = $this->item ? $this->item->id : 0 ; ?>
			<h2 class="location eventsHeader">
				<?php echo Text::_('COM_JEM_VENUE'); ?>
			</h2>
			<div class="mb-2">
				<?php echo JemOutput::editbutton($this->item, $params, $attribs, $this->permissions->canEditVenue, 'editvenue'); ?>
			</div>

			<?php if ($params->get('event_show_detailsadress', '1')) : ?>
				<?php if ($params->get('event_show_mapserv') == 2 || $params->get('event_show_mapserv') == 5) : ?>
				<div class="jem-map">
					<?php echo JemOutput::mapicon($this->item, 'event', $params); ?>
				</div>
				<?php endif; ?>

				<?php if ($params->get('event_show_mapserv') == 3) : ?>
					<input type="hidden" id="latitude" value="<?php echo $this->item->latitude; ?>">
					<input type="hidden" id="longitude" value="<?php echo $this->item->longitude; ?>">
					<input type="hidden" id="venue" value="<?php echo $this->item->venue; ?>">
					<input type="hidden" id="street" value="<?php echo $this->item->street; ?>">
					<input type="hidden" id="city" value="<?php echo $this->item->city; ?>">
					<input type="hidden" id="state" value="<?php echo $this->item->state; ?>">
					<input type="hidden" id="postalCode" value="<?php echo $this->item->postalCode; ?>">

					<?php echo JemOutput::mapicon($this->item, 'event', $params); ?>
				<?php endif; ?>
			<?php endif; /* event_show_detailsadress */ ?>

			<?php if ($params->get('event_show_locdescription', '1')) { ?> 
				<div class="description location_desc" itemprop="description">
				<?php if ($this->item->locdescription != '' && $this->item->locdescription != '<br />') { ?>
					<?php echo $this->item->locdescription; ?>
				<?php } else { ?>
					<p><?php echo Text::_('COM_JEM_VENUE_NO_DETAILS'); ?></p>
				<?php } ?>
				</div>
			<?php } ?>
			
			<?php
			if (!empty($this->item->venueslug)) :
				echo '<a href="' . JRoute::_(JemHelperRoute::getVenueRoute($this->item->venueslug)) . '">' . JText::sprintf('JGLOBAL_READ_MORE_TITLE', $this->escape($this->item->venue)) . '</a>';
			endif;
			?>
		</div>
		<?php endif; ?>
	</div>
</div>

<?php }
?>
