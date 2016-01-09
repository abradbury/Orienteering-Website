<?php
/**
 * @version 2.1.4
 * @package JEM
 * @copyright (C) 2013-2015 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die; ?>

	

	<!-- IMAGE -->
	<fieldset class="jem_fldst_image">
	<legend><?php echo JText::_('COM_JEM_IMAGE'); ?></legend>
		<?php
		if ($this->item->datimage) :
			echo JEMOutput::flyer($this->item, $this->dimage, 'event', 'datimage');
		endif;
		?>
		<div class="form-group">
			<label for="userfile" class="col-sm-2 col-xs-12 control-label">
				<?php echo JText::_('COM_JEM_IMAGE'); ?>
			</label>
			<div class="col-sm-6 col-xs-9">
				<input class="inputbox <?php echo $this->jemsettings->imageenabled == 2 ? 'required' : ''; ?> form-control" name="userfile" id="userfile" type="file" aria-describedby="pictureHelp" />
			</div>
			<div class="col-sm-2 col-xs-3">
				<button type="button" class="btn btn-default btn-block" onclick="document.getElementById('userfile').value = ''"><?php echo JText::_('JSEARCH_FILTER_CLEAR') ?></button>
				<?php
				if ($this->item->datimage) :
					echo JHtml::image('media/com_jem/images/publish_r.png', null, array('id' => 'userfile-remove', 'data-id' => $this->item->id, 'data-type' => 'events', 'title' => JText::_('COM_JEM_REMOVE_IMAGE')));
				endif;
				?>
			</div>
			<div class="col-sm-2 col-xs-12">
				<span id="pictureHelp" class="help-block"><?php echo JText::_('COM_JEM_MAX_IMAGE_FILE_SIZE').' '.$this->jemsettings->sizelimit.' kb'?></span>
			</div>
		</div>
		<input type="hidden" name="removeimage" id="removeimage" value="0" />
	</fieldset>

	<!-- Recurrence -->
	<fieldset class="panelform">
	<legend><?php echo JText::_('COM_JEM_RECURRENCE'); ?></legend>
		<div class="form-group">
			<div class="col-sm-2 cantAccessLabel">
				<?php echo $this->form->getLabel('recurrence_type'); ?>
			</div>
			<div class="col-sm-4">
				<?php echo $this->form->getInput('recurrence_type'); ?>
			</div>

			<div class="col-sm-2" id="recurrence_output">
				<label></label>
			</div>
			<div id="counter_row" style="display: none;">
				<?php echo $this->form->getLabel('recurrence_limit_date'); ?> <?php echo $this->form->getInput('recurrence_limit_date'); ?>
			</div>
		</div>
		<input type="hidden" name="recurrence_number" id="recurrence_number" value="<?php echo $this->item->recurrence_number;?>" />
		<input type="hidden" name="recurrence_byday" id="recurrence_byday" value="<?php echo $this->item->recurrence_byday;?>" />

		<script type="text/javascript">
		<!--
		var $select_output = new Array();
			$select_output[1] = "<?php
			echo JText::_('COM_JEM_OUTPUT_DAY');
			?>";
			$select_output[2] = "<?php
			echo JText::_('COM_JEM_OUTPUT_WEEK');
			?>";
			$select_output[3] = "<?php
			echo JText::_('COM_JEM_OUTPUT_MONTH');
			?>";
			$select_output[4] = "<?php
			echo JText::_('COM_JEM_OUTPUT_WEEKDAY');
			?>";

		var $weekday = new Array();
			$weekday[0] = new Array("MO", "<?php echo JText::_('COM_JEM_MONDAY'); ?>");
			$weekday[1] = new Array("TU", "<?php echo JText::_('COM_JEM_TUESDAY'); ?>");
			$weekday[2] = new Array("WE", "<?php echo JText::_('COM_JEM_WEDNESDAY'); ?>");
			$weekday[3] = new Array("TH", "<?php echo JText::_('COM_JEM_THURSDAY'); ?>");
			$weekday[4] = new Array("FR", "<?php echo JText::_('COM_JEM_FRIDAY'); ?>");
			$weekday[5] = new Array("SA", "<?php echo JText::_('COM_JEM_SATURDAY'); ?>");
			$weekday[6] = new Array("SU", "<?php echo JText::_('COM_JEM_SUNDAY'); ?>");

		var $before_last = "<?php
			echo JText::_('COM_JEM_BEFORE_LAST');
			?>";
		var $last = "<?php
			echo JText::_('COM_JEM_LAST');
			?>";
			start_recurrencescript("jform_recurrence_type");
		-->
		</script>

		<?php /* show "old" recurrence settings for information */
		if (!empty($this->item->recurr_bak->recurrence_type)) {
			$recurr_type = '';
			$recurr_limit_date = str_ireplace('0000-00-00', JText::_('COM_JEM_UNLIMITED'),
			                                  $this->item->recurr_bak->recurrence_limit_date);

			switch ($this->item->recurr_bak->recurrence_type) {
			case 1:
				$recurr_type = JText::_('COM_JEM_DAYLY');
				$recurr_info = str_ireplace('[placeholder]',
				                            $this->item->recurr_bak->recurrence_number,
				                            JText::_('COM_JEM_OUTPUT_DAY'));
				break;
			case 2:
				$recurr_type = JText::_('COM_JEM_WEEKLY');
				$recurr_info = str_ireplace('[placeholder]',
				                            $this->item->recurr_bak->recurrence_number,
				                            JText::_('COM_JEM_OUTPUT_WEEK'));
				break;
			case 3:
				$recurr_type = JText::_('COM_JEM_MONTHLY');
				$recurr_info = str_ireplace('[placeholder]',
				                            $this->item->recurr_bak->recurrence_number,
				                            JText::_('COM_JEM_OUTPUT_MONTH'));
				break;
			case 4:
				$recurr_type = JText::_('COM_JEM_WEEKDAY');
				$recurr_byday = preg_replace('/(,)([^ ,]+)/', '$1 $2', $this->item->recurr_bak->recurrence_byday);
				$recurr_days = str_ireplace(array('MO', 'TU', 'WE', 'TH', 'FR', 'SA', 'SO'),
				                            array(JText::_('COM_JEM_MONDAY'), JText::_('COM_JEM_TUESDAY'),
				                                  JText::_('COM_JEM_WEDNESDAY'), JText::_('COM_JEM_THURSDAY'),
				                                  JText::_('COM_JEM_FRIDAY'), JText::_('COM_JEM_SATURDAY'),
				                                  JText::_('COM_JEM_SUNDAY')),
				                            $recurr_byday);
				$recurr_num  = str_ireplace(array('5', '6'),
				                            array(JText::_('COM_JEM_LAST'), JText::_('COM_JEM_BEFORE_LAST')),
				                            $this->item->recurr_bak->recurrence_number);
				$recurr_info = str_ireplace(array('[placeholder]', '[placeholder_weekday]'),
				                            array($recurr_num, $recurr_days),
				                            JText::_('COM_JEM_OUTPUT_WEEKDAY'));
				break;
			default:
				break;
			}

			if (!empty($recurr_type)) {
		 ?>
				<hr>
				<p><strong><?php echo JText::_('COM_JEM_RECURRING_INFO_TITLE'); ?></strong></p>
				<!-- <ul class="adminformlist">
					<li> -->
						<label class="col-sm-2 control-label"><?php echo JText::_('COM_JEM_RECURRENCE'); ?></label>
						<div class="col-sm-4">
							<input type="text" class="readonly form-control" readonly="readonly" value="<?php echo $recurr_type; ?>">
						</div>
					<!-- </li>
					<li> -->
						<div class="clear"></div>
						<label class="col-sm-2 control-label"> </label>
						<?php echo $recurr_info; ?>
					<!-- </li>
					<li> -->
						<label class="col-sm-2 control-label"><?php echo JText::_('COM_JEM_RECURRENCE_COUNTER'); ?></label>
						<div class="col-sm-4">
							<input type="text" class="readonly form-control" readonly="readonly" value="<?php echo $recurr_limit_date; ?>">
						</div>
				<!-- 	</li>
				</ul> -->
		<?php
			}
		} ?>
	</fieldset>
