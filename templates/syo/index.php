<?php 

defined('_JEXEC') or die('Restricted access');

// Variables
$doc = JFactory::getDocument();
$user = JFactory::getUser();
$template = 'templates/' . $this->template;

// Get menu alias for different banners
$app = JFactory::getApplication();
$menu = $app->getMenu()->getActive();
$menuAlias = '';

if (is_object($menu)) {
  $menuAlias = $menu->alias;
}

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
$doc->addStyleSheet('https://fonts.googleapis.com/css?family=Source+Sans+Pro%7COxygen:700');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/bootstrap.min.css');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/template.css?v=24');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/font-awesome.min.css');

// Add favicon stuff
$doc->addCustomTag('<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png?v=rMMm7jX0jo">');
$doc->addCustomTag('<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png?v=rMMm7jX0jo">');
$doc->addCustomTag('<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png?v=rMMm7jX0jo">');
$doc->addCustomTag('<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png?v=rMMm7jX0jo">');
$doc->addCustomTag('<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png?v=rMMm7jX0jo">');
$doc->addCustomTag('<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png?v=rMMm7jX0jo">');
$doc->addCustomTag('<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png?v=rMMm7jX0jo">');
$doc->addCustomTag('<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png?v=rMMm7jX0jo">');
$doc->addCustomTag('<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png?v=rMMm7jX0jo">');
$doc->addCustomTag('<link rel="icon" type="image/png" href="/favicon-32x32.png?v=rMMm7jX0jo" sizes="32x32">');
$doc->addCustomTag('<link rel="icon" type="image/png" href="/favicon-194x194.png?v=rMMm7jX0jo" sizes="194x194">');
$doc->addCustomTag('<link rel="icon" type="image/png" href="/favicon-96x96.png?v=rMMm7jX0jo" sizes="96x96">');
$doc->addCustomTag('<link rel="icon" type="image/png" href="/android-chrome-192x192.png?v=rMMm7jX0jo" sizes="192x192">');
$doc->addCustomTag('<link rel="icon" type="image/png" href="/favicon-16x16.png?v=rMMm7jX0jo" sizes="16x16">');
$doc->addCustomTag('<link rel="manifest" href="/manifest.json?v=rMMm7jX0jo">');
$doc->addCustomTag('<link rel="mask-icon" href="/safari-pinned-tab.svg?v=rMMm7jX0jo" color="#5bbad5">');
$doc->addCustomTag('<link rel="shortcut icon" href="/favicon.ico?v=rMMm7jX0jo">');
$doc->setMetadata('msapplication-TileColor', '#2b5797');
$doc->setMetadata('msapplication-TileImage', '/mstile-144x144.png?v=rMMm7jX0jo');
$doc->setMetadata('theme-color', '#ffd65e');

// Add JS
$doc->addScript($this->baseurl.'/templates/'.$this->template.'/js/bootstrap.min.js');

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
          <div id="navWrapper">
             <nav id="socialNav">
              <ul class="nav social">
                <?php 
                $params = $this->params;

                if ($params->get( 'facebookURL' )) {
                  echo "<li><a class='no-external-link-icon' target='_blank' href='". $params->get( 'facebookURL' ) ."' title='View SYOs Facebook Page'><span class='sr-only'>View S.Y.Os Facebook Page</span><span class='fa my-fa-facebook' aria-hidden='true'></span></a></li>\n                  ";
                }
                if ($params->get( 'twitterURL' )) {
                  echo "<li><a class='no-external-link-icon' target='_blank' href='". $params->get( 'twitterURL' ) ."' title='View SYOs Twitter Feed'><span class='sr-only'>View S.Y.Os Twitter Feed</span><span class='fa my-fa-twitter' aria-hidden='true'></span></a></li>\n                  ";
                }
                if ($params->get( 'flickrURL' )) {
                  echo "<li><a class='no-external-link-icon' target='_blank' href='". $params->get( 'flickrURL' ) ."' title='View SYOs Flickr Photo Pool'><span class='sr-only'>View S.Y.Os Flickr Photo Pool</span><span class='fa my-fa-flickr' aria-hidden='true'></span></a></li>\n";
                }
                if ($this->countModules( 'logout' )): ?>
                <li><span id="login-btn" class="fa fa-user" aria-hidden="true"></span></li>
                <li><jdoc:include type="modules" name="logout" style="xhtml" /></li>
                <?php else: ?>
                <li><a id="login-btn" href="#" title="SYO Member Login" data-toggle="modal" data-target="#login"><span class="sr-only">S.Y.O Member Login</span><span class="fa fa-user" aria-hidden="true"></span></a></li>
                <?php endif; ?>
              </ul>
            </nav>

            <nav class="row" id="mainNav">
              <div class="col-xs-12 col-sm-6 col-md-4">
                <a id="mainNavLogo" href="<?php echo $this->baseurl; ?>">
                  <object type="image/svg+xml" data="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/syo_logo_and_text_crop.svg">
                    Your browser does not support SVGs
                  </object>
                </a>
              </div>

              <div class="col-xs-12 col-sm-6 col-md-8">
                <jdoc:include type="modules" name="menu" />
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
            </div>

            <?php elseif ($this->countModules( 'right' )): ?>
            <div class="col-sm-7 col-md-8">
              <jdoc:include type="component" />
            </div>
            <div class="col-sm-5 col-md-4">
              <jdoc:include type="modules" name="right" style="module" /> 
            </div>       

            <?php else : ?>
            <div class="col-sm-12">
              <jdoc:include type="component" />
            </div>

            <?php endif; ?>
          </div>

          <?php if (($this->countModules( 'bottom_left' )) || ($this->countModules( 'bottom_middle' )) || ($this->countModules( 'bottom_right' ))): ?>
          <div class="row">
            <?php if ($this->countModules( 'bottom_left' )): ?>
            <div class="col-sm-4">
              <jdoc:include type="modules" name="bottom_left" style="xhtml" /> 
            </div>
            <?php endif; ?>

            <?php if ($this->countModules( 'bottom_middle' )): ?>
            <div class="col-sm-4">
              <jdoc:include type="modules" name="bottom_middle" style="xhtml" /> 
            </div>
            <?php endif; ?>

            <?php if ($this->countModules( 'bottom_right' )): ?>
            <div class="col-sm-4">
              <jdoc:include type="modules" name="bottom_right" style="xhtml" /> 
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>
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
          <div class="row">
            <div class="col-sm-6">
              <h3 class="footerHeader">Sponsors</h3>
              <div class="row">
                <div class="col-xs-6">
                  <a class="no-external-link-icon" href="http://www.accelerateuk.com/"><img class="img-responsive noCaption" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/accelerate.gif" alt="Accelerate Logo"></a>
                </div>
                <div class="col-xs-6">
                  <a class="no-external-link-icon" href="http://www.smartwool.com/"><img class="img-responsive noCaption" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/smartwool.gif" alt="Smartwool Logo"></a>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <jdoc:include type="modules" name="sitemap" style="footer" />
            </div>
          </div>

          <hr>

          <div class="row finalFooterRow">
            <div class="col-sm-12">
              <jdoc:include type="modules" name="footer" />
            </div>
          </div>
        </div>
      </div>
    </footer>
    <script src="<?php echo ($this->baseurl.'/templates/'.$this->template); ?>/js/syo.js"></script>
  </body>
</html>