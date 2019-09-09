<?php

namespace Antonio88\OrderNote\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class DefaultSelectionOrderNote implements ArrayInterface
{
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function toOptionArray()
    {
        return [
            ['value' => __('Leave at the doorstep'), 'label' => __('Leave at the doorstep')],
            ['value' =>  __('Leave in the backyard'), 'label' => __('Leave in the backyard')],
            ['value' =>  __('Ring Longer'), 'label' => __('Ring Longer')]
        ];
    }
}