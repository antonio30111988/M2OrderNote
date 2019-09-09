<?php
 
namespace Antonio88\OrderNote\Model;

use Magento\Quote\Model\QuoteIdMaskFactory;
use Antonio88\OrderNote\Api\OrderNoteManagementInterface;
use Antonio88\OrderNote\Api\Data\OrderNoteInterface;
use Antonio88\OrderNote\Api\GuestOrderNoteManagementInterface;

class GuestOrderNoteManagement implements GuestOrderNoteManagementInterface
{
    /**
     * @var OrderNoteManagementInterface
     */
    private $orderNoteManagement;

    /**
     * @var QuoteIdMaskFactory
     */
    private $quoteIdMaskFactory;

    /**
     * GuestOrderNoteManagement constructor.
     *
     * @param QuoteIdMaskFactory           $quoteIdMaskFactory
     * @param OrderNoteManagementInterface $orderNoteManagement
     */
    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        OrderNoteManagementInterface $orderNoteManagement
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->orderNoteManagement = $orderNoteManagement;
    }

    /**
     * @param              $cartId
     * @param OrderNoteInterface $orderNote
     *
     * @return mixed
     */
    public function saveOrderNote($cartId, OrderNoteInterface $orderNote)
    {
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        return $this->orderNoteManagement->saveOrderNote($quoteIdMask->getQuoteId(), $orderNote);
    }
}
