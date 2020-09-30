<?php

namespace CodeCustom\StaticPayment\Model;

use CodeCustom\StaticPayment\Helper\Config;
use Magento\Payment\Model\InfoInterface;
use Magento\Payment\Model\Method\AbstractMethod;
use Magento\Quote\Api\Data\CartInterface;

class Cash extends AbstractMethod
{
    const METHOD_CODE = 'gdwncash_payment';
    protected $_code = self::METHOD_CODE;

    protected $_canCapture = true;
    protected $_canVoid = true;
    protected $_canUseForMultishipping = false;
    protected $_canUseInternal = true;
    protected $_isInitializeNeeded = true;
    protected $_isGateway = true;
    protected $_canAuthorize = false;
    protected $_canCapturePartial = false;
    protected $_canRefund = false;
    protected $_canRefundInvoicePartial = false;
    protected $_canUseCheckout = true;

    protected $_minOrderTotal = 0;

    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';
    const CURRENCY_UAH = 'UAH';
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_RUR = 'RUR';

    protected $_supportedCurrencyCodes = array(
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
        self::CURRENCY_UAH,
        self::CURRENCY_RUB,
        self::CURRENCY_RUR,
    );

    protected $paymentHelper;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Framework\UrlInterface $urlBuider,
        array $data = array(),
        Config $paymentHelper
    )
    {
        $this->paymentHelper = $paymentHelper;
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            null,
            null,
            $data
        );
    }

    /**
     * @param string $currencyCode
     * @return bool
     */
    public function canUseForCurrency($currencyCode)
    {
        if (!in_array($currencyCode, $this->_supportedCurrencyCodes)) {
            return false;
        }
        return true;
    }

    /**
     * @param InfoInterface $payment
     * @param float $amount
     * @return $this|BankTransfer
     */
    public function capture(InfoInterface $payment, $amount)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $payment->getOrder();
        $billing = $order->getBillingAddress();
        try {
            $payment->setTransactionId('pay-' . $order->getId())->setIsTransactionClosed(0);
            return $this;
        } catch (\Exception $e) {
            $this->debugData(['exception' => $e->getMessage()]);
            throw new \Exception(__('Payment capturing error.'));
        }
    }

    /**
     * @param CartInterface|null $quote
     * @return bool
     */
    public function isAvailable(CartInterface $quote = null)
    {
        if (!$this->paymentHelper->isEnabled(self::METHOD_CODE)) {
            return false;
        }
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        $allowedCarriers = $this->paymentHelper->getAllowedCarriers(self::METHOD_CODE);
        $allowedShippingMethods = $allowedCarriers ? explode(',', $allowedCarriers) : null;
        if (!$allowedShippingMethods || !in_array($shippingMethod, $allowedShippingMethods)) {
            return false;
        }
        return parent::isAvailable($quote);
    }
}
