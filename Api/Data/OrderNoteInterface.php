<?php

namespace Antonio88\OrderNote\Api\Data;

/**
 * Interface OrderNoteInterface
 * @api
 */
interface OrderNoteInterface
{
    /**
     * @return string|null
     */
    public function getOrderNote();

    /**
     * @param string $orderNote
     *
     * @return mixed
     */
    public function setOrderNote(string $orderNote);
}
