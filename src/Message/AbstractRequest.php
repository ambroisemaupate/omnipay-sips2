<?php

namespace Omnipay\SipsPayPage\Message;


abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $allowedlanguages = array(
        'nl', 'fr', 'de', 'it', 'es', 'cy', 'en'
    );

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        if (!in_array($language, $this->allowedlanguages)) {
            throw new \InvalidArgumentException("Invalid language locale");
        }
        $this->setParameter('customerLanguage', $language);
    }

    /**
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function getLanguage()
    {
        return $this->getParameter('customerLanguage');
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param $merchantId
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setMerchantId($merchantId)
    {
        return $this->setParameter('merchantId', $merchantId);
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * @param $secretKey
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setSecretKey($secretKey)
    {
        return $this->setParameter('secretKey', $secretKey);
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->getParameter('url');
    }

    /**
     * @param $url
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setUrl($url)
    {
        return $this->setParameter('url', $url);
    }

    /**
     * @return mixed
     */
    public function getInterfaceVersion()
    {
        return $this->getParameter('interfaceVersion');
    }

    /**
     * @param $interfaceVersion
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setInterfaceVersion($interfaceVersion)
    {
        return $this->setParameter('interfaceVersion', $interfaceVersion);
    }

    /**
     * @return mixed
     */
    public function getKeyVersion()
    {
        return $this->getParameter('keyVersion');
    }

    /**
     * @param $keyVersion
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setKeyVersion($keyVersion)
    {
        return $this->setParameter('keyVersion', $keyVersion);
    }
}