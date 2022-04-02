<?php
/*
 * @author     The S Group <support@sashas.org>
 * @copyright  2022  Sashas IT Support Inc. (https://www.sashas.org)
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

declare(strict_types=1);

namespace TheSGroup\NotFoundUrlLog\Block\Adminhtml\Log\Edit;

use Magento\UrlRewrite\Block\Edit\Form as OriginalForm;

/**
 * Class Form
 * Block function rewritten to change form submit url
 */
class Form extends OriginalForm
{
    /**
     * Form post init
     *
     * @param \Magento\Framework\Data\Form $form
     * @return \Magento\UrlRewrite\Block\Edit\Form
     */
    protected function _formPostInit($form)
    {
        $form->setAction(
            $this->_adminhtmlData->getUrl('*/*/save', ['id' => $this->_getModel()->getId()])
        );
        return $this;
    }
}
