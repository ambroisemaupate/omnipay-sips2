# Omnipay gateway for Worldline (Atos) Sips 2.0

This gateway implements *Sips PayPage POST API* only.

## Gateway parameters

Gateway is provided default *Sogenactif* (Société Générale) testing credentials.

| Parameter | Default value |
| --------- | ------------- |
| merchantId | `002001000000001` |
| secretKey | `002001000000001_KEY1` |
| interfaceVersion | `"HP_2.14"` |
| keyVersion | `1` |
| url | `https://payment-webinit.simu.sips-atos.com` |

Be careful, in *test* mode, `transactionReference` parameter is mandatory.

## Usage

### First step: offsite payment

```php
$gateway = \Omnipay\Omnipay::create('SipsPayPage');
$gateway->setMerchantId('XXXXXXXXXXXXXXXXX');
$gateway->setSecretKey('XXXXXXXXXXXXXXXXX');
$gateway->setUrl('https://payment-webinit.simu.sips-atos.com');

$card = new \Omnipay\Sips\OffsiteCreditCard();
$card->setEmail('test@test.com');

// Send purchase request
$request = $gateway->purchase(
    [
        'clientIp' => $request->getClientIp(),
        'amount' => '10.00',
        'currency' => 'EUR',
        'returnUrl' => $this->generateUrl('completePurchaseRoute', [], UrlGenerator::ABSOLUTE_URL),
        'notifyUrl' => $this->generateUrl('completePurchaseRoute', [], UrlGenerator::ABSOLUTE_URL),
        'cancelUrl' => $this->generateUrl('cancelRoute', [], UrlGenerator::ABSOLUTE_URL),
        'card' => $card
    ]
);
$response = $request->send();

if ($response->isRedirect()) {
    $response->redirect(); // this will automatically forward the customer
}
```

### Second step: manual and automatic response

```php
$gateway = \Omnipay\Omnipay::create('SipsPayPage');
$gateway->setMerchantId('XXXXXXXXXXXXXXXXX');
$gateway->setSecretKey('XXXXXXXXXXXXXXXXX');
$gateway->setUrl('https://payment-webinit.simu.sips-atos.com');

// Send completePurchase request 
$request = $gateway->completePurchase();
$response = $request->send();

if ($response->isSuccessful()) {
    // DO your store logic.
    
    $bankTransactionRef = $response->getTransactionReference();
    $websiteOrderId = $response->getTransactionId();
} elseif ($response->isPending()) {
    // Do temporary things until we get a success/failed tranaction response.
} else {
    echo $response->getMessage();
}
```
