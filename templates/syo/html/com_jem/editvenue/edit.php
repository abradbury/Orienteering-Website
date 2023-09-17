<?php
/**
 * @version 4.0.0
 * @package JEM
 * @copyright (C) 2013-2023 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license https://www.gnu.org/licenses/gpl-3.0 GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$app = Factory::getApplication();
$document = $app->getDocument();

$params = $this->item->params;
$settings = JemHelper::globalattribs();
$key = trim($settings->get('global_googleapi', ''));

$wa = $document->getWebAssetManager();
		$wa->useScript('keepalive')
		   ->useScript('form.validate')
		   
		   ->disableScript('jem.jquery')
		   ->disableScript('jem.geocomplete')

		   ->disableScript('jem.jquery_map')
		   ->registerScript('jem.jquery_map', 'https://maps.googleapis.com/maps/api/js?'.(!empty($key) ? 'key='.$key.'&amp;' : '').'libraries=places&language='.$language.'&callback=initMap', [], ['defer' => true], [])
		   ->useScript('jem.jquery_map');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'venue.cancel' || document.formvalidator.isValid(document.getElementById('venue-form'))) {
			Joomla.submitform(task, document.getElementById('venue-form'));
		}
	}
</script>
<script type="text/javascript">
	// https://developers.google.com/maps/documentation/geocoding/overview
	// https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete

	let gMap;
	let marker;
	let autocomplete;

	async function initMap() {
		const latitudeField = document.getElementById("jform_latitude")
		const longitudeField = document.getElementById("jform_longitude")

		const initialCentre = { 
			lat: latitudeField.value ? Number(latitudeField.value) : 53.371838, 
			lng: longitudeField.value ? Number(longitudeField.value) : -1.497833 
		}

		const { Map } = await google.maps.importLibrary("maps");
		const { Autocomplete } = await google.maps.importLibrary("places");
  		const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

		const YORKSHIRE_BOUNDS = new google.maps.LatLngBounds(
			{ lat: 53.00, lng: -2.75 },
			{ lat: 54.00, lng: -0.10 }
		);

		gMap = new Map(document.getElementById("map"), {
			zoom: latitudeField.value ? 13 : 10,
			center: initialCentre,
			mapTypeControl: false,
			mapId: 'ced2ff0bd9cf08f0', // Setup in Google Cloud's Map Platform settings
			streetViewControl: false,
			fullscreenControl: false,
			restriction: {
				latLngBounds: YORKSHIRE_BOUNDS,
				strictBounds: false,
			},
		});

		marker = new AdvancedMarkerElement({
			map: gMap,
			position: initialCentre,
			gmpDraggable: true,
		});

		marker.addListener("drag", (event) => {
			const position = marker.position;
			document.getElementById("jform_latitude").value = parseFloat(position.h).toFixed(5);
			document.getElementById("jform_longitude").value = parseFloat(position.j).toFixed(5);
		});

		autocomplete = new Autocomplete(document.getElementById("geo-search"), {
			fields: ["geometry", "name"],
			componentRestrictions: { country: "gb" },
			strictBounds: true,
			bounds: YORKSHIRE_BOUNDS,
		});

		autocomplete.addListener("place_changed", () => {
			const place = autocomplete.getPlace();

			if (!place.geometry || !place.geometry.location) {
				// User entered the name of a Place that was not suggested and
				// pressed the Enter key, or the Place Details request failed.
				window.alert("No details available for input: '" + place.name + "'");
				return;
			}

			// If the place has a geometry, then present it on a map.
			if (place.geometry.viewport) {
				gMap.fitBounds(place.geometry.viewport);
			} else {
				gMap.setCenter(place.geometry.location);
				gMap.setZoom(17);
			}

			latitudeField.value = parseFloat(place.geometry.location.lat()).toFixed(5);
			longitudeField.value = parseFloat(place.geometry.location.lng()).toFixed(5);

			marker.position = place.geometry.location;
		});
	}

	window.initMap = initMap;

	window.onload = (event) => {
		fixInputFields();
		addInputListeners();
	};

	function fixInputFields() {
		var lat = document.getElementById('jform_latitude');
		var lng = document.getElementById('jform_longitude');

		lat.classList.add('required');
		lng.classList.add('required');

		document.getElementById("jform_map").checked = true;
	}

	function addInputListeners() {
		document.getElementById("jform_latitude").addEventListener("blur", (event) => {
			if (event.target.value) {
				var newPosition = {
					lat: Number(event.target.value),
					lng: marker.position.j
				}
				marker.position = newPosition;
				gMap.panTo(newPosition);
			}
		});

		document.getElementById("jform_longitude").addEventListener("blur", (event) => {
			if (event.target.value) {
				var newPosition = {
					lat: marker.position.h,
					lng: Number(event.target.value)
				};
				marker.position = newPosition;
				gMap.panTo(newPosition);
			}
		});
	}
</script>

<div id="jem" class="jem_editvenue<?php echo $this->pageclass_sfx; ?>">
	<div class="edit item-page">
		<?php if ($params->get('show_page_heading')) : ?>
		<h1>
			<?php echo $this->escape($params->get('page_heading')); ?>
		</h1>
		<?php endif; ?>

		<form action="<?php echo Route::_('index.php?option=com_jem&a_id=' . (int)$this->item->id); ?>" class="form-validate" method="post" name="adminForm" id="venue-form" enctype="multipart/form-data" novalidate>
			<div class="mb-3">
				<button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('venue.save')"><?php echo Text::_('JSAVE') ?></button>
				<button type="button" class="btn btn-secondary" onclick="Joomla.submitbutton('venue.cancel')"><?php echo Text::_('JCANCEL') ?></button>
			</div>

			<?php if ($this->params->get('showintrotext')) : ?>
			<div class="description no_space floattext">
				<?php echo $this->params->get('introtext'); ?>
			</div>
			<?php endif; ?>
			
			
			<div class="adminformlist">
				<div class="mb-3">
					<?php echo $this->form->getLabel('venue'); ?>
					<?php echo $this->form->getInput('venue'); ?>
				</div>

				<div class="mb-3">
					<label class="form-label" for="geo">Find venue</label>
					<input class="form-control" id="geo-search" type="text" placeholder="<?php echo Text::_( 'COM_JEM_VENUE_ADDRPLACEHOLDER' ); ?>" value="" />
				</div>

				<div style="display:none;">
					<?php echo $this->form->getLabel('map'); ?>
					<?php echo $this->form->getInput('map'); ?>
				</div>

				<div class="mb-3">
					<label for="venue-selection-map"><?php echo JText::_('COM_JEM_MAP'); ?></label>
					<div id="map" class="map_canvas" id="venue-selection-map" aria-describedby="mapHelpBlock"></div>
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
			</div>

			<input type="hidden" name="country" id="country" geo-data="country_short" value="">
			<input type="hidden" name="author_ip" value="<?php echo $this->item->author_ip; ?>" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
			<?php echo HTMLHelper::_('form.token'); ?>
		</form>
	</div>
</div>
