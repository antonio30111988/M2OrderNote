<?php

namespace Antonio88\OrderNote\Model\Data;

use Antonio88\OrderNote\Api\Data\OrderNoteInterface;
use Antonio88\OrderNote\Helper\OrderNoteHelper;
use Magento\Framework\Api\AbstractSimpleObject;

class OrderNote extends AbstractSimpleObject implements OrderNoteInterface
{
    const ORDER_NOTE_FIELD_NAME = 'order_note';
    /**
     * @var OrderNoteHelper
     */
    private $orderNoteHelper;

    /***
     * OrderNote constructor.
     *
     * @param OrderNoteHelper $orderNoteHelper
     */
    public function __construct(OrderNoteHelper $orderNoteHelper)
    {
        $this->orderNoteHelper = $orderNoteHelper;
    }

    /**
     * @param string $orderNote
     * @return $this
     */
    public function setOrderNote(string $orderNote): self
    {
        return $this->setData(static::ORDER_NOTE_FIELD_NAME, $orderNote);
    }
    
    /**
     * @return string|null
     */
    public function getOrderNote(): ?string
    {
        $orderNote = $this->_get(static::ORDER_NOTE_FIELD_NAME);
        if($orderNote) {
            return $orderNote;
        }
        return $this->orderNoteHelper->resolveDefaultOrderNote();
    }
}
