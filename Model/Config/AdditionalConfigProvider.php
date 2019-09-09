<?php

namespace Antonio88\OrderNote\Model\Config;

use Antonio88\OrderNote\Helper\OrderNoteHelper;

class AdditionalConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{
    /**
     * @var OrderNoteHelper
     */
    private $orderNoteHelper;

    /**
     * AdditionalConfigProvider constructor.
     *
     * @param OrderNoteHelper $orderNoteHelper
     */
    public function __construct(OrderNoteHelper $orderNoteHelper)
    {
        $this->orderNoteHelper = $orderNoteHelper;
    }

    /**
     * @return array|mixed
     */
    public function getConfig()
    {
        $output['defaultOrderNote'] = $this->orderNoteHelper->resolveDefaultOrderNote();
        return $output;
    }
}