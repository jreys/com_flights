<?php
/**
 * @author      João Reys Santos
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

defined("_JEXEC") or die("Restricted access");

class FlightsControllerFlight extends JControllerForm
{
    /**
     * The URL view item variable.
     *
     * @var    string
     * @since  12.2
     */
    protected $view_item = 'Flight';

    /**
     * The URL view list variable.
     *
     * @var    string
     * @since  12.2
     */
    protected $view_list = 'Flights';
    
    /**
     * Method to run batch operations.
     *
     * @param   object  $model  The model.
     *
     * @return  boolean   True if successful, false otherwise and internal error is set.
     *
     * @since   2.5
     */
    public function batch($model = null)
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Set the model
        $model = $this->getModel('Flight', 'FlightsModel', array());

        // Preset the redirect
        $this->setRedirect(JRoute::_('index.php?option=com_flights&view=flights' . $this->getRedirectToListAppend(), false));

        return parent::batch($model);
    }
}
?>