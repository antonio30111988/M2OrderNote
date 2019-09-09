<?php
 
namespace Antonio88\OrderNote\Setup;

use Magento\Customer\Model\Customer;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Config;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig       = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     *
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.0', '<')) {
            $setup->startSetup();

            $setup->endSetup();
        }

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $setup->startSetup();

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                Customer::ENTITY,
                'order_note',
                [
                    'type'         => 'text',
                    'label'        => 'Default Order note Attribute',
                    'input'        => 'textarea',
                    'is_wysiwyg_enabled' => 1,
                    'required'     => false,
                    'visible'      => true,
                    'user_defined' => true,
                    'position'     => 999,
                    'system'       => 0,
                ]
            );
            $orderNote = $this->eavConfig->getAttribute(Customer::ENTITY, 'order_note');

            $orderNote
                ->setData('attribute_set_id', $attributeSetId)
                ->setData('attribute_group_id', $attributeGroupId)
                ->setData(
                'used_in_forms',
                [
                    'adminhtml_customer',
                    'customer_account_edit'
                ]
            );

            $orderNote->save();

            $setup->endSetup();
        }
    }
}
