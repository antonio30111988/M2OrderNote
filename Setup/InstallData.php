<?php
 
namespace Antonio88\OrderNote\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Sales\Setup\SalesSetupFactory;

class InstallData implements InstallDataInterface
{
    /**
     * @var QuoteSetupFactory
     */
    private $quoteSetupFactory;

    /**
     * @var SalesSetupFactory
     */
    private $salesSetupFactory;

    /**
     * InstallData constructor.
     *
     * @param SalesSetupFactory $salesSetupFactory
     * @param QuoteSetupFactory $quoteSetupFactory
     */
    public function __construct(SalesSetupFactory $salesSetupFactory, QuoteSetupFactory $quoteSetupFactory)
    {
        $this->salesSetupFactory = $salesSetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var \Magento\Quote\Setup\QuoteSetup $quoteInstaller */
        $quoteInstaller = $this->quoteSetupFactory->create([
            'resourceName' => 'quote_setup',
            'setup' => $setup
        ]);

        /** @var \Magento\Sales\Setup\SalesSetup $salesInstaller */
        $salesInstaller = $this->salesSetupFactory->create([
            'resourceName' => 'sales_setup',
            'setup' => $setup
        ]);
        
        $quoteInstaller->addAttribute(
            'quote',
            'order_note',
            [
              'type' => Table::TYPE_TEXT,
              'length' => '32k', 'nullable' => true
            ]
        );

        $salesInstaller->addAttribute(
            'order',
            'order_note',
            [
              'type' => Table::TYPE_TEXT,
              'length' => '32k', 'nullable' => true,
              'grid' => true
            ]
        );

        $setup->endSetup();
    }
}
