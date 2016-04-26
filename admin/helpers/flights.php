<?php
/**
 * @author		João Reys Santos
 * @license		http://www.gnu.org/licenses/gpl-2.0.html
 */

defined("_JEXEC") or die("Restricted access");

class FlightsHelper
{
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_FLIGHTS_SUBMENU_AIRPORTS'), 
			'index.php?option=com_flights&view=airports', 
			$vName == 'airports'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FLIGHTS_SUBMENU_FLIGHTS'), 
			'index.php?option=com_flights&view=flights', 
			$vName == 'flights'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_FLIGHTS_SUBMENU_BOOKINGS'), 
			'index.php?option=com_flights&view=bookings', 
			$vName == 'bookings'
		);

	}
	
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_flights';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
	

}