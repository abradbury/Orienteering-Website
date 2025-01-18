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
  'SYO Coaching Session - Loxely Common, Sheffield (&copy; Richard Baxter)'
);
$randIndex  = array_rand($imageNames);

// New meta
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

// Remove Joomla generator text
$this->setMetaData('generator', '');

// Add CSS
JHtml::_('bootstrap.loadCss', true);
HTMLHelper::stylesheet(Uri::base().'media/templates/site/syo/css/template.min.css?v=501');
HTMLHelper::stylesheet(Uri::base().'media/templates/site/syo/css/fontawesome.min.css?v=660');
HTMLHelper::stylesheet(Uri::base().'media/templates/site/syo/css/brands.min.css?v=660');
HTMLHelper::stylesheet(Uri::base().'media/templates/site/syo/css/solid.min.css?v=660');

// Add favicon stuff
$this->addHeadLink(Uri::base().'apple-touch-icon.png?v=12', 'apple-touch-icon', 'rel', ['sizes' => '180x180']);
$this->addHeadLink(Uri::base().'favicon-32x32.png?v=12', 'icon', 'rel', ['sizes' => '32x32', 'type' => 'image/png']);
$this->addHeadLink(Uri::base().'favicon-16x16.png?v=12', 'icon', 'rel', ['sizes' => '16x16', 'type' => 'image/png']);
$this->addHeadLink(Uri::base().'site.webmanifest?v=12', 'manifest', 'rel', []);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(Uri::base().'safari-pinned-tab.svg?v=12', 'mask-icon', 'rel', ['color' => '#ffd300']);
$this->addHeadLink(Uri::base().'favicon.ico?v=12', 'shortcut icon', 'rel', []);
$this->setMetaData('msapplication-TileColor', 'content="#ffd300">');
$this->setMetaData('msapplication-TileImage', 'content="/mstile-144x144.png?v=12">');
$this->setMetaData('theme-color', 'content="#ffd300">');

// Add open graph details
$this->setMetaData('og:image', Uri::root(false).'templates/'.$this->template.'/images/header/'.$imageNames[$randIndex]);
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
          <?php if ($this->countModules( 'browser_warning', true )): ?>
            <div class="row">
              <!--[if IE ]>
              <div id="browser-warning" class="col">
                <div class="alert alert-danger" role="alert">
                  <jdoc:include type="modules" name="browser_warning" style="html5" />
                </div>
              </div>
              <![endif]-->
            </div>
          <?php endif; ?>

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
                    <?php if ($params->get( 'facebookURL' )) {  ?><li class='nav-item'><a class='nav-link no-external-link-icon fb' target='_blank' href='<?php echo $params->get('facebookURL');  ?>' title="View SYO's Facebook Page"><span class='sr-only'>View S.Y.O's Facebook Page</span><i class="fa-brands fa-facebook"></i></a></li><?php } ?>
                    <?php if ($params->get( 'twitterURL' )) {   ?><li class='nav-item'><a class='nav-link no-external-link-icon tw' target='_blank' href='<?php echo $params->get('twitterURL');   ?>' title="View SYO's X (formally known as Twitter) Feed"><span class='sr-only'>View S.Y.O's X (formally known as Twitter) Feed</span><i class="fa-brands fa-x-twitter"></i></a></li><?php } ?>
                    <?php if ($params->get( 'flickrURL' )) {    ?><li class='nav-item'><a class='nav-link no-external-link-icon fl' target='_blank' href='<?php echo $params->get('flickrURL');    ?>' title="View SYO's Flickr Photo Pool"><span class='sr-only'>View S.Y.O's Flickr Photo Pool</span><i class="fa-brands fa-flickr"></i></a></li><?php } ?>
                    <?php if ($params->get( 'instagramURL' )) { ?><li class='nav-item'><a class='nav-link no-external-link-icon in' target='_blank' href='<?php echo $params->get('instagramURL'); ?>' title="View SYO's Instagram Page"><span class='sr-only'>View S.Y.O's Instagram Page</span><i class="fa-brands fa-instagram"></i></a></li><?php } ?>
                    <?php if ($params->get( 'stravaURL' )) {    ?><li class='nav-item'><a class='nav-link no-external-link-icon st' target='_blank' href='<?php echo $params->get('stravaURL');    ?>' title="View SYO's Strava Page"><span class='sr-only'>View S.Y.O's Strava Page</span><i class="fa-brands fa-strava"></i></a></li><?php } ?>

                    <li class='so-shall-divider'></li>
                    <?php if ($this->countModules( 'logout', true )): ?>
                      <li class='nav-item'><jdoc:include type="modules" name="logout" style="html5" /></li>
                    <?php else: ?>
                      <?php HTMLHelper::_('bootstrap.modal', '.model-login', []); ?>
                      <li class='nav-item'>
                        <a class='nav-link model-login' href='#' role='button' data-bs-toggle="modal" data-bs-target="#login" title='SYO Member Login'>
                          <span class='sr-only'>S.Y.O Member Login</span>
                          <span class='fas fa-user' aria-hidden='true'></span>
                        </a>
                        <?php $user = Factory::getUser(); if ($user->guest) { ?>
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
                <nav class="navbar navbar-expand-md">
                  <div class="container-fluid justify-content-end justify-content-md-start">
                    <?php HTMLHelper::_('bootstrap.collapse', '.navbar-toggler', []); ?>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                      <span>Menu</span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <jdoc:include type="modules" name="menu" />
                    </div>
                  </div>
                </nav>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col d-none d-sm-block">
              <div class="banner" data-img-name="<?php echo $this->baseurl.'/media/templates/site/syo/images/header/'.$imageNames[$randIndex]; ?>">
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
    <script src="<?php echo $this->baseurl; ?>/media/templates/site/syo/js/syo.js?v=4.1"></script>
  </body>
</html>