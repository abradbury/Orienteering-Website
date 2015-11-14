<?php 
	function modChrome_events($module, &$params, &$attribs) 
	{
		echo "<div class='inner-events'>";

		if ($module->showtitle) 
		{
			echo "<div class='eventsHeader'>";
			echo '<h3>' .$module->title .'</h3>';
			echo "<a class='pull-right' href='/". strtolower($module->title) ."'>View all ". strtolower($module->title) ."</a>";
			echo "</div>";
		}

		echo $module->content;
		echo "</div>";
	}

	function modChrome_module($module, &$params, &$attribs) 
	{
		echo "<div class='inner-events syo-module' id='". str_replace(' ', '_', strtolower($module->title)) . "'>";

		if ($module->showtitle) 
		{
			echo "<div class='eventsHeader'>";
			echo '<h3>' .$module->title .'</h3>';
			echo "</div>";
		}

		echo $module->content;
		echo "</div>";
	}
?>