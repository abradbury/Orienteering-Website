<?php
/**
 * @version 2.0.0
 * @package JEM
 * @subpackage JEM Module
 * @copyright (C) 2013-2014 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

?>

<table class="table">
  <thead>
    <tr>
      <th>Date</th>
      <th>Venue</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($list)): ?>
    <?php foreach ($list as $item) : ?>
    <tr>
      <td>
        <?php if ($params->get('linkdet') == 1) : ?>
        <a href="<?php echo $item->link; ?>"><?php echo $item->dateinfo; ?></a>
        <?php else : echo $item->dateinfo; endif; ?>
      </td>

      <td>
        <?php if ($params->get('showtitloc') == 0 && $params->get('linkloc') == 1) : ?>
        <a href="<?php echo $item->venueurl; ?>"><?php echo $item->text; ?></a>
        <?php elseif ($params->get('showtitloc') == 1 && $params->get('linkdet') == 2) : ?>
        <a href="<?php echo $item->link; ?>"><?php echo $item->text; ?></a>
        <?php else : echo $item->text; endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php else:
    $eventType = "";
    if($params->get('type') == 2) {
      $eventType = "past";
    } elseif ($params->get('type') == 0) {
      $eventType = "future";
    } ?>
    <tr><td colspan="2">No <?php echo $eventType; ?> events found for this category</td></tr>
  <?php endif; ?>
  </tbody>
</table>