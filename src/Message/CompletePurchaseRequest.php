<?php

namespace Omnipay\SipsPayPage\Message;

class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        return $this->httpRequest->request->all();
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        return new CompletePurchaseResponse($this, $data);
    }
}