<?php

use Omnipay\SipsPayPage\Message\CompletePurchaseRequest;
use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
    /**
     * @param \Omnipay\SipsPayPage\Message\AbstractRequest $request
     * @return \Omnipay\SipsPayPage\Message\AbstractRequest
     */
    public function injectParams(\Omnipay\SipsPayPage\Message\AbstractRequest $request)
    {
        $request->setMerchantId(SPP_MERCHANTID);
        $request->setSecretKey(SPP_SECRETKEY);
        $request->setUrl(SPP_URL);
        $request->setKeyVersion(1);
        $request->setInterfaceVersion('HP_2.9');

        return $request;
    }

    public function testSuccess()
    {
        $httpRequest = \Symfony\Component\HttpFoundation\Request::create(
            '/notify',
            'POST',
            array(
                'Seal' => '935b3e0f26e8727612eed9c44eea9da0243815880da7790690581b2bcc09bbe0',
                'Data' => 'merchantId=002001000000001|keyVersion=1|amount=1000|responseCode=00|transactionReference=534654|orderId=test_0001'
            )
        );

        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request = $this->injectParams($request);

        /** @var \Omnipay\SipsPayPage\Message\CompletePurchaseResponse $response */
        $response = $request->send();

        $this->assertEquals('935b3e0f26e8727612eed9c44eea9da0243815880da7790690581b2bcc09bbe0', $response->getSealFromData());
        $this->assertInstanceOf('Omnipay\SipsPayPage\Message\CompletePurchaseResponse', $response);

        $this->assertEquals('534654', $response->getTransactionReference());
        $this->assertEquals('test_0001', $response->getTransactionId());
        $this->assertFalse($response->isCancelled());
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
    }

    public function testError()
    {
        $httpRequest = \Symfony\Component\HttpFoundation\Request::create(
            '/notify',
            'POST',
            array(
                'Seal' => '53af98d64bfa54ec69482a25266f99879157992a6bfddea36001f9e265e0715a',
                'Data' => 'merchantId=002001000000001|keyVersion=1|amount=1000|responseCode=05'
            )
        );

        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request = $this->injectParams($request);

        /** @var \Omnipay\SipsPayPage\Message\CompletePurchaseResponse $response */
        $response = $request->send();

        $this->assertEquals('53af98d64bfa54ec69482a25266f99879157992a6bfddea36001f9e265e0715a', $response->getSealFromData());
        $this->assertInstanceOf('Omnipay\SipsPayPage\Message\CompletePurchaseResponse', $response);

        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
    }

    public function testPending()
    {
        $httpRequest = \Symfony\Component\HttpFoundation\Request::create(
            '/notify',
            'POST',
            array(
                'Seal' => '473842a12ba848279d6bff1840fa2886ba331f0032469e79eec01a7e20438d96',
                'Data' => 'merchantId=002001000000001|keyVersion=1|amount=1000|responseCode=60'
            )
        );

        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request = $this->injectParams($request);

        /** @var \Omnipay\SipsPayPage\Message\CompletePurchaseResponse $response */
        $response = $request->send();

        $this->assertEquals('473842a12ba848279d6bff1840fa2886ba331f0032469e79eec01a7e20438d96', $response->getSealFromData());
        $this->assertInstanceOf('Omnipay\SipsPayPage\Message\CompletePurchaseResponse', $response);

        $this->assertFalse($response->isCancelled());
        $this->assertTrue($response->isPending());
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }

    public function testCancelled()
    {
        $httpRequest = \Symfony\Component\HttpFoundation\Request::create(
            '/notify',
            'POST',
            array(
                'Seal' => '4d3ad10c4f53a08377389ca97893800c5b416eefa35c8760dd6a838c01a3ec83',
                'Data' => 'merchantId=002001000000001|keyVersion=1|amount=1000|responseCode=17'
            )
        );

        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request = $this->injectParams($request);

        /** @var \Omnipay\SipsPayPage\Message\CompletePurchaseResponse $response */
        $response = $request->send();

        $this->assertEquals('4d3ad10c4f53a08377389ca97893800c5b416eefa35c8760dd6a838c01a3ec83', $response->getSealFromData());
        $this->assertInstanceOf('Omnipay\SipsPayPage\Message\CompletePurchaseResponse', $response);

        $this->assertTrue($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }
}