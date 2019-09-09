<?php

namespace Antonio88\OrderNote\Block\Order;

use Antonio88\OrderNote\Helper\ConfigHelper;
use Antonio88\OrderNote\Helper\OrderNoteHelper;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Antonio88\OrderNote\Model\Data\OrderNote;
use Magento\Framework\Registry;

class Note extends Template
{
    /**
     * @var Registry
     */
    protected $coreRegistry = null;
    /**
     * @var Context
     */
    private $context;
    /**
     * @var ConfigHelper
     */
    private $configHelper;
    /**
     * @var OrderNoteHelper
     */
    private $orderNoteHelper;

    /**
     * @param    Context  $context
     * @param    Registry $registry
     * @param   array     $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        OrderNoteHelper $orderNoteHelper,
        ConfigHelper $configHelper,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->_isScopePrivate = true;
        $this->_template = 'order/view/orderNote.phtml';
        $this->context = $context;
        $this->configHelper = $configHelper;
        $this->orderNoteHelper = $orderNoteHelper;

        parent::__construct($context, $data);
    }

    /**
     *
     * @return string
     */
    public function getOrderNote(): string
    {
        $orderNote =  trim($this->getOrder()->getData(OrderNote::ORDER_NOTE_FIELD_NAME));
        if ($orderNote) {
            return $orderNote;
        }
        return  $this->orderNoteHelper->resolveDefaultOrderNote();
    }

    /**
     *
     * @return string
     */
    public function getOrderNoteHtml(): string
    {
        return nl2br($this->escapeHtml($this->getOrderNote()));
    }

    /**
     *
     * @return bool
     */
    public function hasOrderNote(): bool
    {
        return strlen($this->getOrderNote()) > 0;
    }

    /**
     * Get Order
     *
     * @return array|null
     */
    public function getOrder()
    {
        return $this->coreRegistry->registry('current_order');
    }

    /**
     *
     * @return bool
     */
    public function isShowOrderNoteInAccount(): bool
    {
        return $this->configHelper->isShowOrderNoteInAccount();
    }
}
