<?php
/**
 * @author		João Reys Santos
 * @license		http://www.gnu.org/licenses/gpl-2.0.html
 */

defined("_JEXEC") or die("Restricted access");

class FlightsTableBooking extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  A database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__bookings', 'id', $db);
	}

	/**
	 * Overriden JTable::store to set modified data.
	 *
	 * @param   boolean	True to update fields even if they are null.
	 *
	 * @return  boolean  True on success.
	 */
	public function store($updateNulls = false)
	{
		$date = JFactory::getDate();
		$config = JComponentHelper::getParams("com_flights");
		
		if (!$this->id)
		{			
			// New item. An item created and created_by field can be set by the user,
			// so we don't touch either of these if they are set.			
			if (!(int) $this->created)
			{
				$this->created = $date->toSql();
			}
			
			if ($config->get("publish_new_airports", 1))
			{
				$this->published = 1;
			}

		}
		
		return parent::store($updateNulls);
	}
}
?>