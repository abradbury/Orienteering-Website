<?php
/**
 * @version 4.0.0
 * @package JEM
 * @subpackage JEM Wide Module
 * @copyright (C) 2013-2023 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license https://www.gnu.org/licenses/gpl-3.0 GNU/GPL
 */

defined('_JEXEC') or die;


use Joomla\CMS\Language\Text;
// JHtml::_('behavior.modal', 'a.flyermodal');
?>

<div class="jemmodulewide<?php echo $params->get('moduleclass_sfx')?>" id="jemmodulewide">

	<table class="table eventset" summary="mod_jem_wide">
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
			<?php if (count($list)) : ?>
			<?php foreach ($list as $item) : ?>
			<tr>
				<td valign="top">
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
					<?php
					if ($item->time && $params->get('datemethod', 1) == 1) :
					?>
					<span class="eventTime" title="<?php echo strip_tags($item->dateinfo); ?>"><?php echo $item->time; ?></span>
					<?php endif; ?>
				</td>

				<td>
				<?php if (!empty($item->venue)) : ?>
					<?php if ($item->venuelink) : ?>
					<span class="eventVenue"><a href="<?php echo $item->venuelink; ?>" title="<?php echo $item->venue; ?>"><?php echo $item->venue; ?></a></span>
					<?php else : ?>
					<span class="eventVenue"><?php echo $item->venue; ?></span>
					<?php endif; ?>
				<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php else : ?>
				<tr align="center">
					<td colspan="20"><?php echo JText::_('MOD_JEM_WIDE_NO_EVENTS'); ?></td>
				</tr>
			<?php endif; ?>
		</tobdy>
	</table>
</div>
