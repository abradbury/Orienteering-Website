<?php
/**
 * @package     Joomla.Site
 * @subpackage  Template.system
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if (!isset($this->error))
{
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}

// Get language and direction
$doc             = JFactory::getDocument();
$app             = JFactory::getApplication();
$this->language  = $doc->language;
$this->direction = $doc->direction;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $this->error->getCode(); ?> - <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
	
	<link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl.'/templates/'.$this->template.'/css/error.css'?>" type="text/css" />

	<?php if ($app->get('debug_lang', '0') == '1' || $app->get('debug', '0') == '1') : ?>
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/media/cms/css/debug.css" type="text/css" />
	<?php endif; ?>

	<script type="text/javascript">
		var imageNames = [
			"error1",
			"error2",
			"error3",
			"error4",
			"error5"];
		function getImgTag()
		{
			var img = '<img src=\"<?php echo $this->baseurl; ?>/images/errors/';
			var randomIndex = Math.floor(Math.random() * imageNames.length);
			img += imageNames[randomIndex];
			img += '.jpg\" height=\"600px\" width=\"600px\"/>';
			return img;
		}
	</script>
</head>
<body>
	<div class="parent">
		<div class="image">
			<?php if ($this->error->getCode() == '404') { ?>
			<script type="text/javascript">
				document.write(getImgTag());
			</script>

			<?php } elseif (($this->error->getCode() == '403') || ($this->error->getCode() == '401')) { ?>
			<img src="<?php echo $this->baseurl; ?>/images/errors/error7.jpg" height="600px" width="720px"/>

			<?php } else { ?>
			<img src="<?php echo $this->baseurl; ?>/images/errors/error6.jpg" height="600px" width="720px"/>
			<?php } ?>
		</div>

		<div class="text">
			<h1>Error <?php echo $this->error->getCode(); ?></h1>

			<?php if ($this->error->getcode() == '404') { ?>
			<h2>Page not found</h2>
			<p>Oh dear, it seems our server was unable 
			to find the page you requested.</p>
			<p>Try relocating to our homepage to see if you can find it.</p>

			<?php } elseif ($this->error->getcode() == '500') { ?>
			<h2>Internal Server Error</h2>
			<p>Oops, it looks like our server got a bit confused 
			when it tried to find the page you requested.</p>
			<p>See if reloading the page or relocating to our homepage helps.</p>

			<?php } elseif ($this->error->getcode() == '401') { ?>
			<h2>Unauthorised</h2>
			<p>Hmm... it seems that you are not authorised
			to view the page you requested.</p>
			<p>You may find that logging in from our homepage helps.</p>

			<?php } elseif ($this->error->getcode() == '403') { ?>
			<h2>Forbidden</h2>
			<p>Sorry, but you are not allowed 
			to view the page you requested.</p>
			<p>You may find it useful to relocate to our homepage.</p>

			<?php } else { ?>
			<h2><?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></h2>
			<p>We are sorry, but there seems to have  
			been a problem retrieving the page you requested.</p>
			<p>You may find it useful to relocate to our homepage.</p>
			<?php } ?>

			<p><a href="<?php echo JURI::base(); ?>"><?php echo JURI::base(); ?></a></p>

			<?php if ($this->debug) : ?>
				<p><?php echo $this->renderBacktrace(); ?></p>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>
