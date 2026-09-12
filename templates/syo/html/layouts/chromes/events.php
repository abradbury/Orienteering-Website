<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.syo
 */

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

// The "View all" link assumes the module title matches a menu alias, e.g. "Events" -> /events
$linkText = strtolower($displayData['module']->title);

$wrapHeader = true;
$headerLink = '<a class="float-end" href="' . Uri::root(true) . '/' . rawurlencode($linkText) . '">View all '
    . htmlspecialchars($linkText, ENT_QUOTES, 'UTF-8') . '</a>';

require __DIR__ . '/shared.php';
