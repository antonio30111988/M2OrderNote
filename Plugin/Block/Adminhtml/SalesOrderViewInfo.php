<?php
 
namespace Antonio88\OrderNote\Plugin\Block\Adminhtml;

use Antonio88\OrderNote\Model\Data\OrderNote;
use Magento\Sales\Block\Adminhtml\Order\View\Info as OrderViewInfo;

class SalesOrderViewInfo
{
    /**
     * @param OrderViewInfo $viewInfo
     * @param               $result
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterToHtml(OrderViewInfo $viewInfo, $result): string
    {
        $orderNoteBlock = $viewInfo->getLayout()
            ->createBlock('Antonio88\OrderNote\Block\Adminhtml\Order\View\Info')
            ->setTemplate('Antonio88_OrderNote::order/view/orderNotes.phtml');

        if ($orderNoteBlock !== false) {
            $orderNoteBlock->setOrderNote($viewInfo->getOrder()->getData(OrderNote::ORDER_NOTE_FIELD_NAME));
            $result = $result . $orderNoteBlock->toHtml();
        }
        return $result . $orderNoteBlock->toHtml();
    }
}
