<?php
namespace Flipmediaco\TagServeTracking\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Action;

use Flipmediaco\TagServeTracking\Helper\Data;

class UpgradeData implements UpgradeDataInterface
{
    /** @var EavSetupFactory  */
    private $eavSetupFactory;

    /** @var CollectionFactory  */
    private $collectionFactory;

    /** @var Action  */
    private $action;

    /**
     *
     * @param Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     * @param Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
     * @param Magento\Catalog\Model\ResourceModel\Product\Action $action
     * @param Data $helper
     */

     public function __construct(
        EavSetupFactory $eavSetupFactory,
        CollectionFactory $collectionFactory,
        Action $action,
        Data $helper
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->collectionFactory = $collectionFactory;
        $this->action = $action;
        $this->helper = $helper;
    }

    /**
     * Installs tag category attribute
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if ($context->getVersion() && version_compare($context->getVersion(), '2.0.0', '<=')) {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, $this->helper->tagCategoryAttributeName());

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                $this->helper->tagCategoryAttributeName(),
                [
                    'type' => 'varchar',
                    'backend' => '',
                    'frontend' => '',
                    'group' => 'Product Details',
                    'label' => 'TAG Category',
                    'input' => 'select',
                    'class' => '',
                    'source' => \Flipmediaco\TagServeTracking\Model\Config\Source\Options::class,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => true,
                    'default' => 'CAT1',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false,
                    'is_filterable_in_grid'=> false,
                    'unique' => false,
                    'apply_to' => 'simple',
                    'is_user_defined' => false
                ]
            );

            // Set delivery availability attribute to default value
            $productIds = $this->collectionFactory->create()->getAllIds();
            $this->action->updateAttributes($productIds, [$this->helper->tagCategoryAttributeName() => 'CAT1'], 0);
        }

        $setup->endSetup();
    }
}
