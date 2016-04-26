<?php
/**
 * @author      João Reys Santos
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

defined("_JEXEC") or die("Restricted access");

class FlightsModelFlight extends JModelAdmin
{
    /**
     * @var        string    The prefix to use with controller messages.
     * @since   1.6
     */
    protected $text_prefix = 'COM_FLIGHTS';

    /**
     * The type alias for this content type.
     *
     * @var      string
     * @since    3.2
     */
    public $typeAlias = 'com_flights.flight';      

    /**
     * Prepare and sanitise the table data prior to saving.
     *
     * @param   JTable    A JTable object.
     *
     * @return  void
     * @since   1.6
     */
    protected function prepareTable($table)
    {
        // Set the publish date to now
        $db = $this->getDbo();
    }

    /**
     * Method to perform batch operations on an item or a set of items.
     *
     * @param   array  $commands  An array of commands to perform.
     * @param   array  $pks       An array of item ids.
     * @param   array  $contexts  An array of item contexts.
     *
     * @return  boolean  Returns true on success, false on failure.
     *
     * @since   12.2
     */
    public function batch($commands, $pks, $contexts)
    {
        // Sanitize ids.
        $pks = array_unique($pks);
        JArrayHelper::toInteger($pks);

        // Remove any values of zero.
        if (array_search(0, $pks, true))
        {
            unset($pks[array_search(0, $pks, true)]);
        }

        if (empty($pks))
        {
            $this->setError(JText::_('JGLOBAL_NO_ITEM_SELECTED'));
            return false;
        }

        $done = false;

        // Set some needed variables.
        $this->user = JFactory::getUser();
        $this->table = $this->getTable();
        $this->tableClassName = get_class($this->table);
        $this->contentType = new JUcmType;
        $this->type = $this->contentType->getTypeByTable($this->tableClassName);
        $this->batchSet = true;

        if ($this->type == false)
        {
            $type = new JUcmType;
            $this->type = $type->getTypeByAlias($this->typeAlias);

        }
        if ($this->type === false)
        {
            $type = new JUcmType;
            $this->type = $type->getTypeByAlias($this->typeAlias);
            $typeAlias = $this->type->type_alias;
        }
        else
        {
            $typeAlias = $this->type->type_alias;
        }
        $this->tagsObserver = $this->table->getObserverOfClass('JTableObserverTags');

        if (!$done)
        {
            $this->setError(JText::_('JLIB_APPLICATION_ERROR_INSUFFICIENT_BATCH_INFORMATION'));
            return false;
        }

        // Clear the cache
        $this->cleanCache();

        return true;
    }
    
    /**
     * Alias for JTable::getInstance()
     *
     * @param   string  $type    The type (name) of the JTable class to get an instance of.
     * @param   string  $prefix  An optional prefix for the table class name.
     * @param   array   $config  An optional array of configuration values for the JTable object.
     *
     * @return  mixed    A JTable object if found or boolean false if one could not be found.
     */
    public function getTable($type = 'Flight', $prefix = 'FlightsTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }
    
    /**
     * Method for getting the form from the model.
     *
     * @param   array    $data      Data for the form.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  mixed  A JForm object on success, false on failure
     */
    public function getForm($data = array(), $loadData = true)
    {
        JForm::addRulePath(JPATH_COMPONENT_ADMINISTRATOR.'/models/rules');      
        
        $options = array('control' => 'jform', 'load_data' => $loadData);
        $form = $this->loadForm($this->typeAlias, $this->name, $options);
        
        if(empty($form))
        {
            return false;
        }

        return $form;
    }
    
    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  array    The default data is an empty array.
     */
    protected function loadFormData()
    {
        $app = JFactory::getApplication();
        $data = $app->getUserState($this->option . '.edit.' . $this->name . '.data', array());
        
        if(empty($data))
        {
            $data = $this->getItem();
        }
        
        return $data;
    }
    
    /**
     * Method to get a single record.
     *
     * @param   integer The id of the primary key.
     *
     * @return  mixed   Object on success, false on failure.
     * @since   1.6
     */
    public function getItem($pk = null)
    {
        if (!$item = parent::getItem($pk))
        {           
            throw new Exception('Failed to load item');
        }
        
        if (!$item->id)
        {
        }
        
        return $item;
    }
}
?>