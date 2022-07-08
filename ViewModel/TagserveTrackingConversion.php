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
     * Conversion constructor.
     *
     */
    public function __construct(
        \Flipmediaco\TagServeTracking\Helper\Data $helper,
        \Magento\Sales\Model\Order $order
    ) {
        $this->_helper = $helper;
        $this->_order = $order;
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

        // If order id is false
        if (!$order->getId()) return ""; 

    	// Set no_items
    	$no_items = 0;
        //
        // Get Items from Order
        $items = $order->getAllVisibleItems();
        // 
        if (is_array($items)) {
            foreach ($items as $item) {
                $no_items = $no_items + $item->getQtyOrdered();
            }
        }
        // If no_items is false set to 1
        if (!$no_items) $no_items = 1;

        // Get order_amnt
        $order_amnt = $order->getGrandTotal();

        // Get mid
        $mid = $this->_helper->getMid();
        
        // Get pid
        $pid = $this->_helper->getMid();
        
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
        		'ORDERAMNT=' . $order_amnt . '&' . 
        		'NUMOFITEMS=' . $no_items . '&' . 
        		'CUR=' . $currency . '&' . 
        		'RID=' . $tagrid . '" style="display: none;">';
    }
}

