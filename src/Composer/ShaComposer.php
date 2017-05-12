<?php

namespace Omnipay\SipsPayPage\Composer;

class ShaComposer implements ComposerInterface
{
    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @param string $secretKey
     */
    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function compose(array $parameters)
    {
        $parameterComposer = new ParameterComposer();
        $parametersString = $parameterComposer->compose($parameters);

        return hash('sha256', utf8_encode($parametersString . $this->secretKey));
    }
}