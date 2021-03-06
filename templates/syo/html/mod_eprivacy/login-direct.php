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
    <?php if($pluginparams->get('displaytype','message') != "message") : ?>
    <div role="alert" class="alert alert-warning plg_system_eprivacy_message" style="display:none">
        <?php if($params->get('showtitle',1)): ?>
            <h2><?php echo JText::_('PLG_SYS_EPRIVACY_MESSAGE_TITLE');?></h2>
        <?php endif; ?>
        <p><?php echo JText::_('PLG_SYS_EPRIVACY_MESSAGE_LOGIN'); ?></p>
        <?php if($policyurl) : ?>
            <p><a href="<?php echo $policyurl;?>" target="<?php echo $pluginparams->get('policytarget', '_blank');?>"><?php echo JText::_('PLG_SYS_EPRIVACY_POLICYTEXT');?></a></p>
        <?php endif; ?>
        <?php if($pluginparams->get('lawlink',1)) : ?>
            <p><a href="https://eur-lex.europa.eu/LexUriServ/LexUriServ.do?uri=CELEX:32002L0058:<?php echo $linklang;?>:NOT" onclick="window.open(this.href);return false;"><?php echo JText::_('PLG_SYS_EPRIVACY_LAWLINK_TEXT'); ?></a></p>
            <p><a href="https://eur-lex.europa.eu/legal-content/<?php echo $linklang;?>/TXT/HTML/?uri=CELEX:32016R0679" onclick="window.open(this.href);return false;"><?php echo JText::_('PLG_SYS_EPRIVACY_GDPRLINK_TEXT'); ?></a></p>
        <?php endif; ?>
        <button type="button" class="btn btn-danger plg_system_eprivacy_declined"><?php echo JText::_('PLG_SYS_EPRIVACY_DECLINE');?></button>
        <button type="button" class="btn btn-success plg_system_eprivacy_agreed"><?php echo JText::_('PLG_SYS_EPRIVACY_AGREE');?></button>
    </div>
    <div role="alert" class="alert alert-danger plg_system_eprivacy_declined" style="display:none">
        <p><?php echo JText::_('PLG_SYS_EPRIVACY_DECLINED_LOGIN'); ?></p>
        <button type="button" class="btn btn-default plg_system_eprivacy_reconsider"><?php echo JText::_('PLG_SYS_EPRIVACY_RECONSIDER');?></button> 
    </div>
    <?php endif; ?>
    <div class="plg_system_eprivacy_accepted" style="display:none">
        <p>
            <?php echo JText::_('PLG_SYS_EPRIVACY_UNACCEPT_MESSAGE_LOGIN'); ?>
            <button type="button" class="btn btn-link plg_system_eprivacy_accepted"><?php echo JText::_('PLG_SYS_EPRIVACY_UNACCEPT');?></button> 
        </p>
    </div>
</div>
<div id="plg_system_eprivacy" style="display:none"></div>