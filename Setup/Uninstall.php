<?php
namespace Flipmediaco\TagServeTracking\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;
use Flipmediaco\TagServeTracking\Helper\Data;

class Uninstall implements UninstallInterface
{
    private $eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Data $helper)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->helper = $helper;
    }

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create();

        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, $this->helper->tagCategoryAttributeName());

        $setup->endSetup();
    }
}