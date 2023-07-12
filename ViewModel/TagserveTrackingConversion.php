<?php
/**
 * Copyright © Laurie Greysky All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Flipmediaco\TagServeTracking\ViewModel;

class TagserveTrackingConversion extends \Magento\Framework\DataObject implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
    * @var \Flipmediaco\TagServeTracking\Helper\Data
    */
    protected $_helper;
	
    /**
    * @var \Magento\Sales\Model\Order
    */
	protected $_order;

    /**
    * @var \Magento\Catalog\Model\ProductFactory
    */
    protected $_productFactory;

    /**
     * Conversion constructor.
     *
     */
    public function __construct(
        \Flipmediaco\TagServeTracking\Helper\Data $helper,
        \Magento\Sales\Model\Order $order,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        $this->_helper = $helper;
        $this->_order = $order;
        $this->_productFactory = $productFactory;
        parent::__construct();
    }

    /**
     * Deploy tagserver tracking
     *
     * @param integer $order_id
     *
     * @return string
     */
    public function trackSale($order_id) {
        // If isEnable is false
        if (!$this->_helper->isEnabled()) return ""; 

        // If order_id is false
        if (!$order_id) return ""; 
        
    	// Load order from order_id
    	$order = $this->_order->loadByIncrementId( $order_id );

        // If order id is false or tagrid is false
        if (!$order->getId() || !$this->_helper->getTagrid()) return ""; 

    	// Set category_products
    	$category_products = '';
        //
        // Get Items from Order
        $items = $order->getAllItems();
        // 
        if (is_array($items)) {
            foreach ($items as $item) {
                // If row has a value
                if ($item->getRowTotalInclTax()) {
                    // Get product tag category 
                    $product = $this->_productFactory->create()->load($item->getProductId());
                    $tag_cat = $product->getData($this->_helper->tagCategoryAttributeName());
                    if (!$tag_cat) $tag_cat = 'CAT1';
                    // 
                    $category_products .=   'CAT=' . 
                                            $tag_cat . ',' . 
                                            $item->getQtyOrdered() . ',' . 
                                            $item->getRowTotalInclTax() . '&';
                }
            }
        }
        // If category_products is empty
        if ($category_products == '') return ''; 

        // Get mid
        $mid = $this->_helper->getMid();
        
        // Get pid
        $pid = $this->_helper->getPid();
        
        // Get currency
        $currency = $this->_helper->getCurrency();

        // Get tagrid
        $tagrid = $this->_helper->getTagrid();

        // Return Tracking pixel
        return	'<img src="https://www.tagserve.com/saleServlet?' . 
                'MID=' . $mid . '&' . 
                'PID=' . $pid . '&' . 
                'CRID=&' . 
                'ORDERID=' . $order_id . '&' . 
                'CUR=' . $currency . '&' . 
                'RID=' . $tagrid . '&' . 
                substr($category_products,0,-1) . 
                '" style="display: none;">' . 
                $this->_helper->clearTagrid();
    }
}

