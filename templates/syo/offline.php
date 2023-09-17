<?php
/**
 * @package     Joomla.Site
 * @subpackage  Template.syo
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */
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
                    <img class="img-fluid text-center" src="/media/templates/site/syo/images/errors/error6.jpg">
                </div>
                <div class="col-md-8">
                    <h1>The SYO site is offline due to unplanned maintenance</h1>
                    <p>Sorry, but our site is down due to an issue. We are working on the problem and hope to have it fixed shortly.</p>

                    <p>In the meantime:</p>
                    <ul>
                        <li>Check out our upcoming events on <a href="https://www.britishorienteering.org.uk/index.php?pg=event&evt_name=&evt_postcode=&radius=10&evt_assoc=&evt_club=28&evt_competitions=0&filter_type=Select...&filter_start=&filter_start_year=&filter_start_month=&filter_start_day=&filter_end=&filter_end_year=&filter_end_month=&filter_end_day=&entry_closing=0&cancelled_events=0&bFilter=Filter">the British Orienteering website</a></li>
                        <li>See results for some of our recent events, also on <a href="https://www.britishorienteering.org.uk/index.php?pg=results&bAdvanced=&evt_name=&evt_postcode=&evt_radius=0&evt_assoc=0&event_club=28&evt_level=0&evt_type=0&event_start=&evt_start_y=&evt_start_m=&evt_start_d=&event_end=&evt_end_y=&evt_end_m=&evt_end_d=&perpage=25&bSearch=Search&pg=results">the British Orienteering website</a></li>
                        <li>Keep up-to-date on club happenings through <a href="https://www.facebook.com/pages/South-Yorkshire-Orienteers/191524707575660">Facebook</a> and <a href="https://twitter.com/SYOrienteers">Twitter</a></li>
                    </ul>

                    <small>Last updated: 09:45 Sunday 17th September 2023</small>
                </div>
            </div>
            <form style="display: none;" action="<?php echo Route::_('index.php', true); ?>" method="post" id="form-login">
                <fieldset class="input">
                    <p id="form-login-username">
                        <label for="username"><?php echo Text::_('JGLOBAL_USERNAME'); ?></label>
                        <input name="username" id="username" type="text" class="inputbox" alt="<?php echo Text::_('JGLOBAL_USERNAME'); ?>" autocomplete="off" autocapitalize="none" />
                    </p>
                    <p id="form-login-password">
                        <label for="passwd"><?php echo Text::_('JGLOBAL_PASSWORD'); ?></label>
                        <input type="password" name="password" class="inputbox" alt="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>" id="passwd" />
                    </p>
                    <p id="submit-button">
                        <button type="submit" name="Submit" class="button login"><?php echo Text::_('JLOGIN'); ?></button>
                    </p>
                    <input type="hidden" name="option" value="com_users" />
                    <input type="hidden" name="task" value="user.login" />
                    <input type="hidden" name="return" value="<?php echo base64_encode(Uri::base()); ?>" />
                    <?php echo HTMLHelper::_('form.token'); ?>
                </fieldset>
            </form>
        </div>
    </body>
</html>
