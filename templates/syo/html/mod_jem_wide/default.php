<?php
/**
 * @version 2.1.4
 * @package JEM
 * @subpackage JEM Wide Module
 * @copyright (C) 2013-2015 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

JHtml::_('behavior.modal', 'a.flyermodal');
?>

<div>
  <table class="table">
    <colgroup>
      <col class="jemmodw_col_title" />
      <col class="jemmodw_col_category" />
      <col class="jemmodw_col_venue" />
    </colgroup>
    <thead>
      <tr>
         <th>Event</th>
         <th>Date</th>
         <th>Venue</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $item) : ?>
    <tr>
      <td>
        <?php if ($item->eventlink) : ?>
        <span class="eventTitle">
          <a href="<?php echo $item->eventlink; ?>" title="<?php echo $item->fulltitle; ?>"><?php echo $item->title; ?></a>
        </span>
        <?php else : ?>
        <span class="eventTitle">
          <?php echo $item->title; ?>
        </span>
        <?php endif; ?>
      </td>
      <td>
        <span class="eventDate" title="<?php echo strip_tags($item->dateinfo); ?>"><?php echo $item->date; ?></span>
        <?php if ($item->time && $params->get('datemethod', 1) == 1) : ?>
        <span class="eventTime" title="<?php echo strip_tags($item->dateinfo); ?>">(<?php echo $item->time; ?>)</span>
        <?php endif; ?>
      </td>
      <td>
      <?php if ($item->venue) : ?>
        <?php if ($item->venuelink) : ?>
        <span class="eventVenue"><a href="<?php echo $item->venuelink; ?>" title="<?php echo $item->fullvenue; ?>"><?php echo $item->venue; ?></a></span>
        <?php else : ?>
        <span class="eventVenue"><?php echo $item->venue; ?></span>
        <?php endif; ?>
      <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>