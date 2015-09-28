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

if (isset($doc->_script) && isset($doc->_script['text/javascript'])) {
  // $doc->_script['text/javascript'] = preg_replace("jQuery\(function\(\$\) {
  //     SqueezeBox\.initialize\({}\);
  //     SqueezeBox\.assign\(\$\('a\.modal'\)\.get\(\), {
  //       parse: 'rel'
  //     }\);
  //   }\);
  //   function jModalClose\(\) {
  //     SqueezeBox\.close\(\);
  //   }", '', $doc->_script['text/javascript']);
  // $doc->_script['text/javascript'] = preg_replace("%\s*jQuery\(function\(\$\)\s*\{\s*if\(SqueezeBox.initialize\)\{\s*SqueezeBox.initialize\(\{\}\);\s*SqueezeBox.assign\(\$\('a.modal'\)\.get\(\),\s*\{\s*parse:\s*'rel'\s*\}\);\s*\}\s*\}\);\s*jQuery\(document\)\.ready\(function\(\)\{\s*jQuery\('\.hasTooltip'\)\.tooltip\(\{\"html\":\s*true,\"container\":\s*\"body\"\}\);\s*\}\);\s*function\s*do_nothing\(\)\s*\{\s*return;\s*\}\s*%", '', $this->_script['text/javascript']);
  // $doc->addScriptDeclaration("window.addEvent\('domready', function\(\) \{\n\n\t\t\tSqueezeBox.initialize\(\{\}\);\n\t\t\tSqueezeBox.assign\(\$\$\('a.modal'\), \{\n\t\t\t\tparse: 'rel'\n\t\t\t\}\);\n\t\t\}\);");
}

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
      <div id="wrap">
        <div class="container">

          <nav class="navbar navbar-default">
            <div class="container-fluid">
              
              <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo $this->baseurl; ?>">
                  <img alt="SYO Logo" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/logo.png">
                  <div>
                    <span class="name-top">South Yorkshire</span>
                    <span class="name-bottom">Orienteers</span>
                  </div>
                </a>

                <ul class="nav social">
                  <?php 
                  $params = $this->params;

                  if ($params->get( 'facebookURL' )) {
                    echo "<li><a class='social-button' href='". $params->get( 'facebookURL' ) ."' title='View SYOs Facebook Page'><span class='fa fa-facebook'></span></a></li>";
                  }
                  if ($params->get( 'twitterURL' )) {
                    echo "<li><a class='social-button' href='". $params->get( 'twitterURL' ) ."' title='View SYOs Twitter Feed'><span class='fa fa-twitter'></span></a></li>";
                  }
                  if ($params->get( 'flickrURL' )) {
                    echo "<li><a class='social-button' href='". $params->get( 'flickrURL' ) ."' title='View SYOs Flickr Photo Pool'><span class='fa fa-flickr'></span></a></li>";
                  }
                  ?>

                  <li><a class="login-button" href="#" title="SYO Member Login" data-toggle="modal" data-target="#login"><span class="fa fa-user"></span></a></li>
                  <li class="login-text"><jdoc:include type="modules" name="logout" style="xhtml" /></li>
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
              <!-- <img style="max-height:250px; max-width:100%" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/banner.jpg"> -->
              <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/P1020182.jpg')"></div>            

           <!--    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="5"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="6"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="7"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="8"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="9"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="10"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="11"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="12"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="13"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="14"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="15"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="16"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="17"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="18"></li>
                </ol>

                <div class="carousel-inner" role="listbox">
                  <div class="item active">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/csc2011.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/P1020182.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/BW_JKD4_2011.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/BW_Hugset_2011.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/MW_Sheffield_2012.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_BM_2015_2.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_BM_2015_3.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_BM_2015.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_BRC_2014_2.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_BRC_2014.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_JKD2_2014.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_JKD3_2015.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_JKD4_2014_2.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_JKD4_2014_3.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_JKD4_2014_4.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_JKD4_2014.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_JKD4_2015_2.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/RL_JKD4_2015.jpg')"></div>
                  </div>
                  <div class="item">
                    <div class="banner" style="background-image:url('<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/header/P1010556.jpg')"></div>
                  </div>
                </div>

                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div> -->

            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <jdoc:include type="modules" name="newsflash" style="xhtml" /> 
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <jdoc:include type="modules" name="breadcrumb" style="xhtml" /> 
            </div>
          </div>

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
            <!-- <div class="col-sm-1"></div> -->
            <div class="col-sm-12">
              <jdoc:include type="component" />
            </div>
            <!-- <div class="col-sm-1"></div> -->

            <?php endif; ?>
          </div>

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
          
        </div>
      </div>

    <!-- Login modal -->
    <?php $user = JFactory::getUser();
    if ($user->guest) { ?>
    <jdoc:include type="modules" name="login" style="xhtml" />
    <?php } ?>

    <!-- Ideally have the img in the footer, but get issues with footer background on different resolutions -->
    <img class="img-responsive footer-image" src="<?php echo $this->baseurl.'/templates/'.$this->template ?>/images/SYO_Footer_Silhouette.svg" alt="">

    <footer class="footer">
      <div class="container">

        <div class="row">
          <div class="col-sm-12">
            Some other fancy stuff
          </div>
        </div>

        <hr>

        <div class="row finalFooterRow">
          <div class="col-sm-12">
            <jdoc:include type="modules" name="footer" />
          </div> <!--.col-sm-12-->
        </div> <!--.row-->
      </div>
    </footer>

    </body>
</html>