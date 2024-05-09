<?php
/**
 * @version 4.0.0
 * @package JEM
 * @copyright (C) 2013-2023 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license https://www.gnu.org/licenses/gpl-3.0 GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

// JHtml::_('behavior.tooltip');
?>

<script type="text/javascript">
	function tableOrdering(order, dir, view)
	{
		var form = document.getElementById("adminForm");

		form.filter_order.value     = order;
		form.filter_order_Dir.value = dir;
		form.submit(view);
	}
</script>

<?php 
$hasManyEvents = (count($this->rows) > 15); // Hack so filter does not show on What's On page
$hasFilterApplied = !empty($this->lists['search']);
?>

<?php if (($hasFilterApplied || $hasManyEvents) && ($this->settings->get('global_show_filter',1) || $this->settings->get('global_display',1))) : ?>
<form id="jem_filter" class="floattext">
  <div class="row">
	<?php if ($this->settings->get('global_show_filter',1)) : ?>
		<div class="col-1 col-xl-1"><label class="col-form-label" for="filter"><?php echo Text::_('COM_JEM_FILTER'); ?></label></div>
		<div class="col-2 col-xl-2"><?php echo $this->lists['filter']; ?></div>
		<div class="col-5 col-xl-4"><input type="text" name="filter_search" id="filter_search" value="<?php echo $this->lists['search'];?>" class="form-control" onchange="document.adminForm.submit();" /></div>
		<div class="col-2 col-xl-1"><button class="btn btn-primary w-100" type="submit"><?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?></button></div>
		<div class="col-2 col-xl-1"><button class="btn btn-secondary w-100" type="button" onclick="document.getElementById('filter_search').value='';this.form.submit();"><?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?></button></div>
	<?php endif; ?>

	<?php if ($this->settings->get('global_display',1)) : ?>
		<div class="col-1 col-xl-1 offset-xl-1 text-xl-end"><label class="col-form-label" for="limit"><?php echo Text::_('COM_JEM_DISPLAY_NUM'); ?></label></div>
		<div class="col-2 col-xl-1 text-xl-end"><?php echo $this->pagination->getLimitBox(); ?></div>
	<?php endif; ?>
  </div>
</form>
<?php endif; ?>

<div class="table-responsive">
	<table class="eventtable table table-bordered" style="width:<?php echo $this->jemsettings->tablewidth; ?>;" summary="jem">
		<colgroup>
			<?php if ($this->jemsettings->showeventimage == 1) : ?>
			<col width="<?php echo $this->jemsettings->tableeventimagewidth; ?>" class="jem_col_event_image" />
			<?php endif; ?>
			<col width="<?php echo $this->jemsettings->datewidth; ?>" class="jem_col_date" />
			<?php if ($this->jemsettings->showtitle == 1) : ?>
			<col width="<?php echo $this->jemsettings->titlewidth; ?>" class="jem_col_title" />
			<?php endif; ?>
			<?php if ($this->jemsettings->showlocate == 1) : ?>
			<col width="<?php echo $this->jemsettings->locationwidth; ?>" class="jem_col_venue" />
			<?php endif; ?>
			<?php if ($this->jemsettings->showcity == 1) : ?>
			<col width="<?php echo $this->jemsettings->citywidth; ?>" class="jem_col_city" />
			<?php endif; ?>
			<?php if ($this->jemsettings->showstate == 1) : ?>
			<col width="<?php echo $this->jemsettings->statewidth; ?>" class="jem_col_state" />
			<?php endif; ?>
			<?php if ($this->jemsettings->showcat == 1) : ?>
			<col width="<?php echo $this->jemsettings->catfrowidth; ?>" class="jem_col_category" />
			<?php endif; ?>
			<?php if ($this->jemsettings->showatte == 1) : ?>
			<col width="<?php echo $this->jemsettings->attewidth; ?>" class="jem_col_attendees" />
			<?php endif; ?>
		</colgroup>

		<thead>		
			<tr>
				<?php if ($this->jemsettings->showeventimage == 1) : ?>
				<th id="jem_eventimage" class="sectiontableheader" align="left"><?php echo Text::_('COM_JEM_TABLE_EVENTIMAGE'); ?></th>
				<?php endif; ?>
				<th id="jem_date" class="sectiontableheader" align="left"><?php if ($hasManyEvents) { echo JHtml::_('grid.sort', 'COM_JEM_TABLE_DATE', 'a.dates', $this->lists['order_Dir'], $this->lists['order']); } else { echo Text::_('COM_JEM_TABLE_DATE'); } ?></th>
				<?php if ($this->jemsettings->showtitle == 1) : ?>
				<th id="jem_title" class="sectiontableheader" align="left"><?php if ($hasManyEvents) { echo JHtml::_('grid.sort', 'COM_JEM_TABLE_TITLE', 'a.title', $this->lists['order_Dir'], $this->lists['order']); } else { echo Text::_('COM_JEM_TABLE_TITLE'); } ?></th>
				<?php endif; ?>
				<?php if ($this->jemsettings->showlocate == 1) : ?>
				<th id="jem_location" class="sectiontableheader" align="left"><?php if ($hasManyEvents) { echo JHtml::_('grid.sort', 'COM_JEM_TABLE_LOCATION', 'l.venue', $this->lists['order_Dir'], $this->lists['order']); } else { echo Text::_('COM_JEM_TABLE_LOCATION'); } ?></th>
				<?php endif; ?>
				<?php if ($this->jemsettings->showcity == 1) : ?>
				<th id="jem_city" class="sectiontableheader" align="left"><?php if ($hasManyEvents) { echo JHtml::_('grid.sort', 'COM_JEM_TABLE_CITY', 'l.city', $this->lists['order_Dir'], $this->lists['order']); } else { echo Text::_('COM_JEM_TABLE_CITY'); } ?></th>
				<?php endif; ?>
				<?php if ($this->jemsettings->showstate == 1) : ?>
				<th id="jem_state" class="sectiontableheader" align="left"><?php if ($hasManyEvents) { echo JHtml::_('grid.sort', 'COM_JEM_TABLE_STATE', 'l.state', $this->lists['order_Dir'], $this->lists['order']); } else { echo Text::_('COM_JEM_TABLE_STATE'); } ?></th>
				<?php endif; ?>
				<?php if ($this->jemsettings->showcat == 1) : ?>
				<th id="jem_category" class="sectiontableheader" align="left"><?php if ($hasManyEvents) { echo JHtml::_('grid.sort', 'COM_JEM_TABLE_CATEGORY', 'c.catname', $this->lists['order_Dir'], $this->lists['order']); } else { echo Text::_('COM_JEM_TABLE_CATEGORY'); } ?></th>
				<?php endif; ?>
				<?php if ($this->jemsettings->showatte == 1) : ?>
				<th id="jem_attendees" class="sectiontableheader" align="center"><?php echo Text::_('COM_JEM_TABLE_ATTENDEES'); ?></th>
				<?php endif; ?>
			</tr>
		</thead>

		<tbody>
			<?php if (empty($this->rows)) : ?>
				<tr class="no_events"><td colspan="20"><?php echo Text::_('COM_JEM_NO_EVENTS'); ?></td></tr>
			<?php else : ?>
				<?php $odd = 0; ?>
				<?php foreach ($this->rows as $row) : ?>
					<?php $odd = 1 - $odd; ?>
					<?php if (!empty($row->featured)) : ?>
					<tr class="featured featured<?php echo $row->id.$this->params->get('pageclass_sfx'); ?>" itemscope="itemscope" itemtype="https://schema.org/Event">
					<?php else : ?>
					<tr class="sectiontableentry<?php echo ($odd + 1) . $this->params->get('pageclass_sfx'); ?>" itemscope="itemscope" itemtype="https://schema.org/Event">
					<?php endif; ?>

						<?php if ($this->jemsettings->showeventimage == 1) : ?>
						<td headers="jem_eventimage" align="left" valign="top">
							<?php if (!empty($row->datimage)) : ?>
								<?php
								$dimage = JemImage::flyercreator($row->datimage, 'event');
								echo JemOutput::flyer($row, $dimage, 'event');
								?>
							<?php endif; ?>
						</td>
						<?php endif; ?>

						<td headers="jem_date" align="left">
							<?php
							echo JemOutput::formatLongDateTime($row->dates, $row->times, $row->enddates, $row->endtimes, $this->jemsettings->showtime);
							echo JemOutput::formatSchemaOrgDateTime($row->dates, $row->times, $row->enddates, $row->endtimes);
							?>
						</td>

						<?php if (($this->jemsettings->showtitle == 1) && ($this->jemsettings->showdetails == 1)) : ?>
						<td headers="jem_title" align="left" valign="top">
							<a href="<?php echo JRoute::_(JemHelperRoute::getEventRoute($row->slug)); ?>" itemprop="url">
								<span itemprop="name"><?php echo $this->escape($row->title) . JemOutput::recurrenceicon($row); ?></span>
							</a><?php echo JemOutput::publishstateicon($row); ?>
						</td>
						<?php endif; ?>

						<?php if (($this->jemsettings->showtitle == 1) && ($this->jemsettings->showdetails == 0)) : ?>
						<td headers="jem_title" align="left" valign="top" itemprop="name">
							<?php echo $this->escape($row->title) . JemOutput::recurrenceicon($row) . JemOutput::publishstateicon($row); ?>
						</td>
						<?php endif; ?>

						<?php if ($this->jemsettings->showlocate == 1) : ?>
						<td headers="jem_location" align="left" valign="top">
							<?php
							if (!empty($row->venue)) :
								if (($this->jemsettings->showlinkvenue == 1) && !empty($row->venueslug)) :
									echo "<a href='".JRoute::_(JemHelperRoute::getVenueRoute($row->venueslug))."'>".$this->escape($row->venue)."</a>";
								else :
									echo $this->escape($row->venue);
								endif;
							else :
								echo '-';
							endif;
							?>
						</td>
						<?php endif; ?>

						<?php if ($this->jemsettings->showcity == 1) : ?>
						<td headers="jem_city" align="left" valign="top">
							<?php echo !empty($row->city) ? $this->escape($row->city) : '-'; ?>
						</td>
						<?php endif; ?>

						<?php if ($this->jemsettings->showstate == 1) : ?>
						<td headers="jem_state" align="left" valign="top">
							<?php echo !empty($row->state) ? $this->escape($row->state) : '-'; ?>
						</td>
						<?php endif; ?>

						<?php if ($this->jemsettings->showcat == 1) : ?>
						<td headers="jem_category" align="left" valign="top">
							<?php echo implode(", ", JemOutput::getCategoryList($row->categories, $this->jemsettings->catlinklist)); ?>
						</td>
						<?php endif; ?>

						<?php if ($this->jemsettings->showatte == 1) : ?>
						<td headers="jem_attendees" align="left" valign="top">
							<?php
							if (!empty($row->regCount)) : 
								echo $this->escape($row->regCount), " / ", $this->escape($row->maxplaces);
							else : 
								echo "- / ", $this->escape ($row->maxplaces);
							endif;
								?>																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																										   
							</td>	
							<?php endif; ?>	
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>
