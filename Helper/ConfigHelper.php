<?php

namespace Antonio88\OrderNote\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigHelper
{
    /**
     *  Config Paths
     */
    private const XML_PATH_GENERAL_IS_SHOW_IN_MYACCOUNT = 'ordernote/general/is_show_in_myaccount';
    private const XML_PATH_GLOBAL_DEFAULT_ORDER_NOTE = 'config_order_note/general/default_order_note';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * ConfigHelper constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     *
     * @return bool
     */
    public function isShowOrderNoteInAccount(): bool
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_GENERAL_IS_SHOW_IN_MYACCOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     *
     * @return string
     */
    public function getGlobalDefaultOrderNote(): string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_GLOBAL_DEFAULT_ORDER_NOTE,
            ScopeInterface::SCOPE_STORE
        );
    }
}