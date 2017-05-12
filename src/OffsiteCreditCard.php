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
    }
}