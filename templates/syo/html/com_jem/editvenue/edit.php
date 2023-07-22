<?php
/**
 * @version 2.0.0
 * @package JEM
 * @copyright (C) 2013-2014 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

//JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

// Create shortcut to parameters.
$params		= $this->item->params;

$options = array(
		'onActive' => 'function(title, description){
        description.setStyle("display", "block");
        title.addClass("open").removeClass("closed");
    }',
		'onBackground' => 'function(title, description){
        description.setStyle("display", "none");
        title.addClass("closed").removeClass("open");
    }',
		'startOffset' => 0,  // 0 starts on the first tab, 1 starts the second, etc...
		'useCookie' => true, // this must not be a string. Don't use quotes.
);

# defining values for centering default-map
$location = JemHelper::defineCenterMap($this->form);
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'venue.cancel' || document.formvalidator.isValid(document.id('venue-form'))) {
			Joomla.submitform(task, document.getElementById('venue-form'));
		}
	}
</script>
<script type="text/javascript">
	window.addEvent('domready', function(){
		setAttribute();
		addrequired();
	});

	function setAttribute(){
		document.getElementById("jform_latitude").setAttribute("geo-data", "lat");
		document.getElementById("jform_longitude").setAttribute("geo-data", "lng");
		document.getElementById("jform_venue").setAttribute("geo-data", "name");
		document.getElementById("jform_map").setAttribute("checked", true);
	}

	function meta(){
		var f = document.getElementById('venue-form');
		if(f.jform_meta_keywords.value != "") f.jform_meta_keywords.value += ", ";
		f.jform_meta_keywords.value += f.jform_venue.value;
	}

	function addrequired(){
		var form = document.getElementById('venue-form');

		$(form.jform_latitude).addClass('required');
		$(form.jform_longitude).addClass('required');

		// FIXME: Not working
		$(form.jform_latitude-lbl).addClass('required');
		$(form.jform_longitude-lbl).addClass('required');
	}
	
	jQuery(function(){
		jQuery("#geocomplete").geocomplete({
			map: ".map_canvas",
			<?php echo $location; ?>
			details: "form ",
			detailsAttribute: "geo-data",
			types: ['establishment', 'geocode'],
			mapOptions: {
				center: {lat: 53.4479389, lng: -1.3954769},
			    zoom: 10
			},
			markerOptions: {
				draggable: true
			}
		});

		jQuery("#geocomplete").bind('geocode:result', function(event, latLng){
			jQuery("#jform_latitude").val(latLng.lat());
			jQuery("#jform_longitude").val(latLng.lng());
		});

		jQuery("#geocomplete").bind("geocode:dragged", function(event, latLng){
			jQuery("#jform_latitude").val(latLng.lat());
			jQuery("#jform_longitude").val(latLng.lng());
		});

	});
	</script>

<div class="<?php echo $this->pageclass_sfx; ?>">
	<div class="edit item-page">
		<?php if ($params->get('show_page_heading')) : ?>
		<h1>
			<?php echo $this->escape($params->get('page_heading')); ?>
		</h1>
		<?php endif; ?>

		<form action="<?php echo JRoute::_('index.php?option=com_jem&a_id='.(int) $this->item->id); ?>" class="form-horizontal form-validate" method="post" name="adminForm" id="venue-form" enctype="multipart/form-data">
			<div class="row event-buttons">
				<div class="offset-2 col-4">
					<button type="button" class="w-100 btn btn-success" onclick="Joomla.submitbutton('venue.save')"><?php echo JText::_('JSAVE') ?></button>
				</div>
				<div class="col-4">
					<button type="button" class="w-100 btn btn-danger" onclick="Joomla.submitbutton('venue.cancel')"><?php echo JText::_('JCANCEL') ?></button>
				</div>
			</div>

			<?php if ($this->params->get('showintrotext')) : ?>
			<div class="description no_space floattext">
				<?php echo $this->params->get('introtext'); ?>
			</div>
			<?php endif; ?>

			<div class="mb-3">
				<?php echo $this->form->getLabel('venue');?>
				<?php echo $this->form->getInput('venue'); ?>
			</div>

			<div class="mb-3">
				<label class="form-label" for="geocomplete">Find venue</label>
				<input class="form-control" id="geocomplete" type="text" size="55" placeholder="<?php echo JText::_( 'COM_JEM_VENUE_ADDRPLACEHOLDER' ); ?>" value="" />
			</div>

			<div class="mb-3">
				<label class="form-label" for="venue-selection-map"><?php echo JText::_('COM_JEM_MAP'); ?></label>
				<div class="map_canvas" id="venue-selection-map" aria-describedby="mapHelpBlock"></div>
				<span id="mapHelpBlock" class="form-text"><?php echo JText::_('TPL_SYO_JEM_VENUE_META_MAP_HELP_TEXT'); ?></span>
			</div>

			<div class="mb-3">
				<?php echo $this->form->getLabel('latitude'); ?>
				<?php echo $this->form->getInput('latitude'); ?>
				<div class="form-text"><?php echo JText::_('TPL_SYO_JEM_VENUE_LATITUDE_HELP_TEXT'); ?></div>
			</div>

			<div class="mb-3">
				<?php echo $this->form->getLabel('longitude'); ?>
				<?php echo $this->form->getInput('longitude'); ?>
				<div class="form-text"><?php echo JText::_('TPL_SYO_JEM_VENUE_LONGITUDE_HELP_TEXT'); ?></div>
			</div>

			<div class="mb-3">
				<?php echo $this->form->getLabel('locdescription'); ?>
				<?php echo $this->form->getInput('locdescription'); ?>
			</div>

			<div class="mb-3">
				<?php echo $this->form->getLabel('published'); ?>
				<?php echo $this->form->getInput('published'); ?>
			</div>

			<div class="mb-3" style="display: none;">
				<?php echo $this->form->getLabel('map'); ?>
				<?php echo $this->form->getInput('map'); ?>
			</div>

			<div class="clearfix"></div>
			<input id="country" name="country" geo-data="country_short" type="hidden" value="">
			<input type="hidden" name="author_ip" value="<?php echo $this->item->author_ip; ?>" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
			<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>
</div>
