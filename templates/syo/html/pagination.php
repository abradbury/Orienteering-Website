<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	Templates.bluestork
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * This is a file to add template specific chrome to pagination rendering.
 *
 * pagination_list_footer
 *	Input variable $list is an array with offsets:
 *		$list[prefix]		: string
 *		$list[limit]		: int
 *		$list[limitstart]	: int
 *		$list[total]		: int
 *		$list[limitfield]	: string
 *		$list[pagescounter]	: string
 *		$list[pageslinks]	: string
 *
 * pagination_list_render
 *	Input variable $list is an array with offsets:
 *		$list[all]
 *			[data]		: string
 *			[active]	: boolean
 *		$list[start]
 *			[data]		: string
 *			[active]	: boolean
 *		$list[previous]
 *			[data]		: string
 *			[active]	: boolean
 *		$list[next]
 *			[data]		: string
 *			[active]	: boolean
 *		$list[end]
 *			[data]		: string
 *			[active]	: boolean
 *		$list[pages]
 *			[{PAGE}][data]		: string
 *			[{PAGE}][active]	: boolean
 *
 * pagination_item_active
 *	Input variable $item is an object with fields:
 *		$item->base	: integer
 *		$item->prefix	: string
 *		$item->link	: string
 *		$item->text	: string
 *
 * pagination_item_inactive
 *	Input variable $item is an object with fields:
 *		$item->base	: integer
 *		$item->prefix	: string
 *		$item->link	: string
 *		$item->text	: string
 *
 * This gives template designers ultimate control over how pagination is rendered.
 *
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */

/**
 * This function is responsible for showing the select list for the number of items to display per page.
 */
function pagination_list_footer($list)
{
	// Initialise variables.
	$lang = JFactory::getLanguage();
	$html = "<div class=\"container\"><div class=\"pagination\">\n";

	$html .= "\n<div class=\"limit\">".JText::_('JGLOBAL_DISPLAY_NUM').$list['limitfield']."</div>";
	$html .= $list['pageslinks'];
	$html .= "\n<div class=\"limit\">".$list['pagescounter']."</div>";

	$html .= "\n<input type=\"hidden\" name=\"" . $list['prefix'] . "limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div></div>";

	return $html;
}

/**
 * This function is responsible for showing the list of page number links as well at the Start, End, Previous and Next links.
 */
function pagination_list_render($list)
{
	// Initialise variables.
	$lang = JFactory::getLanguage();
	$html = null;

	$html = "<nav><ul class=\"pagination\">";

	$html .= $list['start']['data'];
	$html .= $list['previous']['data'];

	foreach($list['pages'] as $page) {
		$html .= $page['data'];
	}

	$html .= $list['next']['data'];
	$html .= $list['end']['data'];

	$html .= "</ul></nav>";

	return $html;
}

/**
 * This function displays the links to other page numbers other than the "current" page.
 */
function pagination_item_active(&$item)
{
	return "<li class=\"page-item\"><a class=\"page-link\" href=\"".$item->link."\" title=\"".$item->text."\">".$item->text."</a></li>";
}

/**
 * This function displays the current page number, usually not hyperlinked.
 */
function pagination_item_inactive(&$item)
{
	$liClass = null;

	if ($item->active) {
		$liClass = "active";
	} else {
		$liClass = "disabled";
	}

	return "<li class=\"page-item ".$liClass."\"><a class=\"page-link\" href=\"#\">".$item->text."</a></li>";
}
?>
