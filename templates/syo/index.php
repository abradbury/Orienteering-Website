<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.syo
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app   = Factory::getApplication();
$input = $app->getInput();
$wa    = $this->getWebAssetManager();

// Detecting Active Variables
$option   = $input->getCmd('option', '');
$view     = $input->getCmd('view', '');
$layout   = $input->getCmd('layout', '');
$task     = $input->getCmd('task', '');
$itemid   = $input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

// Get the image used for the banner
$imageNames = array('CSC_2017_LG.jpg', 'P1020182.jpg', 'BOC_2015_RL.jpg', 'BRC_2012_MW.jpg', 'LOXLEY_2016_RB.jpg');
$imageCapts = array(
  'CompassSport Cup Final 2017 - Virtuous Lady, Devon (&copy; Louise Garnett)',
  'World Orienteering Championships 2015 - Nairn, Scotland',
  'British Sprint Orienteering Championships 2015 - Aldershot Garrison, Hampshire (&copy; Robert Lines)',
  'British Relay Championships 2012 - Helsington Barrows, Cumbria (&copy; Martin Ward)',
  'SYO Coaching Session - Loxley Common, Sheffield (&copy; Richard Baxter)'
);
$randIndex  = array_rand($imageNames);

// New meta
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

// Remove Joomla generator text
$this->setMetaData('generator', '');

$wa->useStyle('template.syo')
   ->useScript('template.syo');

// Add favicon stuff
$this->addHeadLink(Uri::base().'apple-touch-icon.png?v=12', 'apple-touch-icon', 'rel', ['sizes' => '180x180']);
$this->addHeadLink(Uri::base().'site.webmanifest?v=12', 'manifest', 'rel', []);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(Uri::base().'favicon.ico?v=12', 'shortcut icon', 'rel', []);
$this->setMetaData('theme-color', '#ffd300');

$this->setMetaData('og:type', 'website', 'property');
$this->setMetaData('og:site_name', $app->get('sitename'), 'property');
$this->setMetaData('og:title', $this->getTitle(), 'property');
$this->setMetaData('og:description', $this->getDescription(), 'property');
$this->setMetaData('og:url', Uri::getInstance()->toString(['scheme', 'host', 'port', 'path', 'query']), 'property');
$this->setMetaData('og:image', Uri::root().'media/templates/site/syo/images/header/CSC_2017_LG.jpg', 'property');
$this->setMetaData('og:image:alt', 'A large group of South Yorkshire Orienteers members, many in the club\'s yellow and black kit, on moorland at the CompassSport Cup Final 2017', 'property');
$this->setMetaData('twitter:card', 'summary_large_image');
?>

<!doctype html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
  </head>

  <body class="site <?php echo $option
      . ' view-' . $view
      . ($layout ? ' layout-' . $layout : ' no-layout')
      . ($task ? ' task-' . $task : ' no-task')
      . ($itemid ? ' itemid-' . $itemid : '')
      . ($pageclass ? ' ' . $pageclass : '')
      . ($this->direction == 'rtl' ? ' rtl' : '');
  ?>">
    <a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>
    <div id="wrap">
      <div class="container">
        <header>
          <div class="row align-items-center">
            <div class="col-5 col-sm-4 col-md-3 col-lg-2 align-self-start align-self-md-center">
              <a href="<?php echo $this->baseurl; ?>">
                <img class="brand-image noCaption" src="<?php echo $this->baseurl.'/media/templates/site/syo/svg/syo_logo_slim_border.svg?v=4';?>"/>
              </a>
            </div>

            <div class="col-7 col-sm-8 col-md-9 col-lg-10">
              <div class="row nav-row-one flex-lg-row-reverse align-items-center">

                <div class="col-xl-4">
                  <ul class='nav so-shall justify-content-end'>
                    <?php $params = $this->params; ?>
                    <?php if ($params->get( 'facebookURL' )) {  ?><li class='nav-item'><a class='nav-link no-external-link-icon fb' target='_blank' rel='noopener noreferrer' href='<?php echo htmlspecialchars($params->get('facebookURL'), ENT_QUOTES, 'UTF-8'); ?>' title="View SYO's Facebook Page"><span class='sr-only'>View S.Y.O's Facebook Page</span><i class="fa-brands fa-facebook"></i></a></li><?php } ?>
                    <?php if ($params->get( 'twitterURL' )) {   ?><li class='nav-item'><a class='nav-link no-external-link-icon tw' target='_blank' rel='noopener noreferrer' href='<?php echo htmlspecialchars($params->get('twitterURL'), ENT_QUOTES, 'UTF-8'); ?>' title="View SYO's X (formally known as Twitter) Feed"><span class='sr-only'>View S.Y.O's X (formally known as Twitter) Feed</span><i class="fa-brands fa-x-twitter"></i></a></li><?php } ?>
                    <?php if ($params->get( 'flickrURL' )) {    ?><li class='nav-item'><a class='nav-link no-external-link-icon fl' target='_blank' rel='noopener noreferrer' href='<?php echo htmlspecialchars($params->get('flickrURL'), ENT_QUOTES, 'UTF-8'); ?>' title="View SYO's Flickr Photo Pool"><span class='sr-only'>View S.Y.O's Flickr Photo Pool</span><i class="fa-brands fa-flickr"></i></a></li><?php } ?>
                    <?php if ($params->get( 'instagramURL' )) { ?><li class='nav-item'><a class='nav-link no-external-link-icon in' target='_blank' rel='noopener noreferrer' href='<?php echo htmlspecialchars($params->get('instagramURL'), ENT_QUOTES, 'UTF-8'); ?>' title="View SYO's Instagram Page"><span class='sr-only'>View S.Y.O's Instagram Page</span><i class="fa-brands fa-instagram"></i></a></li><?php } ?>
                    <?php if ($params->get( 'stravaURL' )) {    ?><li class='nav-item'><a class='nav-link no-external-link-icon st' target='_blank' rel='noopener noreferrer' href='<?php echo htmlspecialchars($params->get('stravaURL'), ENT_QUOTES, 'UTF-8'); ?>' title="View SYO's Strava Page"><span class='sr-only'>View S.Y.O's Strava Page</span><i class="fa-brands fa-strava"></i></a></li><?php } ?>

                    <li class='so-shall-divider'></li>
                    <?php if ($this->countModules( 'logout', true )): ?>
                      <li class='nav-item'><jdoc:include type="modules" name="logout" style="html5" /></li>
                    <?php else: ?>
                      <?php $wa->useScript('bootstrap.modal'); ?>
                      <li class='nav-item'>
                        <a class='nav-link model-login' href='#' role='button' data-bs-toggle="modal" data-bs-target="#login" title='SYO Member Login'>
                          <span class='sr-only'>S.Y.O Member Login</span>
                          <span class='fas fa-user' aria-hidden='true'></span>
                        </a>
                        <?php $user = $app->getIdentity(); if ($user === null || $user->guest) { ?>
                          <jdoc:include type="modules" name="login" style="html5" />
                        <?php } ?>
                      </li>
                    <?php endif; ?>
                  </ul>
                </div>

                <div class="brand-name text-end text-md-start col-xl-8">
                  <h1>South Yorkshire Orienteers</h1>
                </div>
              </div>

              <div class="row nav-row-two">
                <nav class="navbar navbar-expand-lg" aria-label="Main">
                  <div class="container-fluid justify-content-end justify-content-lg-start">
                    <?php $wa->useScript('bootstrap.offcanvas')->useScript('bootstrap.collapse'); ?>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mainMenu" aria-controls="mainMenu">
                      <span class="navbar-toggler-icon" aria-hidden="true"></span>
                      <span>Menu</span>
                    </button>

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="mainMenu" aria-labelledby="mainMenuLabel">
                      <div class="offcanvas-header">
                        <h2 class="offcanvas-title h5" id="mainMenuLabel">Menu</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close menu"></button>
                      </div>
                      <div class="offcanvas-body">
                        <jdoc:include type="modules" name="menu" />
                      </div>
                    </div>
                  </div>
                </nav>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col d-none d-sm-block">
              <div class="banner">
                <img class="noCaption" src="<?php echo $this->baseurl.'/media/templates/site/syo/images/header/'.$imageNames[$randIndex]; ?>?v=2" alt="" fetchpriority="high">
                <small class="caption" data-img-desc="<?php echo $imageCapts[$randIndex]; ?>"></small>
              </div>
            </div>
          </div>

          <?php if ($this->countModules( 'newsflash', true )): ?>
          <div class="row">
            <div class="col">
              <jdoc:include type="modules" name="newsflash" style="html5" />
            </div>
          </div>
          <?php endif; ?>

          <?php if(count($app->getMessageQueue())) { ?>
          <div class="row">
            <div class="col">
              <jdoc:include type="message" />
            </div>
          </div>
          <?php } ?>

          <?php if ($this->countModules( 'breadcrumb', true )): ?>
          <div class="row pt-2">
            <div class="col">
              <jdoc:include type="modules" name="breadcrumb" style="html5" />
            </div>
          </div>
          <?php endif; ?>
        </header>

        <main id="content">
          <div class="row">
            <?php if ($this->countModules( 'events', true )): ?>
            <div class="col-sm">
              <div class="inner-events">
                <jdoc:include type="modules" name="events" style="events" />
              </div>
            </div>
            <?php endif; ?>

            <?php if ($this->countModules( 'results', true )): ?>
            <div class="col-sm">
              <div class="inner-events">
                <jdoc:include type="modules" name="results" style="events" />
              </div>
            </div>
            <?php endif; ?>
          </div>

          <div class="row row-gap-3">
            <?php if ($this->countModules( 'about_left', true )): ?>
            <div class="col-md-4">
              <jdoc:include type="modules" name="about_left" style="html5" />
            </div>
            <div class="col-md-8 news">
              <jdoc:include type="component" />

              <?php if ($this->countModules( 'main_bottom', true )): ?>
              <jdoc:include type="modules" name="main_bottom" style="html5" />
              <?php endif; ?>
            </div>

            <?php elseif ($this->countModules( 'right', true )): ?>
            <div class="col-md-8">
              <jdoc:include type="component" />

              <?php if ($this->countModules( 'main_bottom', true )): ?>
              <jdoc:include type="modules" name="main_bottom" style="html5" />
              <?php endif; ?>
            </div>
            <div class="col-md-4">
              <jdoc:include type="modules" name="right" style="module" />
            </div>

            <?php else : ?>
            <div class="col">
              <jdoc:include type="component" />

              <?php if ($this->countModules( 'main_bottom', true )): ?>
              <jdoc:include type="modules" name="main_bottom" style="html5" />
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </div>
        </main>
      </div>
    </div>

    <footer class="footer">
      <div class="footerImage">
        <img class="img-responsive noCaption" src="<?php echo $this->baseurl.'/media/templates/site/syo/images/SYO_Footer_Silhouette.gif';?>" alt="">
      </div>

      <div class="footerBody">
        <div class="container">
          <?php if (($this->countModules( 'bottom_left', true )) || ($this->countModules( 'bottom_right', true ))): ?>
          <div class="row">
            <div class="col-md">
              <div class="footer-module">
                <h1 class="footerHeader">Sponsors</h1>
                <div class="row footerSponsors">
                  <div id="acl" class="col-sm-10">
                    <a class="mainNavLogo no-external-link-icon" style="filter: grayscale(1);" title="Visit the website of our sponsor, CompassSport" href="https://www.compasssport.co.uk/">
                      <object id="aclo" class="img-responsive footerLogo" type="image/svg+xml" data="<?php echo $this->baseurl; ?>/media/templates/site/syo/svg/compasssport.svg?v=3">
                          Sorry, your browser does not support SVGs, so we can't show you this image.
                      </object>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <?php if ($this->countModules( 'bottom_right', true )): ?>
            <div class="col-md">
              <jdoc:include type="modules" name="bottom_right" style="footer" />
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <hr>

          <div class="row finalFooterRow">
            <div class="col">
              <jdoc:include type="modules" name="footer_left" />
            </div>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>
