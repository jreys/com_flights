<?php
/**
 * @author		João Reys Santos
 * @license		http://www.gnu.org/licenses/gpl-2.0.html
 */

defined("_JEXEC") or die("Restricted access");

require_once JPATH_COMPONENT.'/helpers/flights.php';

class FlightsViewAirports extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	
	public function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		$this->pagination = $this->get('Pagination');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
			return false;
		}
		
		FlightsHelper::addSubmenu('airports');
		
		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
		}
		
		parent::display($tpl);
	}
	
	/**
	 *	Method to add a toolbar
	 */
	protected function addToolbar()
	{
		$state	= $this->get('State');
		$canDo	= FlightsHelper::getActions();
		$user	= JFactory::getUser();

		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		
		JToolBarHelper::title(JText::_('COM_FLIGHTS_VIEW_AIRPORTS_TITLE'));
		
		if ($canDo->get('core.create'))
		{
			JToolBarHelper::addNew('airport.add','JTOOLBAR_NEW');
		}

		if (($canDo->get('core.edit')) && isset($this->items[0]))
		{
			JToolBarHelper::editList('airport.edit','JTOOLBAR_EDIT');
		}
		
		if ($canDo->get('core.edit.state'))
		{
            if (isset($this->items[0]->published))
			{
			    JToolBarHelper::divider();
				JToolbarHelper::publish('airports.publish', 'JTOOLBAR_PUBLISH', true);
				JToolbarHelper::unpublish('airports.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            } 
			else if (isset($this->items[0]))
			{
                // Show a direct delete button
                JToolBarHelper::deleteList('', 'airports.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->published))
			{
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('airports.archive','JTOOLBAR_ARCHIVE');
            }
		}
		
		// Show trash and delete for components that uses the state field
        if (isset($this->items[0]->published))
		{
		    if ($state->get('filter.published') == -2 && $canDo->get('core.delete'))
			{
			    JToolBarHelper::deleteList('', 'airports.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    }
			else if ($state->get('filter.published') != -2 && $canDo->get('core.edit.state'))
			{
			    JToolBarHelper::trash('airports.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }
		
		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_flights');
		}
	}
}
?>