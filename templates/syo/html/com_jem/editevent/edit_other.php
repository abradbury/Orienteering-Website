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

$max_custom_fields = $this->settings->get('global_editevent_maxnumcustomfields', -1); // default to All
?>

	<!-- CUSTOM FIELDS -->
	<?php if ($max_custom_fields != 0) : ?>
	<fieldset class="panelform">
		<legend><?php echo Text::_('COM_JEM_EVENT_CUSTOMFIELDS_LEGEND'); ?></legend>
		<div class="adminformlist">
			<?php
				$custom_file_fields = array(1, 2, 3, 4, 8, 10);
				$fields = $this->form->getFieldset('custom');

				if ($max_custom_fields < 0) :
					$max_custom_fields = count($fields);
				endif;

				$cnt = 0;
				foreach($fields as $field) :
					if (++$cnt <= $max_custom_fields) :
						$isCustomFileInput = in_array($cnt, $custom_file_fields); ?>
						
						<div class="mb-3">
							<?php echo $field->label; ?>

							<?php if ($isCustomFileInput) : ?>
								<div class="row">
									<div class="col-10">
										<?php echo $field->input; ?>
									</div>

									<div class="col-2">
										<input 
											type="file" 
											name="file_upload" 
											id="file_upload<?php echo $cnt; ?>" 
											accept=".pdf,.jpg,.jpeg,.txt,.rtf,.doc,.docx,.xlsx,.xls,.htm,.html"
											onchange="handleFiles(this);" 
											class="file_upload_button"
											data-event-date="<?php if(isset($this->item->dates)) : echo $this->item->dates; else: echo 'date'; endif; ?>"
											data-event-venue="<?php if (isset($this->item->localias)) : echo $this->item->localias; else : echo 'location'; endif; ?>"
										>
										<label class="btn btn-outline-secondary w-100" for="file_upload<?php echo $cnt; ?>">Choose a file</label>
									</div>
									
									<div class="col-10 progress" role="progressbar" aria-label="File upload progress bar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
										<div class="progress-bar bg-info progress-bar-striped progress-bar-animated" id="progressbar<?php echo $cnt; ?>" style="width: 100%"></div>
									</div>

									<div class="col-10">
										<div id="helpBlock<?php echo $cnt; ?>" class="alert alert-danger errorMsg" role="alert"></div>
									</div>
								</div>
							<?php else: ?>
								<?php echo $field->input; ?>
							<?php endif; ?>
						</div>
					<?php endif;
				endforeach;
			?>
		</div>
	</fieldset>
	<?php endif; ?>

