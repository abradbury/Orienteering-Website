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
			<!--START PUBLISHING FIELDSET -->
			<fieldset class="mb-3">
				<legend><?php echo Text::_('COM_JEM_EDITEVENT_PUBLISH_TAB'); ?></legend>
					<div class="adminformlist">
					<div><?php echo $this->form->getLabel('published'); ?><?php echo $this->form->getInput('published'); ?></div>
				</div>
			</fieldset>
