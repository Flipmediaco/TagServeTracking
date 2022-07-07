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
    * @var \Magento\Framework\App\Config\ScopeConfigInterface
    */
    protected $_scopeConfig;

    /**
    * @var \Magento\Framework\Stdlib\CookieManagerInterface
    */
	protected $_cookieManager;
	
    /**
    * @var \Magento\Sales\Model\Order
    */
	protected $_order;

    /**
     * Conversion constructor.
     *
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    	\Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Sales\Model\Order $order
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_cookieManager = $cookieManager;
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
    public function trackSale( $order_id ) {
        // GET storeScope
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        
    	// Load order
    	$order = $this->_order->loadByIncrementId($order_id);
    
    	// GET no_items
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
    	
        // GET MID
        $mid = (int) $this->_scopeConfig->getValue('tagserve/tagserve/mid', $storeScope);
        
        // GET PID
        $pid = (int) $this->_scopeConfig->getValue('tagserve/tagserve/pid', $storeScope);
        
        // GET currency
        $currency = $this->_scopeConfig->getValue('currency/options/base', $storeScope);
        
        // GET TagRid
        $tagrid = ((int) $this->_cookieManager->getCookie('tagrid')) ? (int) $this->_cookieManager->getCookie('tagrid') : '';
        
        // Resturn Tracking pixel
        return	'<img src="https://www.tagserve.com/saleServlet?' . 
        		'MID=' . $mid . '&' . 
        		'PID=' . $pid . '&' . 
        		'CRID=&' . 
        		'ORDERID=' . $order_id . '&' . 
        		'ORDERAMNT=' . $order->getGrandTotal() . '&' . 
        		'NUMOFITEMS=' . $no_items . '&' . 
        		'CUR=' . $currency . '&' . 
        		'RID=' . $tagrid . '" style="display: none;">';
    }
}

