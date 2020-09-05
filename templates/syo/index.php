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
$doc->setMetadata('X-UA-Compatible', 'IE=edge');
$doc->setMetadata('viewport', 'width=device-width, initial-scale=1.0');

// Remove Joomla generator text
$doc->setGenerator('');

// Add CSS
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/bootstrap.min.css?v=337');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/template.min.css?v=450');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/fontawesome.min.css?v=5130');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/brands.min.css?v=5130');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/solid.min.css?v=5130');

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
$doc->addScript($this->baseurl.'/templates/'.$this->template.'/js/bootstrap.min.js?v=337');

// HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
$doc->addCustomTag('<!--[if lt IE 9]><script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script><script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->');
?>

<!DOCTYPE html>
<html xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
  <head>
    <jdoc:include type="head" />
  </head>

  <body>
    <a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>
    <div id="wrap">
      <div class="container">
        <header>
          <!--[if lt IE 11]>
          <?php if ($this->countModules( 'browser_warning' )): ?>
            <div class="row">
              <div class="col-sm-12 browser-warning">
                <jdoc:include type="modules" name="browser_warning" style="xhtml" /> 
              </div>
            </div>
          <?php endif; ?>
          <![endif]-->

          <div id="navWrapper">
            <nav class="navbar navbar-default">
              <div class="container-fluid">
                <div class="navbar-header">
                  <div class="header-grid1">
                    <a class="header-cell1 mainNavLogo" href="<?php echo $this->baseurl; ?>">
                      <object type="image/svg+xml" data="<?php echo $this->baseurl.'/templates/'.$this->template ?>/svg/syo_logo_and_text_crop.svg?v=4">
                        Your browser does not support SVGs
                      </object>
                    </a>

                    <div class="header-cell2">
                      <button type="button" class="navbar-toggle collapsed header-cell3-button" data-toggle="collapse" data-target="#nav-collapse-mob" aria-expanded="false">
                        <span>Menu</span>
                      </button>

                      <div class="collapse navbar-collapse header-cell3-menu" id="nav-collapse">
                          <jdoc:include type="modules" name="menu" />
                      </div>

                      <ul class="nav social header-cell4">
                        <?php $params = $this->params; ?>
                        <?php if ($params->get( 'facebookURL' )) { ?><li><a class='no-external-link-icon' target='_blank' href='<?php echo $params->get('facebookURL'); ?>' title="View SYO's Facebook Page"><span class='sr-only'>View S.Y.O's Facebook Page</span><span class='fab my-fa-facebook' aria-hidden='true'></span></a></li><?php } ?>
                        <?php if ($params->get( 'twitterURL' )) {  ?><li><a class='no-external-link-icon' target='_blank' href='<?php echo $params->get('twitterURL');  ?>' title="View SYO's Twitter Feed"><span class='sr-only'>View S.Y.O's Twitter Feed</span><span class='fab my-fa-twitter' aria-hidden='true'></span></a></li><?php } ?>
                        <?php if ($params->get( 'flickrURL' )) {   ?><li><a class='no-external-link-icon' target='_blank' href='<?php echo $params->get('flickrURL');   ?>' title="View SYO's Flickr Photo Pool"><span class='sr-only'>View S.Y.O's Flickr Photo Pool</span><span class='fab my-fa-flickr' aria-hidden='true'></span></a></li><?php } ?>
                        <?php if ($params->get( 'instagramURL' )) {   ?><li><a class='no-external-link-icon' target='_blank' href='<?php echo $params->get('instagramURL');   ?>' title="View SYO's Instagram Page"><span class='sr-only'>View S.Y.O's Instagram Page</span><span class='fab my-fa-instagram' aria-hidden='true'></span></a></li><?php } ?>
                        <?php if ($params->get( 'stravaURL' )) {   ?><li><a class='no-external-link-icon' target='_blank' href='<?php echo $params->get('stravaURL');   ?>' title="View SYO's Strava Page"><span class='sr-only'>View S.Y.O's Strava Page</span><span class='fab my-fa-strava' aria-hidden='true'></span></a></li><?php } ?>

                        <?php if ($this->countModules( 'logout' )): ?>
                        <li><span id="login-btn" class="fas fa-user" aria-hidden="true"></span></li>
                        <li><jdoc:include type="modules" name="logout" style="xhtml" /></li>
                        <?php else: ?>
                        <li><a id="login-btn" href="#" title="SYO Member Login" data-toggle="modal" data-target="#login"><span class="sr-only">S.Y.O Member Login</span><span class="fas fa-user" aria-hidden="true"></span></a></li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </div>
                  <div class="collapse navbar-collapse header-cell3-menu" id="nav-collapse-mob">
                      <jdoc:include type="modules" name="menu" />
                  </div>
                </div>
              </div>
            </nav>
          </div>

          <div class="row">
            <div class="col-sm-12 hidden-xs">
              <div class="banner" id="<?php echo $menuAlias; ?>" data-img-name="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/header/'.$imageNames[$randIndex]; ?>">
                <small class="caption" data-img-desc="<?php echo $imageCapts[$randIndex]; ?>"></small>
              </div>
            </div>
          </div>

          <?php if ($this->countModules( 'newsflash' )): ?>
          <div class="row">
            <div class="col-sm-12">
              <jdoc:include type="modules" name="newsflash" style="xhtml" /> 
            </div>
          </div>
          <?php endif; ?>

          <?php $app = JFactory::getApplication();
          if(count($app->getMessageQueue())) { ?>
          <div class="row">
            <div class="col-sm-12">
              <jdoc:include type="message" />
            </div>
          </div>
          <?php } ?>

          <?php if ($this->countModules( 'breadcrumb' )): ?>
          <div class="row">
            <div class="col-sm-12">
              <jdoc:include type="modules" name="breadcrumb" style="xhtml" /> 
            </div>
          </div>
          <?php endif; ?>
        </header>

        <main id="content">
          <div class="row">
            <?php if ($this->countModules( 'events' )): ?>
            <div class="col-sm-6">
              <jdoc:include type="modules" name="events" style="events" /> 
            </div>
            <?php endif; ?>

            <?php if ($this->countModules( 'results' )): ?>
            <div class="col-sm-6">
              <jdoc:include type="modules" name="results" style="events" /> 
            </div>
            <?php endif; ?>
          </div>

          <div class="row">
            <?php if ($this->countModules( 'about_left' )): ?>
            <div class="col-sm-4">
              <jdoc:include type="modules" name="about_left" style="xhtml" /> 
            </div>
            <div class="col-sm-8 news">
              <jdoc:include type="component" />

              <?php if ($this->countModules( 'main_bottom' )): ?>
              <jdoc:include type="modules" name="main_bottom" style="xhtml" /> 
              <?php endif; ?>
            </div>

            <?php elseif ($this->countModules( 'right' )): ?>
            <div class="col-sm-7 col-md-8">
              <jdoc:include type="component" />

              <?php if ($this->countModules( 'main_bottom' )): ?>
              <jdoc:include type="modules" name="main_bottom" style="xhtml" /> 
              <?php endif; ?>
            </div>
            <div class="col-sm-5 col-md-4">
              <jdoc:include type="modules" name="right" style="module" /> 
            </div>       

            <?php else : ?>
            <div class="col-sm-12">
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

    <?php $user = JFactory::getUser();
    if ($user->guest) { ?>
    <jdoc:include type="modules" name="login" style="xhtml" />
    <?php } ?>
    
    <footer class="footer container-fluid">
      
      <div class="footerImage">
        <img class="img-responsive noCaption" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/SYO_Footer_Silhouette.gif" alt="">
      </div>

      <div class="footerBody">
        <div class="container">

          <?php if (($this->countModules( 'bottom_left' )) || ($this->countModules( 'bottom_right' ))): ?>
          <div class="row">
            <?php if ($this->countModules( 'bottom_left' )): ?>
            <div class="col-sm-6">
              <jdoc:include type="modules" name="bottom_left" style="footer" /> 
            </div>
            <?php endif; ?>

            <?php if ($this->countModules( 'bottom_right' )): ?>
            <div class="col-sm-6">
              <jdoc:include type="modules" name="bottom_right" style="footer" /> 
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <hr>

          <div class="row finalFooterRow">
            <div class="col-sm-6">
              <jdoc:include type="modules" name="footer_left" />
            </div>
            <div class="col-sm-6">
              <jdoc:include type="modules" name="footer_right" />
            </div>
          </div>
        </div>
      </div>
    </footer>
    <script src="<?php echo ($this->baseurl.'/templates/'.$this->template); ?>/js/syo.js?v=4.1"></script>
  </body>
</html>