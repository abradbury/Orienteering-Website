<?php
/**
 * @package     Joomla.Site
 * @subpackage  Template.system
 *
 * @copyright   (C) 2005 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app = JFactory::getApplication();

// Output as HTML5
$this->setHtml5(true);

$twofactormethods = JAuthenticationHelper::getTwoFactorMethods();
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container">
      <div class="row align-items-center my-4">
        <div class="col-md-4">
          <img class="img-fluid text-center" src="/templates/syo/images/errors/error6.jpg">
        </div>
        <div class="col-md-8">
          <h1>The SYO site is offline due to planned maintenance</h1>
          <p>Sorry, but our site is offline due to planned maintenance - sometimes we need to do bigger pieces of work to keep the site ticking over and this is one of those times. We hope to have it back up and running towards the end of the day.</p>

          <p>In the meantime:</p>
          <ul>
            <li>Check out our upcoming events on <a href="https://www.britishorienteering.org.uk/index.php?pg=event&evt_name=&evt_postcode=&radius=10&evt_assoc=&evt_club=28&evt_competitions=0&filter_type=Select...&filter_start=&filter_start_year=&filter_start_month=&filter_start_day=&filter_end=&filter_end_year=&filter_end_month=&filter_end_day=&entry_closing=0&cancelled_events=0&bFilter=Filter">the British Orienteering website</a></li>
            <li>See results for some of our recent events, also on <a href="https://www.britishorienteering.org.uk/index.php?pg=results&bAdvanced=&evt_name=&evt_postcode=&evt_radius=0&evt_assoc=0&event_club=28&evt_level=0&evt_type=0&event_start=&evt_start_y=&evt_start_m=&evt_start_d=&event_end=&evt_end_y=&evt_end_m=&evt_end_d=&perpage=25&bSearch=Search&pg=results">the British Orienteering website</a></li>
            <li>Keep up-to-date on club happenings through <a href="https://www.facebook.com/pages/South-Yorkshire-Orienteers/191524707575660">Facebook</a> and <a href="https://twitter.com/SYOrienteers">Twitter</a></li>
          </ul>

          <small>Last updated: 09:00 Sunday 16th July 2023</small>
        </div>
      </div>
      <form style="display:none;" action="<?php echo JRoute::_('index.php', true); ?>" method="post" id="form-login">
        <fieldset class="input">
            <p id="form-login-username">
                <label for="username"><?php echo JText::_('JGLOBAL_USERNAME'); ?></label>
                <input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" autocomplete="off" autocapitalize="none" />
            </p>
            <p id="form-login-password">
                <label for="passwd"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
                <input type="password" name="password" class="inputbox" alt="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" id="passwd" />
            </p>
            <?php if (count($twofactormethods) > 1) : ?>
                <p id="form-login-secretkey">
                    <label for="secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?></label>
                    <input type="text" name="secretkey" autocomplete="one-time-code" class="inputbox" alt="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>" id="secretkey" />
                </p>
            <?php endif; ?>
            <p id="submit-buton">
                <input type="submit" name="Submit" class="button login" value="<?php echo JText::_('JLOGIN'); ?>" />
            </p>
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="user.login" />
            <input type="hidden" name="return" value="<?php echo base64_encode(JUri::base()); ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </fieldset>
      </form>
    </div>
  </body>
</html>
