<?php

defined('_JEXEC') or die;

if (!isset($this->error)) {
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}

// Get language and direction
$doc             = JFactory::getDocument();
$app             = JFactory::getApplication();
$this->language  = $doc->language;
$this->direction = $doc->direction;
?>

<!doctype html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo $this->error->getCode(); ?> - <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>

	<link rel="stylesheet" href="/templates/syo/css/error.css?v=4">

	<script type="text/javascript">
		var imageNames = [
			"error1",
			"error2",
			"error3",
			"error4",
			"error5"];

		function get_random_404_image() {
			var img = '<img src=\"<?php echo $this->baseurl; ?>/templates/syo/images/errors/';
			var randomIndex = Math.floor(Math.random() * imageNames.length);
			img += imageNames[randomIndex];
			img += '.jpg\" />';
			return img;
		}
	</script>
</head>
<body>
	<div class="container">
		<div class="text">
			<div class="header">
				<h1>Error <?php echo $this->error->getCode(); ?></h1>
				<?php if ($this->error->getcode() == '404') { ?>
				<h2>Page not found</h2>
				<?php } elseif ($this->error->getcode() == '500') { ?>
				<h2>Internal Server Error</h2>
				<?php } elseif ($this->error->getcode() == '401') { ?>
				<h2>Unauthorised</h2>
				<?php } elseif ($this->error->getcode() == '403') { ?>
				<h2>Forbidden</h2>
				<?php } else { ?>
				<h2><?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></h2>
				<?php } ?>
			</div>

			<div class="description">
				<?php if ($this->error->getcode() == '404') { ?>
				<p>Oh dear, it seems our server was unable 
				to find the page you requested.</p>
				<p>Try relocating to our homepage to see if you can find it.</p>

				<?php } elseif ($this->error->getcode() == '500') { ?>
				<p>Oops, it looks like our server got a bit confused 
				when it tried to find the page you requested.</p>
				<p>See if reloading the page or relocating to our homepage helps.</p>

				<?php } elseif ($this->error->getcode() == '401') { ?>
				<p>Hmm... it seems that you are not authorised
				to view the page you requested.</p>
				<p>You may find that logging in from our homepage helps.</p>

				<?php } elseif ($this->error->getcode() == '403') { ?>
				<p>Sorry, but you are not allowed 
				to view the page you requested.</p>
				<p>You may find it useful to relocate to our homepage.</p>

				<?php } else { ?>
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
		<div class="image">
			<?php if ($this->error->getCode() == '404') { ?>
			<script type="text/javascript">
				document.write(get_random_404_image());
			</script>

			<?php } elseif (($this->error->getCode() == '403') || ($this->error->getCode() == '401')) { ?>
			<img src="<?php echo $this->baseurl; ?>/templates/syo/images/errors/error7.jpg" />

			<?php } else { ?>
			<img src="<?php echo $this->baseurl; ?>/templates/syo/images/errors/error6.jpg" />
			<?php } ?>
		</div>
	</div>
</body>
</html>