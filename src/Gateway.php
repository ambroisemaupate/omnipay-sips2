<?php

namespace Omnipay\SipsPayPage;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    /**
     * @inheritdoc
     */
    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'interfaceVersion' => 'HP_2.9',
            'keyVersion' => 1,
            'secretKey' => '',
            'sipsPaymentInitUrl' => 'https://payment-webinit.simu.sips-atos.com/paymentInit',
        );
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'SipsPayPage';
    }

    /**
     * Creates a request with Sips request binary,
     * creating HTML code containing secured links to the gateway
     * The request contains the amount,not modifiable after,
     * therefore the purchase action combines authorization and capture
     *
     * @param array $options
     * @return \Omnipay\Common\Message\RequestInterface
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\SipsPayPage\Message\PurchaseRequest', $options);
    }

    /**
     * Handles a response from the payment gateway
     * Usually a notification a success, a cancellation or
     * the user coming back
     *
     * @param array $options
     * @return \Omnipay\Common\Message\RequestInterface
     */
    public function completePurchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\SipsPayPage\Message\CompletePurchaseRequest', $options);
    }
}