<?php

namespace Antonio88\OrderNote\Api;

use Antonio88\OrderNote\Api\Data\OrderNoteInterface;

/**
 * Interface for saving the checkout order comment
 * to the quote for logged in users
 * @api
 */
interface GuestOrderNoteManagementInterface
{
    /**
     * @param              $cartId
     * @param OrderNoteInterface $orderNote
     *
     * @return mixed
     */
    public function saveOrderNote($cartId, OrderNoteInterface $orderNote);
}
