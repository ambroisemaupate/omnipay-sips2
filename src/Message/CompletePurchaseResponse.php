<?php

namespace Omnipay\SipsPayPage\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\SipsPayPage\Composer\ShaComposer;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @var string
     */
    protected $seal;

    /**
     * @var string
     */
    protected $composedData;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @inheritDoc
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        if (!isset($data['Seal'])) {
            throw new InvalidResponseException('Invalid response from gateway, Seal parameter is missing.');
        }
        if (!isset($data['Data'])) {
            throw new InvalidResponseException('Invalid response from gateway, Data parameter is missing.');
        }

        $this->seal = $data['Seal'];
        $this->composedData = $data['Data'];
        $this->fields = $this->decomposeData();
    }

    /**
     * Filter composedData parameters.
     *
     * @return array
     */
    protected function decomposeData()
    {
        $parameters = [];
        $dataParams = explode('|', $this->composedData);
        foreach ($dataParams as $dataParamString) {
            $dataKeyValue = explode('=', $dataParamString, 2);
            if (count($dataKeyValue) === 2) {
                $parameters[$dataKeyValue[0]] = $dataKeyValue[1];
            }
        }

        return $parameters;
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return $this->isValid() && $this->getCode() === '00';
    }

    /**
     * @inheritDoc
     */
    public function isPending()
    {
        return $this->isValid() && $this->getCode() === '60';
    }

    /**
     * @inheritDoc
     */
    public function isCancelled()
    {
        return $this->isValid() && $this->getCode() === '17';
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if (!$this->request instanceof CompletePurchaseRequest) {
            return false;
        }

        if ($this->seal !== $this->getSealFromData()) {
            return false;
        }

        if ($this->request->getMerchantId() !== $this->fields['merchantId']) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getSealFromData()
    {
        $shaComposer = new ShaComposer($this->request->getSecretKey());
        return $shaComposer->compose($this->fields);
    }

    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return $this->fields['responseCode'];
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        if (!$this->isValid()) {
            return 'Request is not valid.';
        }

        switch ($this->getCode()) {
            case '00':
                return 'Authorization accepted.';
            case '02':
                return 'Over the phone authorization requested.';
            case '03':
                return 'Invalid merchant contract.';
            case '05':
                return 'Authorization refused.';
            case '11':
                return 'Stolen credit card.';
            case '12':
                return 'Invalid transaction. Verify your request parameters.';
            case '14':
                return 'Invalid payment mean.';
            case '17':
                return 'Transaction cancelled by customer.';
            case '24':
                return 'Impossible to fulfill transaction.';
            case '25':
                return 'Unable to find transaction in bank database.';
            case '30':
                return 'Invalid format.';
            case '34':
                return 'Fraud attempt.';
            case '40':
                return 'Unsupported method.';
            case '51':
                return 'Amount is too high.';
            case '54':
                return 'Payment mean has expired.';
            case '60':
                return 'Authorization is pending.';
            case '63':
                return 'Security policy not validated, transaction is stopped.';
            case '75':
                return 'Too many attempts';
            case '90':
                return 'Service temporarily unavailable.';
            case '94':
                return 'Transaction already exists.';
            case '97':
                return 'Request has expired. Transaction refused';
            case '99':
                return 'Service temporarily unavailable.';
            default:
                return 'Unknown response code.';
        }
    }

    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        return $this->fields['transactionReference'];
    }

    /**
     * Get the transaction ID as generated by the merchant website.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->fields['orderId'];
    }
}
