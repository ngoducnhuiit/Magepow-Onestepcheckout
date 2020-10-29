<?php

namespace Magepow\OnestepCheckout\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetupFactory;

class InstallData implements InstallDataInterface
{
    protected $salesSetupFactory;


    public function __construct(SalesSetupFactory $salesSetupFactory)
    {
        $this->salesSetupFactory = $salesSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Sales\Setup\SalesSetup $salesInstaller */
        $salesInstaller = $this->salesSetupFactory->create(['resourceName' => 'sales_setup', 'setup' => $setup]);

        $setup->startSetup();

        $salesInstaller->addAttribute('order', 'onestepcheckout_order_comment', ['type' => Table::TYPE_TEXT]);

        $setup->endSetup();
    }
}
