<?php
defined("_JEXEC") or die("Restricted access");

jimport('joomla.html.html');
jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of contacts
 */
class JFormFieldAirport extends JFormFieldList
{
    /**
     * The form field type.
     */
    protected $type             = 'Airport';

    /**
     *  Method to get the field input markup.
     */
    protected function getOptions()
    {
        // Initialise variables.
        $options        = array();
        $db             = & JFactory::getDbo();
        $query          = $db->getQuery(true);

        $query->select('id, title');
        $query->from('#__airports');
        $db->setQuery($query);

        $airport           = $db->loadObjectList();

        foreach ( $airport as $key=>$value ) {
            $options[]  = JHTML::_('select.option',  $value->id, $value->title);
        }

        return $options;

    }

}

?>