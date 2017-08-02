<?php
/**
 * @version 2.2.1
 * @package JEM
 * @copyright (C) 2013-2017 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die();

// Base this model on the backend version.
require_once JPATH_ADMINISTRATOR . '/components/com_jem/models/event.php';

/**
 * Editevent Model
 */
class JemModelEditevent extends JemModelEvent
{

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();

		// Load state from the request.
		$pk = $app->input->getInt('a_id', 0);
		$this->setState('event.id', $pk);

		$catid = $app->input->getInt('catid', 0);
		$this->setState('event.catid', $catid);

		$locid = $app->input->getInt('locid', 0);
		$this->setState('event.locid', $locid);

		$date = $app->input->getCmd('date', '');
		$this->setState('event.date', $date);

		$return = $app->input->get('return', '', 'base64');
		$this->setState('return_page', base64_decode($return));

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		$this->setState('layout', $app->input->getCmd('layout', ''));
	}

	/**
	 * Method to get event data.
	 *
	 * @param integer	The id of the event.
	 *
	 * @return mixed item data object on success, false on failure.
	 */
	public function getItem($itemId = null)
	{
		$jemsettings = JemHelper::config();

		// Initialise variables.
		$itemId = (int) (!empty($itemId)) ? $itemId : $this->getState('event.id');

		// Get a row instance.
		$table = $this->getTable();

		// Attempt to load the row.
		$return = $table->load($itemId);

		// Check for a table object error.
		if ($return === false && $table->getError()) {
			$this->setError($table->getError());
			return false;
		}

		$properties = $table->getProperties(1);
		$value = JArrayHelper::toObject($properties, 'JObject');

		// Backup current recurrence values
		if ($value->id){
			$value->recurr_bak = new stdClass;
			foreach (get_object_vars($value) as $k => $v) {
				if (strncmp('recurrence_', $k, 11) === 0) {
					$value->recurr_bak->$k = $v;
				}
			}
		}

		// Convert attrib field to Registry.
		$registry = new JRegistry();
		$registry->loadString($value->attribs);

		$globalregistry = JemHelper::globalattribs();

		$value->params = clone $globalregistry;
		$value->params->merge($registry);

		// Compute selected asset permissions.
		$user = JemFactory::getUser();
		//$userId = $user->get('id');
		//$asset = 'com_jem.event.' . $value->id;
		//$asset = 'com_jem';

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('count(id)'));
		$query->from('#__jem_register');
		$query->where(array('event = ' . $db->quote($itemId), 'waiting = 0', 'status = 1'));

		$db->setQuery($query);
		$res = $db->loadResult();
		$value->booked = (int)$res;
		if (!empty($value->maxplaces)) {
			$value->avplaces = $value->maxplaces - $value->booked;
		}

		$value->reginvitedonly = !empty($value->registra) && ($value->registra & 2);

		$files = JemAttachment::getAttachments('event' . $itemId);
		$value->attachments = $files;

		// Preset values on new events
		if (!$itemId) {
			$catid = (int) $this->getState('event.catid');
			$locid = (int) $this->getState('event.locid');
			$date  = $this->getState('event.date');

			// ???
			if (empty($value->catid) && !empty($catid)) {
				$value->catid = $catid;
			}

			if (empty($value->locid) && !empty($locid)) {
				$value->locid = $locid;
			}

			if (empty($value->dates) && JemHelper::isValidDate($date)) {
				$value->dates = $date;
			}
		}

		////////////////
		$venueQuery = $db->getQuery(true);
		$venueQuery->select(array(
			'alias'
		));
		$venueQuery->from('#__jem_venues');
		$venueQuery->where(array(
			'id= ' . $db->quote($value->locid)
		));
		$db->setQuery($venueQuery);
		$venueResult = $db->loadResult();
		$value->localias = $venueResult;
		////////////////

		// Check edit permission.
		$value->params->set('access-edit', $user->can('edit', 'event', $value->id, $value->created_by));

		// Check edit state permission.
		if (!$itemId && ($catId = (int) $this->getState('event.catid'))) {
			// New item.
			$cats = array($catId);
		} else {
			// Existing item (or no category)
			$cats = false;
		}
		$value->params->set('access-change', $user->can('publish', 'event', $value->id, $value->created_by, $cats));

		$value->author_ip = $jemsettings->storeip ? JemHelper::retrieveIP() : false;

		$value->articletext = $value->introtext;
		if (!empty($value->fulltext)) {
			$value->articletext .= '<hr id="system-readmore" />' . $value->fulltext;
		}

		return $value;
	}

	protected function loadForm($name, $source = null, $options = array(), $clear = false, $xpath = false)
	{
	//	JForm::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/fields');

		return parent::loadForm($name, $source, $options, $clear, $xpath);
	}

	/**
	 * Get the return URL.
	 *
	 * @return string return URL.
	 *
	 */
	public function getReturnPage()
	{
		return base64_encode($this->getState('return_page'));
	}

	############
	## VENUES ##
	############

	/**
	 * Get venues-data
	 */
	function getVenues()
	{
		$query 		= $this->buildQueryVenues();
		$pagination = $this->getVenuesPagination();

		$rows 		= $this->_getList($query, $pagination->limitstart, $pagination->limit);

		return $rows;
	}


	/**
	 * venues-query
	 */
	function buildQueryVenues()
	{
		$app 				= JFactory::getApplication();
		$params		 		= JemHelper::globalattribs();

		$filter_order 		= $app->getUserStateFromRequest('com_jem.selectvenue.filter_order', 'filter_order', 'l.venue', 'cmd');
		$filter_order_Dir	= $app->getUserStateFromRequest('com_jem.selectvenue.filter_order_Dir', 'filter_order_Dir', 'ASC', 'word');

		$filter_order 		= JFilterInput::getinstance()->clean($filter_order, 'cmd');
		$filter_order_Dir 	= JFilterInput::getinstance()->clean($filter_order_Dir, 'word');

		$filter_type 		= $app->getUserStateFromRequest('com_jem.selectvenue.filter_type', 'filter_type', 0, 'int');
		$search      		= $app->getUserStateFromRequest('com_jem.selectvenue.filter_search', 'filter_search', '', 'string');
		$search      		= $this->_db->escape(trim(JString::strtolower($search)));

		// Query
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(array('l.id','l.state','l.city','l.country','l.published','l.venue','l.ordering'));
		$query->from('#__jem_venues as l');

		// where
		$where = array();
		$where[] = 'l.published = 1';

		/* something to search for? (we like to search for "0" too) */
		if ($search || ($search === "0")) {
			switch ($filter_type) {
				case 1: /* Search venues */
					$where[] = 'LOWER(l.venue) LIKE "%' . $search . '%"';
					break;
				case 2: // Search city
					$where[] = 'LOWER(l.city) LIKE "%' . $search . '%"';
					break;
				case 3: // Search state
					$where[] = 'LOWER(l.state) LIKE "%' . $search . '%"';
			}
		}

		if ($params->get('global_show_ownedvenuesonly')) {
			$user = JemFactory::getUser();
			$userid = $user->get('id');
			$where[] = ' created_by = ' . (int) $userid;
		}

		$query->where($where);

		if (strtoupper($filter_order_Dir) !== 'DESC') {
			$filter_order_Dir = 'ASC';
		}

		// ordering
		if ($filter_order && $filter_order_Dir) {
			$orderby = $filter_order . ' ' . $filter_order_Dir;
		} else {
			$orderby = array('l.venue ASC','l.ordering ASC');
		}
		$query->order($orderby);

		return $query;
	}

    /**
     * venues-Pagination
     **/
	function getVenuesPagination() {

		$jemsettings = JemHelper::config();
		$app         = JFactory::getApplication();
		$limit       = $app->getUserStateFromRequest('com_jem.selectvenue.limit', 'limit', $jemsettings->display_num, 'int');
		$limitstart  = $app->input->getInt('limitstart', 0);
		// correct start value if required
		$limitstart  = $limit ? (int)(floor($limitstart / $limit) * $limit) : 0;

		$query = $this->buildQueryVenues();
		$total = $this->_getListCount($query);

		// Create the pagination object
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);

		return $pagination;
	}


	##############
	## CONTACTS ##
	##############

	/**
	 * Get contacts-data
	 */
	function getContacts()
	{
		$query 		= $this->buildQueryContacts();
		$pagination = $this->getContactsPagination();

		$rows 		= $this->_getList($query, $pagination->limitstart, $pagination->limit);

		return $rows;
	}


	/**
	 * contacts-Pagination
	 **/
	function getContactsPagination()
	{
		$jemsettings = JemHelper::config();
		$app         = JFactory::getApplication();
		$limit       = $app->getUserStateFromRequest('com_jem.selectcontact.limit', 'limit', $jemsettings->display_num, 'int');
		$limitstart  = $app->input->getInt('limitstart', 0);
		// correct start value if required
		$limitstart  = $limit ? (int)(floor($limitstart / $limit) * $limit) : 0;

		$query = $this->buildQueryContacts();
		$total = $this->_getListCount($query);

		// Create the pagination object
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);

		return $pagination;
	}


	/**
	 * contacts-query
	 */
	function buildQueryContacts()
	{
		$app		  		= JFactory::getApplication();
		$jemsettings  		= JemHelper::config();

		$filter_order 		= $app->getUserStateFromRequest('com_jem.selectcontact.filter_order', 'filter_order', 'con.ordering', 'cmd');
		$filter_order_Dir	= $app->getUserStateFromRequest('com_jem.selectcontact.filter_order_Dir', 'filter_order_Dir', '', 'word');

		$filter_order 		= JFilterInput::getinstance()->clean($filter_order, 'cmd');
		$filter_order_Dir	= JFilterInput::getinstance()->clean($filter_order_Dir, 'word');

		$filter_type   		= $app->getUserStateFromRequest('com_jem.selectcontact.filter_type', 'filter_type', 0, 'int');
		$search       		= $app->getUserStateFromRequest('com_jem.selectcontact.filter_search', 'filter_search', '', 'string');
		$search       		= $this->_db->escape(trim(JString::strtolower($search)));

		// Query
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(array('con.*'));
		$query->from('#__contact_details As con');

		// where
		$where = array();
		$where[] = 'con.published = 1';

		/* something to search for? (we like to search for "0" too) */
		if ($search || ($search === "0")) {
			switch ($filter_type) {
				case 1: /* Search name */
					$where[] = ' LOWER(con.name) LIKE \'%' . $search . '%\' ';
					break;
				case 2: /* Search address (not supported yet, privacy) */
					//$where[] = ' LOWER(con.address) LIKE \'%' . $search . '%\' ';
					break;
				case 3: // Search city
					$where[] = ' LOWER(con.suburb) LIKE \'%' . $search . '%\' ';
					break;
				case 4: // Search state
					$where[] = ' LOWER(con.state) LIKE \'%' . $search . '%\' ';
					break;
			}
		}
		$query->where($where);

		// ordering

		// ensure it's a valid order direction (asc, desc or empty)
		if (!empty($filter_order_Dir) && strtoupper($filter_order_Dir) !== 'DESC') {
			$filter_order_Dir = 'ASC';
		}

		if ($filter_order != '') {
			$orderby = $filter_order . ' ' . $filter_order_Dir;
			if ($filter_order != 'con.name') {
				$orderby = array($orderby, 'con.name'); // in case of city or state we should have a useful second ordering
			}
		} else {
			$orderby = 'con.name';
		}
		$query->order($orderby);

		return $query;
	}


	###########
	## USERS ##
	###########

	/**
	 * Get users data
	 */
	function getUsers()
	{
		$query      = $this->buildQueryUsers();
		$pagination = $this->getUsersPagination();

		$rows       = $this->_getList($query, $pagination->limitstart, $pagination->limit);

		// Add registration status if available
		$itemId     = (int)$this->getState('event.id');
		$db         = JFactory::getDBO();
		$qry        = $db->getQuery(true);
		// #__jem_register (id, event, uid, waiting, status, comment)
		$qry->select(array('reg.uid, reg.status, reg.waiting'));
		$qry->from('#__jem_register As reg');
		$qry->where('reg.event = ' . $itemId);
		$db->setQuery($qry);
		$regs = $db->loadObjectList('uid');

	//	JemHelper::addLogEntry((string)$qry . "\n" . print_r($regs, true), __METHOD__);

		foreach ($rows AS &$row) {
			if (array_key_exists($row->id, $regs)) {
				$row->status = $regs[$row->id]->status;
				if ($row->status == 1 && $regs[$row->id]->waiting) {
					++$row->status;
				}
			} else {
				$row->status = -99;
			}
		}

		return $rows;
	}


	/**
	 * users-Pagination
	 **/
	function getUsersPagination()
	{
		$jemsettings = JemHelper::config();
		$app         = JFactory::getApplication();
		$limit       = 0;//$app->getUserStateFromRequest('com_jem.selectusers.limit', 'limit', $jemsettings->display_num, 'int');
		$limitstart  = 0;//$app->input->getInt('limitstart', 0);
		// correct start value if required
		$limitstart  = $limit ? (int)(floor($limitstart / $limit) * $limit) : 0;

		$query = $this->buildQueryUsers();
		$total = $this->_getListCount($query);

		// Create the pagination object
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);

		return $pagination;
	}


	/**
	 * users-query
	 */
	function buildQueryUsers()
	{
		$app              = JFactory::getApplication();
		$jemsettings      = JemHelper::config();

		// no filters, hard-coded
		$filter_order     = 'usr.name';
		$filter_order_Dir = '';
		$filter_type      = '';
		$search           = '';

		// Query
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(array('usr.id, usr.name'));
		$query->from('#__users As usr');

		// where
		$where = array();
		$where[] = 'usr.block = 0';
		$where[] = 'NOT usr.activation > 0';

		/* something to search for? (we like to search for "0" too) */
		if ($search || ($search === "0")) {
			switch ($filter_type) {
				case 1: /* Search name */
					$where[] = ' LOWER(usr.name) LIKE \'%' . $search . '%\' ';
					break;
			}
		}
		$query->where($where);

		// ordering

		// ensure it's a valid order direction (asc, desc or empty)
		if (!empty($filter_order_Dir) && strtoupper($filter_order_Dir) !== 'DESC') {
			$filter_order_Dir = 'ASC';
		}

		if ($filter_order != '') {
			$orderby = $filter_order . ' ' . $filter_order_Dir;
			if ($filter_order != 'usr.name') {
				$orderby = array($orderby, 'usr.name'); // in case of (???) we should have a useful second ordering
			}
		} else {
			$orderby = 'usr.name ' . $filter_order_Dir;
		}
		$query->order($orderby);

		return $query;
	}


	/**
	 * Get list of invited users.
	 */
	function getInvitedUsers()
	{
		$itemId = (int)$this->getState('event.id');
		$db     = JFactory::getDBO();
		$query  = $db->getQuery(true);
		// #__jem_register (id, event, uid, waiting, status, comment)
		$query->select(array('reg.uid'));
		$query->from('#__jem_register As reg');
		$query->where('reg.event = ' . $itemId);
		$query->where('reg.status = 0');
		$db->setQuery($query);
		$regs = $db->loadColumn();

	//	JemHelper::addLogEntry((string)$query . "\n" . implode(',', $regs), __METHOD__);
		return $regs;
	}

}
