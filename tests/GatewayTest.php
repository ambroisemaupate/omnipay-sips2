<?php

use Omnipay\Omnipay;
use Omnipay\SipsPayPage\OffsiteCreditCard;
use Omnipay\Tests\GatewayTestCase;

define('SPP_MERCHANTID', '002001000000001');
define('SPP_SECRETKEY', '002001000000001_KEY1');
define('SPP_URL', 'https://payment-webinit.simu.sips-atos.com');

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    protected $gateway;

    protected function setUp()
    {
        parent::setUp();
        $this->gateway = Omnipay::create('SipsPayPage');
        $this->gateway->initialize(array(
            'merchantId' => SPP_MERCHANTID,
            'secretKey' => SPP_SECRETKEY,
            'url' => SPP_URL,
            'testMode' => true,
            'interfaceVersion' => 'HP_2.14',
            'keyVersion' => 1,
        ));
    }

    public function testPurchase()
    {
        $card = new OffsiteCreditCard();
        $card->setEmail('test@test.com');

        $request = $this->gateway->purchase(array(
            'amount' => '10.00',
            'currency' => 'EUR',
            'description' => 'Description field',
            'language' => 'fr',
            'returnUrl' => 'http://localhost/return',
            'notifyUrl' => 'http://localhost/notify',
            'card' => $card,
        ));
        $this->assertInstanceOf( 'Omnipay\SipsPayPage\Message\PurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('http://localhost/return', $request->getReturnUrl());
        $this->assertSame('http://localhost/notify', $request->getNotifyUrl());
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase();
        $this->assertInstanceOf( 'Omnipay\SipsPayPage\Message\CompletePurchaseRequest', $request);
    }
}