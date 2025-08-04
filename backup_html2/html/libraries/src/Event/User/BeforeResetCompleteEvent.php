<?php

/**
 * Joomla! Content Management System
 *
 * @copyright  (C) 2024 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\CMS\Event\User;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Class for User reset event.
 * Example:
 *  new BeforeResetCompleteEvent('onEventName', ['subject' => $user]);
 *
 * @since  5.2.0
 */
class BeforeResetCompleteEvent extends AbstractResetEvent
{
}
