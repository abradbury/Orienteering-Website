<?php 
	function modChrome_events($module, &$params, &$attribs) {
		echo "<div class='inner-events'>";

		if (null !== $params->get('header_tag')) {
			$headerTag = $params->get('header_tag');
		} else {
			$headerTag = 'h3';
		}

		if ($module->showtitle) {
			echo "<div class='eventsHeader'>";
			echo '<'.$headerTag.'>' .$module->title .'</'.$headerTag.'>';
			echo "<a class='pull-right' href='/". strtolower($module->title) ."'>View all ". strtolower($module->title) ."</a>";
			echo "</div>";
		}

		echo $module->content;
		echo "</div>";
	}

	function modChrome_module($module, &$params, &$attribs) {
		echo "<div class='inner-events syo-module' id='". str_replace(' ', '_', strtolower($module->title)) . "'>";

		if (null !== $params->get('header_tag')) {
			$headerTag = $params->get('header_tag');
		} else {
			$headerTag = 'h3';
		}

		if ($module->showtitle) {
			echo "<div class='eventsHeader'>";
			echo '<'.$headerTag.'>' .$module->title .'</'.$headerTag.'>';
			echo "</div>";
		}

		echo $module->content;
		echo "</div>";
	}

	function modChrome_footer($module, &$params, &$attribs) {
		echo "<div class='footer-module'>";

		if (null !== $params->get('header_tag')) {
			$headerTag = $params->get('header_tag');
		} else {
			$headerTag = 'h3';
		}

		if ($module->showtitle) {
			echo '<'.$headerTag.' class="footerHeader">' .$module->title .'</'.$headerTag.'>';
		}

		echo $module->content;
		echo "</div>";
	}
?>
