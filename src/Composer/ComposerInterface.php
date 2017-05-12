<?php

namespace Omnipay\SipsPayPage\Composer;

interface ComposerInterface
{
    /**
     * Compose string based on parameters.
     *
     * @param array $parameters
     */
    public function compose(array $parameters);
}