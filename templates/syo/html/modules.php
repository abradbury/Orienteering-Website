<?php 
  function modChrome_events( $module, &$params, &$attribs ) 
  {
    if ($module->showtitle) 
	  {
	  	echo "<div class='eventsHeader'>";
	    echo '<h3>' .$module->title .'</h3>';

    	echo "<a class='pull-right' href='/". strtolower($module->title) ."'>View all ". strtolower($module->title) ."</a>"; 

	    echo "</div>";
	    echo $module->content;
	  }
  }
?>