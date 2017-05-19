<?php

namespace Omnipay\SipsPayPage;

use Omnipay\Common\CreditCard;
use Omnipay\Common\Exception\InvalidCreditCardException;

/**
 * CreditCard for off-site payments without any card informations
 * just customer data.
 *
 * @package Omnipay\Sips
 */
class OffsiteCreditCard extends CreditCard
{

    /**
     * Get the first part of the card billing name.
     *
     * @return string
     */
    public function getBillingFirstName()
    {
        return Normalizer::normalize(parent::getBillingFirstName());
    }

    /**
     * Get the last part of the card billing name.
     *
     * @return string
     */
    public function getBillingLastName()
    {
        return Normalizer::normalize(parent::getBillingLastName());
    }

    /**
     * Get the card billing company name.
     *
     * @return string
     */
    public function getCompany()
    {
        return Normalizer::normalize(parent::getCompany());
    }

    /**
     * Get the billing address, line 1.
     *
     * @return string
     */
    public function getAddress1()
    {
        return Normalizer::normalize(parent::getAddress1());
    }

    /**
     * Get the billing address, line 2.
     *
     * @return string
     */
    public function getAddress2()
    {
        return Normalizer::normalize(parent::getAddress2());
    }

    /**
     * Get the card billing title.
     *
     * @return string
     */
    public function getBillingTitle()
    {
        return Normalizer::normalize(parent::getBillingTitle());
    }

    /**
     * Get the billing address, line 1.
     *
     * @return string
     */
    public function getBillingAddress1()
    {
        return Normalizer::normalize(parent::getBillingAddress1());
    }

    /**
     * Get the billing address, line 2.
     *
     * @return string
     */
    public function getBillingAddress2()
    {
        return Normalizer::normalize(parent::getBillingAddress2());
    }

    /**
     * Get the billing city.
     *
     * @return string
     */
    public function getBillingCity()
    {
        return Normalizer::normalize(parent::getBillingCity());
    }

    /**
     * @{inheritdoc}
     */
    public function validate()
    {
        foreach (array('number', 'expiryMonth', 'expiryYear') as $key) {
            if ($this->getParameter($key)) {
                throw new InvalidCreditCardException("The $key parameter should not be present with OffsiteCreditCard.");
            }
        }

        if (!$this->getParameter('email')) {
            throw new InvalidCreditCardException("The email parameter is required with OffsiteCreditCard.");
        }

        if (strlen($this->getParameter('email')) > 50) {
            throw new InvalidCreditCardException("Email is too long.");
        }


        if ($this->getParameter('address1') &&
            strlen($this->getParameter('address1')) > 50) {
            throw new InvalidCreditCardException("Address1 is too long.");
        }

        if ($this->getParameter('address2') &&
            strlen($this->getParameter('address2')) > 50) {
            throw new InvalidCreditCardException("Address2 is too long.");
        }

        if ($this->getParameter('billingAddress1') &&
            strlen($this->getParameter('billingAddress1')) > 50) {
            throw new InvalidCreditCardException("Address1 is too long.");
        }

        if ($this->getParameter('billingAddress2') &&
            strlen($this->getParameter('billingAddress2')) > 50) {
            throw new InvalidCreditCardException("Address2 is too long.");
        }
    }
}