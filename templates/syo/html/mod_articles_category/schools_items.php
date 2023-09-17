<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

?>
<?php foreach ($items as $item) : ?>
    <?php $attributes = ['class' => 'list-group-item ' . $item->active]; ?>
    <?php $link = htmlspecialchars($item->link, ENT_COMPAT, 'UTF-8', false); ?>
    <?php $itemTitle = str_replace("Schools League Results", "Year ", $item->title); ?>
    <?php $title = htmlspecialchars($itemTitle, ENT_COMPAT, 'UTF-8', false); ?>
    <?php echo HTMLHelper::_('link', $link, $title, $attributes); ?>
<?php endforeach; ?>
