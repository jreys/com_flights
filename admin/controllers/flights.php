<?php
/**
 * @author      João Reys Santos
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

defined("_JEXEC") or die("Restricted access");

class FlightsControllerFlights extends JControllerAdmin
{
    /**
     * The URL view list variable.
     *
     * @var    string
     * @since  12.2
     */
    protected $view_list = 'Flights';
    
    /**
     * Get the admin model and set it to default
     *
     * @param   string           $name    Name of the model.
     * @param   string           $prefix  Prefix of the model.
     * @param   array            $config  The model configuration.
     */
    public function getModel($name = 'Flight', $prefix='FlightsModel', $config = array())
    {
        $config['ignore_request'] = true;
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }
}
?>