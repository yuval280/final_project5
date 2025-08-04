<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_finder
 *
 * @copyright   (C) 2011 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Finder\Administrator\View\Maps;

use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Button\DropdownButton;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\Component\Finder\Administrator\Helper\LanguageHelper;
use Joomla\Component\Finder\Administrator\Model\MapsModel;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Groups view class for Finder.
 *
 * @since  2.5
 */
class HtmlView extends BaseHtmlView
{
    /**
     * An array of items
     *
     * @var  array
     *
     * @since  3.6.1
     */
    protected $items;

    /**
     * The pagination object
     *
     * @var    \Joomla\CMS\Pagination\Pagination
     *
     * @since  3.6.1
     */
    protected $pagination;

    /**
     * The model state
     *
     * @var   \Joomla\Registry\Registry
     *
     * @since  3.6.1
     */
    protected $state;

    /**
     * The total number of items
     *
     * @var  integer
     *
     * @since  3.6.1
     */
    protected $total;

    /**
     * Form object for search filters
     *
     * @var    \Joomla\CMS\Form\Form
     *
     * @since  4.0.0
     */
    public $filterForm;

    /**
     * The active search filters
     *
     * @var    array
     *
     * @since  4.0.0
     */
    public $activeFilters;

    /**
     * @var   boolean
     *
     * @since 4.0.0
     */
    private $isEmptyState = false;

    /**
     * Method to display the view.
     *
     * @param   string  $tpl  A template file to load. [optional]
     *
     * @return  void
     *
     * @since   2.5
     */
    public function display($tpl = null)
    {
        // Load plugin language files.
        LanguageHelper::loadPluginLanguage();

        /** @var MapsModel $model */
        $model = $this->getModel();

        // Load the view data.
        $this->items         = $model->getItems();
        $this->total         = $model->getTotal();
        $this->pagination    = $model->getPagination();
        $this->state         = $model->getState();
        $this->filterForm    = $model->getFilterForm();
        $this->activeFilters = $model->getActiveFilters();

        if ($this->total === 0 && $this->isEmptyState = $model->getIsEmptyState()) {
            $this->setLayout('emptystate');
        }

        // Check for errors.
        if (\count($errors = $model->getErrors())) {
            throw new GenericDataException(implode("\n", $errors), 500);
        }

        // Prepare the view.
        $this->addToolbar();

        parent::display($tpl);
    }

    /**
     * Method to configure the toolbar for this view.
     *
     * @return  void
     *
     * @since   2.5
     */
    protected function addToolbar()
    {
        $canDo   = ContentHelper::getActions('com_finder');
        $toolbar = $this->getDocument()->getToolbar();

        ToolbarHelper::title(Text::_('COM_FINDER_MAPS_TOOLBAR_TITLE'), 'search-plus finder');

        if (!$this->isEmptyState) {
            if ($canDo->get('core.edit.state')) {
                /** @var DropdownButton $dropdown */
                $dropdown = $toolbar->dropdownButton('status-group', 'JTOOLBAR_CHANGE_STATUS')
                    ->toggleSplit(false)
                    ->icon('icon-ellipsis-h')
                    ->buttonClass('btn btn-action')
                    ->listCheck(true);

                $childBar = $dropdown->getChildToolbar();

                $childBar->publish('maps.publish')->listCheck(true);
                $childBar->unpublish('maps.unpublish')->listCheck(true);
            }

            if ($canDo->get('core.delete')) {
                $toolbar->standardButton('delete', 'JTOOLBAR_DELETE', 'maps.delete')
                    ->listCheck(true);
                $toolbar->divider();
            }

            $toolbar->divider();
            $toolbar->popupButton('bars', 'COM_FINDER_STATISTICS')
                ->popupType('iframe')
                ->textHeader(Text::_('COM_FINDER_STATISTICS_TITLE'))
                ->url('index.php?option=com_finder&view=statistics&tmpl=component')
                ->modalWidth('800px')
                ->modalHeight('500px')
                ->title(Text::_('COM_FINDER_STATISTICS_TITLE'))
                ->icon('icon-bars');
            $toolbar->divider();
        }

        if ($canDo->get('core.admin') || $canDo->get('core.options')) {
            $toolbar->preferences('com_finder');
        }

        $toolbar->help('Smart_Search:_Content_Maps');
    }
}
