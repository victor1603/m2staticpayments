<?php

namespace CodeCustom\StaticPayment\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config extends AbstractHelper
{

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Config constructor.
     * @param Context $context
     * @param StoreManagerInterface $_storeManager
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $_storeManager
    )
    {
        $this->storeManager = $_storeManager;
        parent::__construct($context);
    }

    /**
     * @return int|null
     */
    public function getSiteStoreId()
    {
        try {
            $storeId = $this->storeManager->getStore()->getId();
            return $storeId;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param null $carrierCode
     * @param null $field
     * @param null $storeId
     * @return false|mixed
     */
    public function getConfigData($paymentCode = null, $field = null, $storeId = null)
    {
        if (empty($paymentCode)) {
            return false;
        }
        $path = 'payment/' . $paymentCode . '/' . $field;
        $storeId = $storeId ? $storeId : $this->getSiteStoreId();
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $paymentCode
     * @return false|mixed
     */
    public function isEnabled($paymentCode = null)
    {
        if (empty($paymentCode)) {
            return false;
        }

        return $this->getConfigData($paymentCode, 'active');
    }

    /**
     * @param null $paymentCode
     * @return false|mixed
     */
    public function getTitle($paymentCode = null)
    {
        if (empty($paymentCode)) {
            return false;
        }

        return $this->getConfigData($paymentCode, 'title');
    }

    /**
     * @param null $paymentCode
     * @return false|mixed
     */
    public function getAllowedCarriers($paymentCode = null)
    {
        if (empty($paymentCode)) {
            return false;
        }

        return $this->getConfigData($paymentCode, 'allowed_carrier');
    }

}
