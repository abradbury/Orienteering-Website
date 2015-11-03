<?php
/**
 * @version 2.0.2
 * @package JEM
 * @subpackage JEM Module
 * @copyright (C) 2013-2014 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_jem/models', 'JemModel');

/**
 * Module-Basic
 */
abstract class modJEMHelper
{

	/**
	 * Method to get the events
	 *
	 * @access public
	 * @return array
	 */
	public static function getList(&$params)
	{
		mb_internal_encoding('UTF-8');

		$db       = JFactory::getDBO();
		$user     = JFactory::getUser();
		$levels   = $user->getAuthorisedViewLevels();
		$settings = JemHelper::config();

		// Use (short) format saved in module settings or in component settings or format in language file otherwise
		$dateFormat = $params->get('formatdate', '');
		if (empty($dateFormat)) {
			// on empty format long format will be used but we need short format
			if (isset($settings->formatShortDate) && $settings->formatShortDate) {
				$dateFormat = $settings->formatShortDate;
			} else {
				$dateFormat = JText::_('COM_JEM_FORMAT_SHORT_DATE');
			}
		}
		$timeFormat = $params->get('formattime', '');
		$addSuffix  = false;
		if (empty($timeFormat)) {
			// on empty format component's format will be used, so also use component's time suffix
			$addSuffix = true;
		}

		# Retrieve Eventslist model for the data
		$model = JModelLegacy::getInstance('Eventslist', 'JemModel', array('ignore_request' => true));

		# Set params for the model
		# has to go before the getItems function
		$model->setState('params', $params);

		# filter published
		#  0: unpublished
		#  1: published
		#  2: archived
		# -2: trashed

		$type = $params->get('type');

		# All events
		$cal_from = "";

		// TODO: Add parameter to specify start and end dates for showing events
		// (used for schools league)

		// # archived events
		// if ($type == 2) {
		// 	$model->setState('filter.published',2);
		// 	$model->setState('filter.orderby',array('a.dates DESC','a.times DESC'));
		// 	$cal_from = "";
		// }

		// # upcoming or running events, on mistake default to upcoming events
		// else {
		// 	$model->setState('filter.published',1);
		// 	$model->setState('filter.orderby',array('a.dates ASC','a.times ASC'));

		// 	$offset_minutes = 60 * $params->get('offset_hours', 0);

		// 	$cal_from = "((TIMESTAMPDIFF(MINUTE, NOW(), CONCAT(a.dates,' ',IFNULL(a.times,'00:00:00'))) > $offset_minutes) ";
		// 	$cal_from .= ($type == 1) ? " OR (TIMESTAMPDIFF(MINUTE, NOW(), CONCAT(IFNULL(a.enddates,a.dates),' ',IFNULL(a.endtimes,'23:59:59'))) > $offset_minutes)) " : ") ";
		// }

		$model->setState('filter.calendar_from',$cal_from);
		$model->setState('filter.groupby','a.id');

		# filter category's
		$catids = JemHelper::getValidIds($params->get('catid'));
		if ($catids) {
			$model->setState('filter.category_id',$catids);
			$model->setState('filter.category_id.include',true);
		}

		# filter venue's
		$venids = JemHelper::getValidIds($params->get('venid'));
		if ($venids) {
			$model->setState('filter.venue_id',$venids);
			$model->setState('filter.venue_id.include',true);
		}

		# count
		$count = $params->get('count', '2');
		$model->setState('list.limit',$count);

		# Retrieve the available Events
		$events = $model->getItems();

		# Loop through the result rows and prepare data
		$i		= 0;
		$lists	= array();

		foreach ($events as $row)
		{
			//cut titel
			$length = mb_strlen($row->title);

			if ($length > $params->get('cuttitle', '18')) {
				$row->title = mb_substr($row->title, 0, $params->get('cuttitle', '18'));
				$row->title = $row->title.'...';
			}

			$lists[$i] = new stdClass;
			$lists[$i]->link     = JRoute::_(JemHelperRoute::getEventRoute($row->slug));
			
			# time/date
			list($lists[$i]->date,
			     $lists[$i]->time)  = self::_format_date_time($row, $params->get('datemethod', 1), $dateFormat, $timeFormat, $addSuffix);
			$lists[$i]->dateinfo    = JEMOutput::formatDateTime($row->dates, $row->times, $row->enddates, $row->endtimes, $dateFormat, $timeFormat, $addSuffix);


			$lists[$i]->dateinfo = JemOutput::formatDateTime($row->dates, $row->times, $row->enddates, $row->endtimes,
			                                                 $dateFormat, $timeFormat, $addSuffix);
			$lists[$i]->text     = $params->get('showtitloc', 0) ? $row->title : htmlspecialchars($row->venue, ENT_COMPAT, 'UTF-8');
			$lists[$i]->city     = htmlspecialchars($row->city, ENT_COMPAT, 'UTF-8');
			$lists[$i]->venueurl = !empty($row->venueslug) ? JRoute::_(JEMHelperRoute::getVenueRoute($row->venueslug)) : null;
			$i++;
		}

		return $lists;
	}

	/**
	 * Method to get a valid url
	 *
	 * @access public
	 * @return string
	 */
	protected static function _format_url($url)
	{
		if(!empty($url) && strtolower(substr($url, 0, 7)) != "http://") {
			$url = 'http://'.$url;
		}
		return $url;
	}

	/**
	 * Method to format date and time information
	 *
	 * @access protected
	 * @return array(string, string) returns date and time strings as array
	 */
	protected static function _format_date_time($row, $method, $dateFormat = '', $timeFormat = '', $addSuffix = false)
	{
		if (empty($row->dates)) {
			// open date
			$date  = JEMOutput::formatDateTime('', ''); // "Open date"
			$times = $row->times;
			$endtimes = $row->endtimes;
		} else {
			//Get needed timestamps and format
			$yesterday_stamp = mktime(0, 0, 0, date("m"), date("d")-1, date("Y"));
			$yesterday       = strftime("%Y-%m-%d", $yesterday_stamp);
			$today_stamp     = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
			$today           = date('Y-m-d');
			$tomorrow_stamp  = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
			$tomorrow        = strftime("%Y-%m-%d", $tomorrow_stamp);

			$dates_stamp     = $row->dates ? strtotime($row->dates) : null;
			$enddates_stamp  = $row->enddates ? strtotime($row->enddates) : null;

			$times = $row->times; // show starttime by default

			 // datemethod show date
			// TODO: check date+time to be more acurate
			//Upcoming multidayevent (From 16.10.2008 Until 18.08.2008)
			if (($dates_stamp >= $today_stamp) && ($enddates_stamp > $dates_stamp)) {
				$startdate = JEMOutput::formatdate($row->dates, $dateFormat);
				$enddate = JEMOutput::formatdate($row->enddates, $dateFormat);
				$date = JText::sprintf('MOD_JEM_WIDE_FROM_UNTIL', $startdate, $enddate);
				// additionally show endtime
				$endtimes = $row->endtimes;
			}
			//current multidayevent (Until 18.08.2008)
			elseif ($row->enddates && ($enddates_stamp >= $today_stamp) && ($dates_stamp < $today_stamp)) {
				$enddate = JEMOutput::formatdate($row->enddates, $dateFormat);
				$date = JText::sprintf('MOD_JEM_WIDE_UNTIL', $enddate);
				// show endtime instead of starttime
				$times = false;
				$endtimes = $row->endtimes;
			}
			//single day event
			else {
				$startdate = JEMOutput::formatdate($row->dates, $dateFormat);
				$date = JText::sprintf('MOD_JEM_WIDE_ON_DATE', $startdate);
				// additionally show endtime, but on single day events only to prevent user confusion
				if (empty($row->enddates)) {
					$endtimes = $row->endtimes;
				}
			}
		}

		$time  = empty($times)    ? '' : JEMOutput::formattime($times, $timeFormat, $addSuffix);
		$time .= empty($endtimes) ? '' : ('&nbsp;-&nbsp;' . JEMOutput::formattime($row->endtimes, $timeFormat, $addSuffix));

		return array($date, $time);
	}
}