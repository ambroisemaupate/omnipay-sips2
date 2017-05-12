<?php

use Omnipay\SipsPayPage\Message\PurchaseRequest;
use Omnipay\SipsPayPage\OffsiteCreditCard;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    protected function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setMerchantId(SPP_MERCHANTID);
        $this->request->setSecretKey(SPP_SECRETKEY);
        $this->request->setUrl(SPP_URL);
        $this->request->setCurrency('EUR');
        $this->request->setAmount('10.00');
        $this->request->setReturnUrl('http://localhost/return');
        $this->request->setNotifyUrl('http://localhost/notify');
        $this->request->setDescription("Test description.");

        $this->request->setKeyVersion(1);
        $this->request->setInterfaceVersion('HP_2.9');

        $card = new OffsiteCreditCard();
        $card->setEmail('test@test.com');
        $this->request->setCard($card);
    }

    public function testSendSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseRedirect.txt');
        /** @var \Omnipay\SipsPayPage\Message\PurchaseResponse $response */
        $response = $this->request->send();

        $this->assertInstanceOf('Omnipay\SipsPayPage\Message\PurchaseResponse', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals(
            SPP_URL . '/paymentInit',
            $response->getRedirectUrl()
        );

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response->getRedirectResponse());

        $this->assertEquals($httpResponse->getBody(true), $response->getRedirectResponse()->getContent());
    }
}