<?php
/**
 * Copyright © Laurie Greysky All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Flipmediaco\TagServeTracking\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Store\Model\ScopeInterface::SCOPE_STORE
     */
    protected $_storeScope;

    /**
    * @var \Magento\Framework\App\Config\ScopeConfigInterface
    */
    protected $_scopeConfig;

    /**
    * @var \Magento\Framework\Stdlib\CookieManagerInterface
    */
	protected $_cookieManager;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    	\Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
    ) {
        $this->_storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $this->_scopeConfig = $scopeConfig;
        $this->_cookieManager = $cookieManager;

        parent::__construct($context);
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return ($this->_scopeConfig->getValue('tagserve/tagserve/enable', $this->_storeScope)) ? true : false;
    }

    /**
     * @return int
     */
    public function getMid()
    {
        return (int) $this->_scopeConfig->getValue('tagserve/tagserve/mid', $this->_storeScope);
    }

    /**
     * @return int
     */
    public function getPid()
    {
        return (int) $this->_scopeConfig->getValue('tagserve/tagserve/pid', $this->_storeScope);
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->_scopeConfig->getValue('currency/options/base', $this->_storeScope);
    }

    /**
     * @return string
     */
    public function getTagrid()
    {
        return ((int) $this->_cookieManager->getCookie('tagrid')) ? (int) $this->_cookieManager->getCookie('tagrid') : '';
    }
}