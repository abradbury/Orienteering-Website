<?php 

defined('_JEXEC') or die('Restricted access');

// Variables
$doc = JFactory::getDocument();
$user = JFactory::getUser();
$template = 'templates/' . $this->template;

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
$doc->addStyleSheet('http://fonts.googleapis.com/css?family=Source+Sans+Pro%7COxygen:700');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/bootstrap.min.css');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/template.css');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/font-awesome.min.css');

// Add JS
$doc->addScript($this->baseurl.'/templates/'.$this->template.'/js/bootstrap.min.js');
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
          <nav class="navbar navbar-default">
            <div class="container-fluid">
              <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo $this->baseurl; ?>">
                  <img alt="South Yorkshire Orienteers Logo" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/logo.png">
                  <div>
                    <span class="name-top">South Yorkshire</span>
                    <span class="name-bottom">Orienteers</span>
                  </div>
                </a>

                <ul class="nav social">
                  <?php 
                  $params = $this->params;

                  if ($params->get( 'facebookURL' )) {
                    echo "<li><a class='no-external-link-icon' href='". $params->get( 'facebookURL' ) ."' title='View SYOs Facebook Page'><span class='sr-only'>View S.Y.Os Facebook Page</span><span class='fa fa-facebook' aria-hidden='true'></span></a></li>\n                  ";
                  }
                  if ($params->get( 'twitterURL' )) {
                    echo "<li><a class='no-external-link-icon' href='". $params->get( 'twitterURL' ) ."' title='View SYOs Twitter Feed'><span class='sr-only'>View S.Y.Os Twitter Feed</span><span class='fa fa-twitter' aria-hidden='true'></span></a></li>\n                  ";
                  }
                  if ($params->get( 'flickrURL' )) {
                    echo "<li><a class='no-external-link-icon' href='". $params->get( 'flickrURL' ) ."' title='View SYOs Flickr Photo Pool'><span class='sr-only'>View S.Y.Os Flickr Photo Pool</span><span class='fa fa-flickr' aria-hidden='true'></span></a></li>\n";
                  }
                  if ($this->countModules( 'logout' )): ?>
                  <li><span id="login-btn" class="fa fa-user" aria-hidden="true"></span></li>
                  <li><jdoc:include type="modules" name="logout" style="xhtml" /></li>
                  <?php else: ?>
                  <li><a id="login-btn" href="#" title="SYO Member Login" data-toggle="modal" data-target="#login"><span class="sr-only">S.Y.O Member Login</span><span class="fa fa-user" aria-hidden="true"></span></a></li>
                  <?php endif; ?>
                </ul>

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </div>

              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <jdoc:include type="modules" name="menu" />
              </div> <!-- /.navbar-collapse -->
            </div> <!-- /.container-fluid -->
          </nav>

          <div class="row">
            <div class="col-sm-12 hidden-xs" id="carousel-top">
              <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/P1020182.jpg')"></div>
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
            <div class="col-sm-6 events">
              <div class="inner-events">
                <jdoc:include type="modules" name="events" style="events" /> 
              </div>
            </div>
            <?php endif; ?>

            <?php if ($this->countModules( 'results' )): ?>
            <div class="col-sm-6 events">
              <div class="inner-events">
                <jdoc:include type="modules" name="results" style="events" /> 
              </div>
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
            
            <?php elseif ($this->countModules( 'map_right' )): ?>
            <div class="col-sm-7">
              <jdoc:include type="component" />
            </div>
            <div class="col-sm-5">
              <jdoc:include type="modules" name="map_right" style="xhtml" /> 
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
    <!-- Login modal -->
    <jdoc:include type="modules" name="login" style="xhtml" />
    <?php } ?>
    
    <footer class="footer container-fluid">
      
      <div class="footerImage">
        <img class="img-responsive" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/SYO_Footer_Silhouette.svg" alt="">
      </div>

      <div class="footerBody">
        <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <h3>Sponsors</h3>
              <div class="row">
                <div class="col-xs-6">
                  <a class="no-external-link-icon" href="http://www.accelerateuk.com/"><img class="img-responsive" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/accelerate.png" alt="Accelerate Logo"></a>
                </div>
                <div class="col-xs-6">
                  <a class="no-external-link-icon" href="http://www.smartwool.com/"><img class="img-responsive" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/smartwool.png" alt="Smartwool Logo"></a>
                </div>
              </div>
            </div>
            <!-- <div class="col-sm-6">
              <h3>Other</h3>
            </div> -->
          </div>

          <hr>

          <div class="row finalFooterRow">
            <div class="col-sm-12">
              <jdoc:include type="modules" name="footer" />
            </div>
          </div>
        </div>
      </div>

     <!--  <div class="container">

        <img class="img-responsive footer-image" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/SYO_Footer_Silhouette.svg" alt="">

        
      </div> -->
    </footer>

  </body>
</html>