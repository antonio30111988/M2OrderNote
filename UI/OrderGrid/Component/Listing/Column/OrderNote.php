<?php

namespace Antonio88\OrderNote\UI\OrderGrid\Component\Listing\Column;

use Magento\Sales\Api\Data\OrderInterface;
use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Api\SearchCriteriaBuilder;
use Psr\Log\LoggerInterface;

class OrderNote extends Column
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $_orderRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    protected $_searchCriteria;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $criteria,
        LoggerInterface $logger,
        array $components = [],
        array $data = []
    ) {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteria  = $criteria;
        $this->logger  = $logger;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                /** @var OrderInterface $order */
                $order  = $this->_orderRepository->get($item["entity_id"]);
                $orderNote = $order->getExtensionAttributes()->getOrderNote();

                $item[$this->getData('name')] = $orderNote;
            }
        }

        return $dataSource;
    }

}