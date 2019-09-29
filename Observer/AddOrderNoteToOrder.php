<?php

namespace Antonio88\OrderNote\Observer;

use Antonio88\OrderNote\Helper\OrderNoteHelper;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Antonio88\OrderNote\Model\Data\OrderNote;
use Psr\Log\LoggerInterface;

class AddOrderNoteToOrder implements ObserverInterface
{
    /**
     * @var OrderNoteHelper
     */
    private $orderNoteHelper;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * AddOrderNoteToOrder constructor.
     *
     * @param OrderNoteHelper $orderNoteHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        OrderNoteHelper $orderNoteHelper,
        LoggerInterface $logger
    ) {
        $this->orderNoteHelper = $orderNoteHelper;
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        try {
            /** @var $order \Magento\Sales\Model\Order * */
            $order = $observer->getEvent()->getOrder();
            /** @var $quote \Magento\Quote\Model\Quote * */
            $quote = $observer->getEvent()->getQuote();
            $orderNote = $quote->getData(OrderNote::ORDER_NOTE_FIELD_NAME);
            if ($orderNote === '') {
                $orderNote = $this->orderNoteHelper->resolveDefaultOrderNote();
            }
            $order->setData(OrderNote::ORDER_NOTE_FIELD_NAME, $orderNote);
        } catch (\Exception $e) {
            $this->logger->error('Error occured: ' . $e->getMessage());
        }
    }
}
