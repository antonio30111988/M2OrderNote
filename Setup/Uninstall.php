<?php

namespace Antonio88\OrderNote\Setup;

use Antonio88\OrderNote\Model\Data\OrderNote;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Uninstall implements UninstallInterface
{
    protected $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->dropColumn($setup->getTable('sales_order'), OrderNote::ORDER_NOTE_FIELD_NAME);
        $setup->getConnection()->dropColumn($setup->getTable('sales_order_grid'), OrderNote::ORDER_NOTE_FIELD_NAME);
        $setup->getConnection()->dropColumn($setup->getTable('quote'), OrderNote::ORDER_NOTE_FIELD_NAME);
        $this->removeCustomerOrderNoteEavAttribute();

        $setup->endSetup();
    }

    private function removeCustomerOrderNoteEavAttribute()
    {
        $eavSetup = $this->eavSetupFactory->create();
        $entityTypeId = 1; // Customer entity ID
        $eavSetup->removeAttribute($entityTypeId, 'order_note');
    }
}
