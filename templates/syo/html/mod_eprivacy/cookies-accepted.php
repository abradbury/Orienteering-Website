<?php
/**
 * @subpackage	mod_eprivacy
 * @copyright	Copyright (C) 2005 - 2012 Michael Richey. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="plg_system_eprivacy_module">
    <div class="plg_system_eprivacy_accepted" style="display:none">
        <small>
            <?php echo JText::_('PLG_SYS_EPRIVACY_UNACCEPT_MESSAGE_LOGIN'); ?>
            <button style="margin:0; padding:0;" type="button" class="btn btn-link plg_system_eprivacy_accepted"><?php echo JText::_('PLG_SYS_EPRIVACY_UNACCEPT');?></button>
        </small>
    </div>
</div>
<div id="plg_system_eprivacy" style="display:none"></div>