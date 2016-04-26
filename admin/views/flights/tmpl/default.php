<?php
/**
 * @author		João Reys Santos
 * @license		http://www.gnu.org/licenses/gpl-2.0.html
 */

defined("_JEXEC") or die("Restricted access");

// necessary libraries
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

// sort ordering and direction
$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$archived	= $this->state->get('filter.published') == 2 ? true : false;
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
$canOrder	= ($user->authorise('core.edit.state', 'com_test') && isset($this->items[0]->ordering));?>

<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_flights&view=flights'); ?>" method="post" name="adminForm" id="adminForm">

<?php if (!empty( $this->sidebar)) : ?>
	<!-- sidebar -->
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<!-- end sidebar -->
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>

	<?php
		// Search tools bar
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
	?>
	<?php if (empty($this->items)) : ?>
		<div class="alert alert-no-items">
			<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
		</div>
	<?php else : ?>


	<table class="table table-striped" id="flightsList">
		<thead>
			<tr>
				
				<!-- item checkbox -->
				<th width="1%" class="hidden-phone">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
				
				<!-- item state -->
				<?php if (isset($this->items[0]->published)): ?>
					<th width="1%" class="nowrap center">
						<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
					</th>
                <?php endif; ?>
				
				<th class="nowrap left">
					<?php echo JHtml::_('grid.sort', JText::_('COM_FLIGHTS_FIELD_ORIGIN_LABEL'), 'a.origin', $listDirn, $listOrder) ?>
				</th>

				<th class="nowrap left">
					<?php echo JHtml::_('grid.sort', JText::_('COM_FLIGHTS_FIELD_DESTINATION_LABEL'), 'a.destination', $listDirn, $listOrder) ?>
				</th>

				<th class="nowrap left">
					<?php echo JHtml::_('grid.sort', JText::_('COM_FLIGHTS_FIELD_SEATS_LABEL'), 'a.seats', $listDirn, $listOrder) ?>
				</th>
				
				<th class="nowrap left">
					<?php echo JHtml::_('grid.sort', JText::_('COM_FLIGHTS_FIELD_DEPARTURE_LABEL'), 'a.departure', $listDirn, $listOrder) ?>
				</th>

				<th class="nowrap left">
					<?php echo JHtml::_('searchtools.sort', JText::_('COM_FLIGHTS_FLIGHTS_FIELD_ID_LABEL'), 'id', $listDirn, $listOrder) ?>
				</th>
			</tr>
		</thead>
				
		<tbody>
		
		<?php foreach ($this->items as $i => $item) :
		$canEdit	= $user->authorise('core.edit',       'com_flights.flights.'.$item->id);
		$canCheckin	= $user->authorise('core.manage',     'com_checkin');
		$canEditOwn	= $user->authorise('core.edit.own',   'com_flights.flights.'.$item->id);
		$canChange	= $user->authorise('core.edit.state', 'com_flights.flights.'.$item->id) && $canCheckin;
		?>
		
			<tr class="row<?php echo $i % 2; ?>">
				
				<!-- item checkbox -->
				<td class="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
				
				<!-- item state -->
				<?php if (isset($this->items[0]->published)): ?>
					<td class="center">
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'flights.', $canChange, 'cb'); ?>
					</td>
                <?php endif; ?>

                <td class="nowrap small hidden-phone">
                	<?php if ($canEdit || $canEditOwn) : ?>
							<a href="<?php echo JRoute::_('index.php?option=com_flights&task=flight.edit&id='.(int) $item->id); ?>">
							<?php echo $this->escape($item->origin); ?></a>
					<?php else : ?>
							<?php echo $this->escape($item->origin); ?>
					<?php endif; ?>

				</td>

				<td class="nowrap small hidden-phone">
					<?php echo $this->escape($item->destination);  ?>
				</td>
				
				<!-- item main field -->
				<td class="nowrap has-context">
					<?php echo $this->escape($item->seats); ?>
				</td>
				
				<td class="nowrap small hidden-phone">
					<?php echo JHtml::_('date', $item->departure, JText::_('DATE_FORMAT_LC4')); ?>
				</td>
				<td class="left"><?php echo $this->escape($item->id); ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>	
	</table>
	<?php endif; ?>
	<?php echo $this->pagination->getListFooter(); ?>
	
	
	<div>
		<input type="hidden" name="task" value=" " />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>

	</form>
</div>