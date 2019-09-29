<?php

namespace Antonio88\OrderNote\Model;

use Antonio88\OrderNote\Api\OrderNoteManagementInterface;
use Antonio88\OrderNote\Model\Data\OrderNote;
use Magento\Quote\Api\CartRepositoryInterface;
use Antonio88\OrderNote\Api\Data\OrderNoteInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

class OrderNoteManagement implements OrderNoteManagementInterface
{
    /**
     * @var CartRepositoryInterface
     */
    protected $cartQuoteRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * OrderNoteManagement constructor.
     *
     * @param CartRepositoryInterface $cartQuoteRepository
     */
    public function __construct(
        CartRepositoryInterface $cartQuoteRepository,
        LoggerInterface $logger
    ) {
        $this->cartQuoteRepository = $cartQuoteRepository;
        $this->logger = $logger;
    }

    /**
     * @param string             $cartId
     * @param OrderNoteInterface $orderNote
     *
     * @return OrderNoteInterface|mixed|null|string
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function saveOrderNote($cartId, OrderNoteInterface $orderNote)
    {
        $quote = $this->cartQuoteRepository->getActive($cartId);
        if (!$quote->getItemsCount()) {
              throw new NoSuchEntityException(
                  __('Cart %1 do not have products', $cartId)
              );
        }
        try {
            $orderNote = $orderNote->getOrderNote();
            $quote->setData(OrderNote::ORDER_NOTE_FIELD_NAME, strip_tags($orderNote));
            
            $this->cartQuoteRepository->save($quote);
        } catch (\Exception $e) {
               throw new CouldNotSaveException(
                   __('Cannot save the order note.')
               );
        }
        return $orderNote;
    }
}
