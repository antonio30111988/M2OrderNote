<?php

namespace Antonio88\OrderNote\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Psr\Log\LoggerInterface;

class OrderRepositoryPlugin
{
    /**
     * @var OrderExtensionFactory
     */
    protected $orderExtensionFactory;
    /**
     * @var OrderFactory
     */
    protected $orderFactory;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        OrderExtensionFactory $orderExtensionFactory,
        OrderFactory $orderFactory,
        LoggerInterface $logger
    ) {
        $this->orderFactory = $orderFactory;
        $this->orderExtensionFactory = $orderExtensionFactory;
        $this->logger = $logger;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface           $resultOrder
     *
     * @return OrderInterface
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface $resultOrder
    ): OrderInterface {

        return $this->getOrderNote($resultOrder);
    }

    /**
     * @param OrderInterface               $order
     * @param OrderExtensionInterface|null $extension
     *
     * @return OrderExtensionInterface
     */
    public function afterGetExtensionAttributes(
        OrderInterface $order,
        OrderExtensionInterface $extension = null
    ): OrderExtensionInterface {
        if ($extension === null) {
            $extension = $this->orderExtensionFactory->create();
        }

        return $extension;
    }

    /**
     * @param OrderInterface        $order
     *
     * @return OrderInterface
     */
    private function getOrderNote(OrderInterface $order): OrderInterface {

        $extensionAttributes = $order->getExtensionAttributes();
        if (empty($extensionAttributes)) {
            $extensionAttributes = $this->orderExtensionFactory->create();
        }
        $orderModel = $this->orderFactory->create()->load($order->getEntityId());
        $orderNote = $orderModel->getData('order_note');

        $extensionAttributes->setOrderNote($orderNote);
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }
}