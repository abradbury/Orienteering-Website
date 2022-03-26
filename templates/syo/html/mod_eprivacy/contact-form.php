<?php
/**
 * @subpackage	mod_eprivacy
 * @copyright	Copyright (C) 2005 - 2012 Michael Richey. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$target = $pluginparams->get('policytarget', '_blank');
?>
<div class="plg_system_eprivacy_module">
    <?php if($pluginparams->get('displaytype','message') != "message") : ?>
    <div class="plg_system_eprivacy_message alert alert-danger" style="display:none; margin-bottom: 10px">
        <?php if($params->get('showtitle',1)): ?>
            <h2><?php echo JText::_('PLG_SYS_EPRIVACY_MESSAGE_TITLE');?></h2>
        <?php endif; ?>
        <p><?php echo JText::_('PLG_SYS_EPRIVACY_MESSAGE_CONTACT'); ?></p>
        <?php if($policyurl) : ?>
            <p><a href="<?php echo $policyurl;?>" target="<?php echo $target;?>"><?php echo JText::_('PLG_SYS_EPRIVACY_POLICYTEXT');?></a></p>
        <?php endif; ?>
        <?php if($legallinks) : ?>
            <p><a href="<?php echo $legallinks[0];?>" onclick="window.open(this.href);return false;" target="<?php echo $target;?>"><?php echo JText::_('PLG_SYS_EPRIVACY_LAWLINK_TEXT'); ?></a></p>
            <p><a href="<?php echo $legallinks[1];?>" onclick="window.open(this.href);return false;" target="<?php echo $target;?>"><?php echo JText::_('PLG_SYS_EPRIVACY_GDPRLINK_TEXT'); ?></a></p>
        <?php endif; ?>
        <?php echo ePrivacyHelper::cookieTable($pluginparams); ?>
        <div class="row" style="margin-top:10px">
            <div class="col-xs-6"><button type="button" class="plg_system_eprivacy_agreed btn btn-success btn-block"><?php echo JText::_('PLG_SYS_EPRIVACY_AGREE');?></button></div>
            <div class="col-xs-6"><button type="button" class="plg_system_eprivacy_declined btn btn-danger btn-block"><?php echo JText::_('PLG_SYS_EPRIVACY_DECLINE');?></button></div>
        </div>
    </div>
    <div class="plg_system_eprivacy_declined alert alert-danger" style="display:none; margin-bottom: 10px">
        <p><?php echo JText::_('PLG_SYS_EPRIVACY_DECLINED_CONTACT'); ?></p>
        <button style="margin-top:10px" type="button" class="plg_system_eprivacy_reconsider btn btn-primary"><?php echo JText::_('PLG_SYS_EPRIVACY_RECONSIDER');?></button> 
    </div>
    <?php endif; ?>
</div>
<div id="plg_system_eprivacy" style="display:none"></div>