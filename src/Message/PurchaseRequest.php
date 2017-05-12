<?php

namespace Omnipay\SipsPayPage\Message;

use Omnipay\SipsPayPage\Composer\ShaComposer;
use Omnipay\SipsPayPage\Composer\ParameterComposer;

class PurchaseRequest extends AbstractRequest
{
    protected static $currencies = array(
        'EUR' => '978', 'USD' => '840', 'CHF' => '756', 'GBP' => '826',
        'CAD' => '124', 'JPY' => '392', 'MXP' => '484', 'TRY' => '949',
        'AUD' => '036', 'NZD' => '554', 'NOK' => '578', 'BRC' => '986',
        'ARP' => '032', 'KHR' => '116', 'TWD' => '901', 'SEK' => '752',
        'DKK' => '208', 'KRW' => '410', 'SGD' => '702', 'XPF' => '953',
        'XOF' => '952'
    );

    protected $sipsFields = array(
        'currencyCode', 'merchantId', 'normalReturnUrl',
        'transactionReference', 'keyVersion', 'paymentMeanBrand', 'customerLanguage',
        'billingAddress.city', 'billingAddress.company', 'billingAddress.country',
        'billingAddress', 'billingAddress.postBox', 'billingAddress.state',
        'billingAddress.street', 'billingAddress.streetNumber', 'billingAddress.zipCode',
        'billingContact.email', 'billingContact.firstname', 'billingContact.gender',
        'billingContact.lastname', 'billingContact.mobile', 'billingContact.phone',
        'customerAddress', 'customerAddress.city', 'customerAddress.company',
        'customerAddress.country', 'customerAddress.postBox', 'customerAddress.state',
        'customerAddress.street', 'customerAddress.streetNumber', 'customerAddress.zipCode',
        'customerContact', 'customerContact.email', 'customerContact.firstname',
        'customerContact.gender', 'customerContact.lastname', 'customerContact.mobile',
        'customerContact.phone', 'customerContact.title', 'expirationDate', 'automaticResponseUrl',
        'templateName', 'paymentMeanBrandList', 'orderId'
    );

    public static function getCurrencies()
    {
        return static::$currencies;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate(
            'amount',
            'currencyCode',
            'merchantId',
            'returnUrl',
            'keyVersion',
            'interfaceVersion',
            'card',
            'secretKey'
        );

        $data = [];

        foreach ($this->sipsFields as $fieldName) {
            if ($this->parameters->has($fieldName)) {
                $data[$fieldName] = $this->parameters->get($fieldName);
            }
        }

        $data = array_merge($data, $this->extractCardParameters(), [
            'normalReturnUrl' => $this->getReturnUrl(),
            'automaticResponseUrl' => $this->getNotifyUrl(),
            'orderId' => $this->getTransactionId(),
            'amount' => $this->getAmountInteger(),
        ]);

        return array_filter($data);
    }

    /**
     * @return array
     */
    protected function extractCardParameters()
    {
        $card = $this->getCard();

        $fields = [
            //customer contact
            'customerContact.email' => $card->getEmail(),
            'customerContact.firstname' => $card->getFirstName(),
            'customerContact.lastname' => $card->getLastName(),
            'customerContact.phone' => $card->getPhone(),
            'customerContact.gender' => $card->getGender(),
            'customerContact.title' => $card->getTitle(),
            // customer address
            'customerAddress.city' => $card->getCity(),
            'customerAddress.company' => $card->getCompany(),
            'customerAddress.country' => $card->getCountry(),
            'customerAddress.state' => $card->getState(),
            'customerAddress.addressAdditional1' => $card->getAddress1(),
            'customerAddress.addressAdditional2' => $card->getAddress2(),
            'customerAddress.zipCode' => $card->getPostcode(),
            // customer data
            'customerData.birthDate' => $card->getBirthday(),
            // billing contact
            'billingContact.firstname' => $card->getBillingFirstName(),
            'billingContact.lastname' => $card->getBillingLastName(),
            'billingContact.phone' => $card->getBillingPhone(),
            'billingContact.title' => $card->getBillingTitle(),
            // billing address
            'billingContact.email' => $card->getEmail(),
            'billingContact.city' => $card->getBillingCity(),
            'billingContact.company' => $card->getBillingCompany(),
            'billingContact.country' => $card->getBillingCountry(),
            'billingContact.state' => $card->getBillingState(),
            'billingContact.addressAdditional1' => $card->getBillingAddress1(),
            'billingContact.addressAdditional2' => $card->getBillingAddress2(),
            'billingContact.zipCode' => $card->getBillingPostcode(),
        ];

        return array_filter($fields);
    }

    /**
     * @inheritDoc
     */
    public function setCurrency($value)
    {
        parent::setCurrency($value);

        if (!isset(static::$currencies[$value])) {
            throw new \InvalidArgumentException('Currency is not supported.');
        }

        return $this->setParameter('currencyCode', static::$currencies[$value]);
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $shaComposer = new ShaComposer($this->getParameter('secretKey'));
        $parameterComposer = new ParameterComposer();

        return new PurchaseResponse($this, [
            'Data' => $parameterComposer->compose($data),
            'InterfaceVersion' => $this->getParameter('interfaceVersion'),
            'Seal' => $shaComposer->compose($data),
        ]);
    }
}