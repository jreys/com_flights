<?php
/**
 * @author      João Reys Santos
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

defined("_JEXEC") or die("Restricted access");

class FlightsModelFlights extends JModelList
{
    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'a.id', 'id',
                'a.origin', 'origin',
                'a.destination', 'destination',
                'a.seats', 'seats',
                'a.departure', 'departure',
                'a.published', 'published',
                'a.created', 'created','ordering', 'state'
            );
        }
        parent::__construct($config);
    }
    
    /**
     * Method to auto-populate the model state.
     *
     * This method should only be called once per instantiation and is designed
     * to be called on the first call to the getState() method unless the model
     * configuration flag to ignore the request is set.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   An optional ordering field.
     * @param   string  $direction  An optional direction (asc|desc).
     *
     * @return  void
     */
    protected function populateState($ordering = 'seats', $direction = 'DESC')
    {
        // Get the Application
        $app = JFactory::getApplication();
        
        // Set filter state for search
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        // Set filter state for publish state
        $published = $app->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '', 'string');
        $this->setState('filter.published', $published);
        


        // Load the parameters.
        $params = JComponentHelper::getParams('com_flights');
        $this->setState('params', $params);

        // List state information.
        parent::populateState($ordering, $direction);
    }
    
    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string  $id  A prefix for the store id.
     *
     * @return  string  A store id.
     *
     * @since   1.6
     */
    protected function getStoreId($id = '')
    {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.published');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return  JDatabaseQuery
     */
    protected function getListQuery()
    {
        // Get database object
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*, b.title AS origin, c.title AS destination')->from('#__flights AS a');                
        $query->join( 'LEFT', '#__airports AS b ON a.origin = b.id' );
        $query->join( 'LEFT', '#__airports AS c ON a.destination = c.id' );

        // Filter by search
        $search = $this->getState('filter.search');
        $s = $db->quote('%'.$db->escape($search, true).'%');
        
        if (!empty($search))
        {
            $search = $db->quote('%' . $db->escape($search, true) . '%');
            $query->where('a.seats LIKE ' . $search);
        }
        
        // Filter by published state.
        $published = $this->getState('filter.published');
        if (is_numeric($published))
        {
            $query->where('a.published = ' . (int) $published);
        }
        elseif ($published === '')
        {
            // Only show items with state 'published' / 'unpublished'
            $query->where('a.published IN (0, 1)');
        }


        // Add list ordering and list direction to SQL query
        $sort = $this->getState('list.ordering', 'a.seats');
        $order = $this->getState('list.direction', 'DESC');
        $query->order($db->escape($sort).' '.$db->escape($order));
        
        return $query;
    }
    
    /**
     * Method to get an array of data items.
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @since   12.2
     */
    public function getItems()
    {
        if ($items = parent::getItems()) {
            //Do any procesing on fields here if needed
        }

        return $items;
    }
}
?>