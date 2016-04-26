<?php
defined("_JEXEC") or die("Restricted access");

jimport('joomla.html.html');
jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of contacts
 */
class JFormFieldFlight extends JFormFieldList
{
    /**
     * The form field type.
     */
    protected $type             = 'Flight';

    /**
     *  Method to get the field input markup.
     */
    protected function getOptions()
    {
        // Initialise variables.
        $options        = array();
        $db             = & JFactory::getDbo();
        $query          = $db->getQuery(true);

        $query->select('a.id AS id, b.title AS origin, c.title AS destination')->from('#__flights AS a');                
        $query->join( 'LEFT', '#__airports AS b ON a.origin = b.id' );
        $query->join( 'LEFT', '#__airports AS c ON a.destination = c.id' );
        $db->setQuery($query);

        $airport           = $db->loadObjectList();

        foreach ( $airport as $key=>$value ) {
            $options[]  = JHTML::_('select.option',  $value->id, $value->origin." >>>> ".$value->destination);
        }

        return $options;

    }

}

?>