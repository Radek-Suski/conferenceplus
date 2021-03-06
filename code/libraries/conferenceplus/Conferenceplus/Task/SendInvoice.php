<?php
/**
 * Conferenceplus
 *
 * @package    Conferenceplus
 * @author     Robert Deutz <rdeutz@googlemail.com>
 *
 * @copyright  2014 JandBeyond
 * @license    GNU General Public License version 2 or later
 */

namespace Conferenceplus\Task;

/**
 * Class SendInvoice
 *
 * @package  Conferenceplus\Task
 * @since    0.0.1
 */
class SendInvoice extends BaseEmail
{
	/**
	 * run before the task is executed
	 *
	 * @param   mixed  $task  task data
	 *
	 * @return bool
	 */
	public function onBeforeDoProcess($task)
	{
		if ( ! array_key_exists('filename', $task->processdata))
		{
			return false;
		}

		$filename = $task->processdata['filename'];

		$name = 'Invoice' . '.pdf';

		if (array_key_exists('invoice_identifier', $task->processdata))
		{
			$name = $task->processdata['invoice_identifier'] . '.pdf';
		}

		$this->mailer->addAttachment($filename, $name);

		$ticket = $task->processdata['processdata']['ticket']['ticket'];

		$task->processdata['firstname'] = $ticket['firstname'];
		$task->processdata['lastname']  = $ticket['lastname'];

		$baseurl = rtrim($this->config['cpconf']->get('baseurl'), '/');

		$task->processdata['invoice_change_link'] = $baseurl . '/index.php?option=com_conferenceplus&view=invoice'
													. '&id=' . $task->processdata['invoice_id']
													. '&h=' . $task->processdata['invoice_hash'];

		return true;
	}
}
