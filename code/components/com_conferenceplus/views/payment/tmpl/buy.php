<?php
/**
 * Conferenceplus
 *
 * @package    Conferenceplus
 * @author     Robert Deutz <rdeutz@googlemail.com>
 *
 * @copyright  2014 JandBeyond
 * @license    GNU General Public License version 2 or later
 **/

// No direct access
defined('_JEXEC') or die;

$displayData 	= new stdClass;
$params 		= JComponentHelper::getParams('COM_CONFERENCEPLUS');
$headerlevel    = $params->get('headerlevel', 2);
$baseLayoutPath = JPATH_ROOT . '/media/conferenceplus/layouts';

$title = JText::_('COM_CONFERENCEPLUS_BUY_TITLE');
$doc = JFactory::getDocument()->setTitle($title);

// $title = JLayoutHelper::render('html.title', $displayData, $baseLayoutPath);
$Itemid = Conferenceplus\Route\Helper::getItemid('');

$tickettype = $this->item->ticketData->tickettype;
$ticket     = $this->item->ticketData->ticket;
$currency   = explode('|', $params->get('currency'))[0];

if (0)
{
	echo "#<div style='text-align:left;font_size:1.2em;'><pre>";
	print_r($this);
	echo "</pre></div>#";
}

$processdata = json_decode($ticket->processdata, true);

$edit = JUri::base() . 'index.php?option=com_conferenceplus&view=ticket&task=edit&id=' . $ticket->conferenceplus_ticket_id
	                 . '&Itemid=' . $Itemid;

?>

<!-- ************************** START: conferenceplus ************************** -->
<div class="conferenceplus item">

	<h<?php echo $headerlevel; ?>><?php echo $title; ?></h<?php echo $headerlevel; ?>>

	<?php echo JText::_('COM_CONFERENCEPLUS_BUY_PRETEXT');?>
	
	<div class="selectedticket">
		<?php echo JText::_('COM_CONFERENCEPLUS_BUY_TICKET_YOURSELECTION');?>
		<dl>
			<dt><?php echo JText::_('COM_CONFERENCEPLUS_TICKETTYPENAME');?></dt>
			<dd><?php echo $tickettype->name;?></dd>
			<dt><?php echo JText::_('COM_CONFERENCEPLUS_TICKETTYPEDESCRIPTION');?></dt>
			<dd><?php echo $tickettype->description;?></dd>
			<dt><?php echo JText::_('COM_CONFERENCEPLUS_TICKETTYPEFEE');?></dt>
			<dd><?php echo $currency; ?> <?php echo number_format($tickettype->fee/100, 0, ',', '');?></dd>
			<dt><?php echo JText::_('COM_CONFERENCEPLUS_FIRSTNAME');?></dt>
			<dd><?php echo $ticket->firstname;?></dd>
			<dt><?php echo JText::_('COM_CONFERENCEPLUS_LASTNAME');?></dt>
			<dd><?php echo $ticket->lastname;?></dd>
			<dt><?php echo JText::_('COM_CONFERENCEPLUS_EMAIL');?></dt>
			<dd><?php echo $ticket->email;?></dd>

			<?php $fields = ['ask4gender', 'ask4tshirtsize', 'ask4food', 'ask4food0']; ?>

			<?php foreach ($fields as $field) : ?>
				<?php if (array_key_exists($field, $processdata) && !empty($processdata[$field])) :?>
					<dt><?php echo JText::_('COM_CONFERENCEPLUS_' . strtoupper($field));?></dt>
					<dd><?php echo JText::_($processdata[$field]);?></dd>
				<?php endif; ?>
			<?php endforeach; ?>
		</dl>
	</div>
	<?php echo JText::_('COM_CONFERENCEPLUS_PAYMENTPROVIDERS'); ?>
	<div class="paymentproviders">
		<?php foreach ($this->item->paymentProviders as $provider) :?>
			<?php echo $provider; ?>
		<?php endforeach; ?>
	</div>

	<?php if (0) : ?>
	<a href="<?php echo $edit; ?>">Edit</a>
	<?php endif; ?>

</div>
<!-- ************************** END: conferenceplus ************************** -->