<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.syo
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

// Optionally set by the chrome that includes this file
$extraClass  = $extraClass ?? '';
$headerClass = $headerClass ?? '';
$headerLink  = $headerLink ?? '';
$wrapHeader  = $wrapHeader ?? false;

$module = $displayData['module'];
$params = $displayData['params'];

if ($module->content === null || $module->content === '') {
    return;
}

$moduleTag              = $params->get('module_tag', 'div');
$moduleAttribs          = [];
$moduleAttribs['class'] = trim($module->position . ' ' . $extraClass . ' ' . htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8'));
$headerTag              = htmlspecialchars($params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
$headerAttribs          = [];
$headerAttribs['class'] = trim($headerClass . ' ' . htmlspecialchars($params->get('header_class', ''), ENT_QUOTES, 'UTF-8'));

// Only add aria if the moduleTag is not a div
if ($moduleTag !== 'div') {
    if ($module->showtitle) :
        $moduleAttribs['aria-labelledby'] = 'mod-' . $module->id;
        $headerAttribs['id']              = 'mod-' . $module->id;
    else :
        $moduleAttribs['aria-label'] = $module->title;
    endif;
}

$header = '<' . $headerTag . ' ' . ArrayHelper::toString($headerAttribs) . '>' . $module->title . '</' . $headerTag . '>';
?>
<<?php echo $moduleTag; ?> <?php echo ArrayHelper::toString($moduleAttribs); ?>>
    <?php if ($module->showtitle) : ?>
        <?php if ($wrapHeader) : ?>
    <div class="eventsHeader">
        <?php echo $header . $headerLink; ?>
    </div>
        <?php else : ?>
    <?php echo $header; ?>
        <?php endif; ?>
    <?php endif; ?>
    <div>
        <?php echo $module->content; ?>
    </div>
</<?php echo $moduleTag; ?>>
