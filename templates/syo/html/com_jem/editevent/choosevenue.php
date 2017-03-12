<?php
/**
 * @version 2.1.0
 * @package JEM
 * @copyright (C) 2013-2014 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

$function = JFactory::getApplication()->input->getCmd('function', 'jSelectVenue');

// For some reason none of the usual CCS gets included in modal windows
$doc = JFactory::getDocument();

$doc->addStyleSheet($this->baseurl.'/templates/syo/css/bootstrap.min.css');
$doc->addStyleSheet($this->baseurl.'/templates/syo/css/template.css');
?>

<script type="text/javascript">
	function tableOrdering( order, dir, view )
	{
		var form = document.getElementById("adminForm");

		form.filter_order.value 	= order;
		form.filter_order_Dir.value	= dir;
		form.submit( view );
	}
</script>

<div id="jem" class="jem_select_venue">
	<h1>
		<?php echo JText::_('COM_JEM_SELECT_VENUE'); ?>
	</h1>

	<form class="form-inline" action="<?php echo JRoute::_('index.php?option=com_jem&view=editevent&layout=choosevenue&tmpl=component&function='.$this->escape($function).'&'.JSession::getFormToken().'=1'); ?>" method="post" name="adminForm" id="adminForm">
		<div id="jem_filter" class="floattext">
			<div class="pull-left">
				<?php
				echo '<label class="control-label" for="filter_type">'.JText::_('COM_JEM_FILTER').'</label>&nbsp;';
				echo $this->searchfilter.'&nbsp;';
				?>
				<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->filter;?>" class="form-control" onchange="document.adminForm.submit();" />
				<button type="submit" class="btn btn-primary"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
				<button type="button" class="btn btn-default" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
				<button type="button" class="btn btn-default" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('', '<?php echo JText::_('COM_JEM_SELECT_VENUE') ?>');"><?php echo JText::_('COM_JEM_NOVENUE')?></button>
			</div>
			<div class="pull-right">
				<?php
				echo '<label class="control-label" for="limit">'.JText::_('COM_JEM_DISPLAY_NUM').'</label>&nbsp;';
				echo $this->pagination->getLimitBox();
				?>
			</div>
		</div>

		<table class="table table-hover" summary="jem">
			<thead>
				<tr>
					<th width="7" class="sectiontableheader" align="left"><?php echo JText::_('COM_JEM_NUM'); ?></th>
					<th align="left" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_VENUE', 'l.venue', $this->lists['order_Dir'], $this->lists['order'], 'selectvenue' ); ?></th>
					<th align="left" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_CITY', 'l.city', $this->lists['order_Dir'], $this->lists['order'], 'selectvenue' ); ?></th>
					<th align="left" class="sectiontableheader" align="left"><?php echo JHtml::_('grid.sort', 'COM_JEM_STATE', 'l.state', $this->lists['order_Dir'], $this->lists['order']); ?></th>
					<th align="left" class="sectiontableheader" align="left"><?php echo JText::_('COM_JEM_COUNTRY'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($this->rows)) : ?>
					<tr align="center"><td colspan="0"><?php echo JText::_('COM_JEM_NOVENUES'); ?></td></tr>
				<?php else :?>
					<?php foreach ($this->rows as $i => $row) : ?>
					<tr class="row<?php echo $i % 2; ?>">
						<td><?php echo $this->pagination->getRowOffset( $i ); ?></td>
						<td align="left">
							<a class="pointer" onclick="if (window.parent) window.parent.<?php echo $this->escape($function);?>('<?php echo $row->id; ?>', '<?php echo $this->escape(addslashes($row->venue)); ?>');"><?php echo $this->escape($row->venue); ?></a>
						</td>
						<td align="left"><?php echo $this->escape($row->city); ?></td>
						<td align="left"><?php echo $this->escape($row->state); ?></td>
						<td align="left"><?php echo $this->escape($row->country); ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>

		<p>
		<input type="hidden" name="task" value="selectvenue" />
		<input type="hidden" name="option" value="com_jem" />
		<input type="hidden" name="tmpl" value="component" />
		<input type="hidden" name="function" value="<?php echo $this->escape($function); ?>" />
		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
		</p>
	</form>

	<div class="pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
</div>
