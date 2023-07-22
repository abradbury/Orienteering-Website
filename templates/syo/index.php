<?php 

defined('_JEXEC') or die('Restricted access');

// Variables
$doc = JFactory::getDocument();
$doc->setHtml5(true);
$user = JFactory::getUser();
$template = 'templates/' . $this->template;

// Get menu alias for different banners
$app = JFactory::getApplication();
$menu = $app->getMenu()->getActive();
$menuAlias = '';

if (is_object($menu)) {
  $menuAlias = $menu->alias;
}

// Get the image used for the banner
$imageNames = array('CSC_2017_LG.jpg', 'P1020182.jpg', 'BOC_2015_RL.jpg', 'BRC_2012_MW.jpg', 'LOXLEY_2016_RB.jpg');
$imageCapts = array('CompassSport Cup Final 2017 - Virtuous Lady, Devon (&copy; Louise Garnett)', 'World Orienteering Championships 2015 - Nairn, Scotland', 'British Sprint Orienteering Championships 2015 - Aldershot Garrison, Hampshire (&copy; Robert Lines)', 'British Relay Championships 2012 - Helsington Barrows, Cumbria (&copy; Martin Ward)', 'SYO Coaching Session - Loxely Common, Sheffield (&copy; Richard Baxter)');
$randIndex  = array_rand($imageNames);

// Remove deprecated meta-data (HTML5)
$head = $doc->getHeadData();
unset($head['metaTags']['http-equiv']);
$doc->setHeadData($head);

// The 'jQuery Easy' plugin removes most scripts, where possible

// New meta
$doc->setMetadata('charset', 'utf-8');
$doc->setMetadata('viewport', 'width=device-width, initial-scale=1');

// Remove Joomla generator text
$doc->setGenerator('');

// Add CSS
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/bootstrap.min.css?v=530');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/template.min.css?v=501');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/fontawesome.min.css?v=640');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/brands.min.css?v=640');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/solid.min.css?v=640');

// Add favicon stuff
$doc->addCustomTag('<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=sa5YTVdDS">');
$doc->addCustomTag('<link rel="icon" type="image/png" href="/favicon-32x32.png?v=sa5YTVdDS" sizes="32x32">');
$doc->addCustomTag('<link rel="icon" type="image/png" href="/favicon-16x16.png?v=sa5YTVdDS" sizes="16x16">');
$doc->addCustomTag('<link rel="manifest" href="/site.webmanifest">');
$doc->addCustomTag('<link rel="mask-icon" href="/safari-pinned-tab.svg?v=sa5YTVdDS" color="#5bbad5">');
$doc->setMetadata('application-name', 'content="SYO">');
$doc->setMetadata('msapplication-TileColor', 'content="#ffc40d">');
$doc->setMetadata('msapplication-TileImage', 'content="/mstile-144x144.png?v=sa5YTVdDS">');
$doc->setMetadata('theme-color', 'content="#ffffff">');
$doc->setMetadata("apple-mobile-web-app-title", "content='SYO'>");

// Add open graph details
$doc->setMetadata('og:image', JURI::base().'templates/'.$this->template.'/images/header/'.$imageNames[$randIndex]);

// Add JS
$doc->addScript($this->baseurl.'/templates/'.$this->template.'/js/bootstrap.bundle.min.js?v=530');
?>

<!doctype html>
<html lang="<?php echo $this->language; ?>">
  <head>
    <jdoc:include type="head" />
  </head>

  <body>
    <a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>
    <div id="wrap">
      <div class="container">
        <header>
          <?php if ($this->countModules( 'browser_warning' )): ?>
            <div class="row">
              <!--[if IE ]>
              <div id="browser-warning" class="col">
                <div class="alert alert-danger" role="alert">
                  <jdoc:include type="modules" name="browser_warning" style="xhtml" /> 
                </div>
              </div>
              <![endif]-->
            </div>
          <?php endif; ?>

          <div class="row align-items-center">
            <div class="col-5 col-sm-4 col-md-3 col-lg-2 align-self-start align-self-md-center">
              <a href="<?php echo $this->baseurl; ?>">
                <img class="brand-image noCaption" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/svg/syo_logo_slim_border.svg?v=4"/>
              </a>
            </div>

            <div class="col-7 col-sm-8 col-md-9 col-lg-10">
              <div class="row nav-row-one flex-lg-row-reverse align-items-center">
               
                <div class="col-xl-4">
                  <ul class='nav so-shall justify-content-end'>
                    <?php $params = $this->params; ?>
                    <?php if ($params->get( 'facebookURL' )) {  ?><li class='nav-item'><a class='nav-link no-external-link-icon fb' target='_blank' href='<?php echo $params->get('facebookURL');  ?>' title="View SYO's Facebook Page"><span class='sr-only'>View S.Y.O's Facebook Page</span><i class="fa-brands fa-facebook"></i></a></li><?php } ?>
                    <?php if ($params->get( 'twitterURL' )) {   ?><li class='nav-item'><a class='nav-link no-external-link-icon tw' target='_blank' href='<?php echo $params->get('twitterURL');   ?>' title="View SYO's Twitter Feed"><span class='sr-only'>View S.Y.O's Twitter Feed</span><i class="fa-brands fa-twitter"></i></a></li><?php } ?>
                    <?php if ($params->get( 'flickrURL' )) {    ?><li class='nav-item'><a class='nav-link no-external-link-icon fl' target='_blank' href='<?php echo $params->get('flickrURL');    ?>' title="View SYO's Flickr Photo Pool"><span class='sr-only'>View S.Y.O's Flickr Photo Pool</span><i class="fa-brands fa-flickr"></i></a></li><?php } ?>
                    <?php if ($params->get( 'instagramURL' )) { ?><li class='nav-item'><a class='nav-link no-external-link-icon in' target='_blank' href='<?php echo $params->get('instagramURL'); ?>' title="View SYO's Instagram Page"><span class='sr-only'>View S.Y.O's Instagram Page</span><i class="fa-brands fa-instagram"></i></a></li><?php } ?>
                    <?php if ($params->get( 'stravaURL' )) {    ?><li class='nav-item'><a class='nav-link no-external-link-icon st' target='_blank' href='<?php echo $params->get('stravaURL');    ?>' title="View SYO's Strava Page"><span class='sr-only'>View S.Y.O's Strava Page</span><i class="fa-brands fa-strava"></i></a></li><?php } ?>

                    <li class='so-shall-divider'></li>
                    <?php if ($this->countModules( 'logout' )): ?>
                      <li class='nav-item'><jdoc:include type="modules" name="logout" style="xhtml" /></li>
                    <?php else: ?>
                      <li class='nav-item'>
                        <a class='nav-link' href='#' role='button' data-bs-toggle="modal" data-bs-target="#login" title='SYO Member Login'>
                          <span class='sr-only'>S.Y.O Member Login</span>  
                          <span class='fas fa-user' aria-hidden='true'></span>
                        </a>
                        <?php $user = JFactory::getUser(); if ($user->guest) { ?>
                          <jdoc:include type="modules" name="login" style="xhtml" />
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
              <div class="banner" id="<?php echo $menuAlias; ?>" data-img-name="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/header/'.$imageNames[$randIndex]; ?>">
                <small class="caption" data-img-desc="<?php echo $imageCapts[$randIndex]; ?>"></small>
              </div>
            </div>
          </div>

          <?php if ($this->countModules( 'newsflash' )): ?>
          <div class="row">
            <div class="col">
              <jdoc:include type="modules" name="newsflash" style="xhtml" /> 
            </div>
          </div>
          <?php endif; ?>

          <?php $app = JFactory::getApplication();
          if(count($app->getMessageQueue())) { ?>
          <div class="row">
            <div class="col">
              <jdoc:include type="message" />
            </div>
          </div>
          <?php } ?>

          <?php if ($this->countModules( 'breadcrumb' )): ?>
          <div class="row pt-2">
            <div class="col">
              <jdoc:include type="modules" name="breadcrumb" style="xhtml" /> 
            </div>
          </div>
          <?php endif; ?>
        </header>

        <main id="content">
          <div class="row">
            <?php if ($this->countModules( 'events' )): ?>
            <div class="col-sm">
              <jdoc:include type="modules" name="events" style="events" /> 
            </div>
            <?php endif; ?>

            <?php if ($this->countModules( 'results' )): ?>
            <div class="col-sm">
              <jdoc:include type="modules" name="results" style="events" /> 
            </div>
            <?php endif; ?>
          </div>

          <div class="row row-gap-3">
            <?php if ($this->countModules( 'about_left' )): ?>
            <div class="col-md-4">
              <jdoc:include type="modules" name="about_left" style="xhtml" /> 
            </div>
            <div class="col-md-8 news">
              <jdoc:include type="component" />

              <?php if ($this->countModules( 'main_bottom' )): ?>
              <jdoc:include type="modules" name="main_bottom" style="xhtml" /> 
              <?php endif; ?>
            </div>

            <?php elseif ($this->countModules( 'right' )): ?>
            <div class="col-md-8">
              <jdoc:include type="component" />

              <?php if ($this->countModules( 'main_bottom' )): ?>
              <jdoc:include type="modules" name="main_bottom" style="xhtml" /> 
              <?php endif; ?>
            </div>
            <div class="col-md-4">
              <jdoc:include type="modules" name="right" style="module" /> 
            </div>       

            <?php else : ?>
            <div class="col">
              <jdoc:include type="component" />

              <?php if ($this->countModules( 'main_bottom' )): ?>
              <jdoc:include type="modules" name="main_bottom" style="xhtml" /> 
              <?php endif; ?>
            </div>
            <?php endif; ?>
          </div>
        </main>
      </div>
    </div>

    <footer class="footer">
      <div class="footerImage">
        <img class="img-responsive noCaption" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/SYO_Footer_Silhouette.gif" alt="">
      </div>

      <div class="footerBody">
        <div class="container">
          <?php if (($this->countModules( 'bottom_left' )) || ($this->countModules( 'bottom_right' ))): ?>
          <div class="row">
            <div class="col-md">
              <div class="footer-module">
                <h1 class="footerHeader">Sponsors</h1>
                <div class="row footerSponsors">
                  <div id="acl" class="col-sm-10">
                    <a class="mainNavLogo no-external-link-icon" title="Visit the website of our sponsor, CompassSport" href="http://www.compasssport.co.uk/">
                      <object id="aclo" class="img-responsive footerLogo" type="image/svg+xml" data="<?php echo JURI::root()?>/templates/syo/svg/compasssport.svg?v=3">
                          Sorry, your browser does not support SVGs, so we can't show you this image.
                      </object>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <?php if ($this->countModules( 'bottom_right' )): ?>
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
    <script src="<?php echo ($this->baseurl.'/templates/'.$this->template); ?>/js/syo.js?v=4.1"></script>
  </body>
</html>