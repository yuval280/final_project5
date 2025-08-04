<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_installer
 *
 * @copyright   (C) 2008 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Installer\Administrator\View\Warnings;

use Joomla\Component\Installer\Administrator\Model\WarningsModel;
use Joomla\Component\Installer\Administrator\View\Installer\HtmlView as InstallerViewDefault;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Extension Manager Warning View
 *
 * @since  1.6
 */
class HtmlView extends InstallerViewDefault
{
    /**
     * Display the view
     *
     * @param   string  $tpl  Template
     *
     * @return  void
     *
     * @since   1.6
     */
    public function display($tpl = null)
    {
        /** @var WarningsModel $model */
        $model = $this->getModel();

        $this->messages = $model->getItems();

        if (!\count($this->messages)) {
            $this->setLayout('emptystate');
        }

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolbar()
    {
        $toolbar = $this->getDocument()->getToolbar();

        parent::addToolbar();

        $toolbar->help('Information:_Warnings');
    }
}
