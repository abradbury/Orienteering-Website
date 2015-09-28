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

// Define default image size (do not change)
K2HelperUtilities::setDefaultImage($this->item, 'itemlist', $this->params);

?>

<a class="col-sm-3 col-xs-6 contact" href="<?php echo $this->item->link; ?>">
	<div class="contactText">
		<h4 class="contactRole"><?php echo $this->item->title; ?></h4>
	</div>
</a>
