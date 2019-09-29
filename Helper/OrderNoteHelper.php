<?php

namespace Antonio88\OrderNote\Helper;

use Antonio88\OrderNote\Model\Data\OrderNote;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;

class OrderNoteHelper extends ConfigHelper
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var Registry
     */
    protected $coreRegistry = null;
    /**
     * @var Session
     */
    private $_customerSession;

    /**
     * OrderNoteHelper constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param SessionFactory       $customerSessionFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SessionFactory $customerSessionFactory
    ) {
        $this->_customerSession = $customerSessionFactory->create();
        parent::__construct($scopeConfig);
    }

    /**
     * @return null|string
     */
    public function resolveDefaultOrderNote(): ?string
    {
        $customer = $this->getCustomerData();
        if ($customer) {
            if ($customer->getCustomAttribute(OrderNote::ORDER_NOTE_FIELD_NAME)) {
                return trim($customer->getCustomAttribute(OrderNote::ORDER_NOTE_FIELD_NAME)->getValue());
            }
            return $this->getGlobalDefaultOrderNote();
        }
        return $this->getGlobalDefaultOrderNote();
    }

    /**
     * @return bool|\Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCustomerData()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return $this->_customerSession->getCustomerData();
        }
        return false;
    }
}