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
    protected static $countries = array(
        "BD" => "BGD",
        "BE" => "BEL",
        "BF" => "BFA",
        "BG" => "BGR",
        "BA" => "BIH",
        "BB" => "BRB",
        "WF" => "WLF",
        "BL" => "BLM",
        "BM" => "BMU",
        "BN" => "BRN",
        "BO" => "BOL",
        "BH" => "BHR",
        "BI" => "BDI",
        "BJ" => "BEN",
        "BT" => "BTN",
        "JM" => "JAM",
        "BV" => "BVT",
        "BW" => "BWA",
        "WS" => "WSM",
        "BQ" => "BES",
        "BR" => "BRA",
        "BS" => "BHS",
        "JE" => "JEY",
        "BY" => "BLR",
        "BZ" => "BLZ",
        "RU" => "RUS",
        "RW" => "RWA",
        "RS" => "SRB",
        "TL" => "TLS",
        "RE" => "REU",
        "TM" => "TKM",
        "TJ" => "TJK",
        "RO" => "ROU",
        "TK" => "TKL",
        "GW" => "GNB",
        "GU" => "GUM",
        "GT" => "GTM",
        "GS" => "SGS",
        "GR" => "GRC",
        "GQ" => "GNQ",
        "GP" => "GLP",
        "JP" => "JPN",
        "GY" => "GUY",
        "GG" => "GGY",
        "GF" => "GUF",
        "GE" => "GEO",
        "GD" => "GRD",
        "GB" => "GBR",
        "GA" => "GAB",
        "SV" => "SLV",
        "GN" => "GIN",
        "GM" => "GMB",
        "GL" => "GRL",
        "GI" => "GIB",
        "GH" => "GHA",
        "OM" => "OMN",
        "TN" => "TUN",
        "JO" => "JOR",
        "HR" => "HRV",
        "HT" => "HTI",
        "HU" => "HUN",
        "HK" => "HKG",
        "HN" => "HND",
        "HM" => "HMD",
        "VE" => "VEN",
        "PR" => "PRI",
        "PS" => "PSE",
        "PW" => "PLW",
        "PT" => "PRT",
        "SJ" => "SJM",
        "PY" => "PRY",
        "IQ" => "IRQ",
        "PA" => "PAN",
        "PF" => "PYF",
        "PG" => "PNG",
        "PE" => "PER",
        "PK" => "PAK",
        "PH" => "PHL",
        "PN" => "PCN",
        "PL" => "POL",
        "PM" => "SPM",
        "ZM" => "ZMB",
        "EH" => "ESH",
        "EE" => "EST",
        "EG" => "EGY",
        "ZA" => "ZAF",
        "EC" => "ECU",
        "IT" => "ITA",
        "VN" => "VNM",
        "SB" => "SLB",
        "ET" => "ETH",
        "SO" => "SOM",
        "ZW" => "ZWE",
        "SA" => "SAU",
        "ES" => "ESP",
        "ER" => "ERI",
        "ME" => "MNE",
        "MD" => "MDA",
        "MG" => "MDG",
        "MF" => "MAF",
        "MA" => "MAR",
        "MC" => "MCO",
        "UZ" => "UZB",
        "MM" => "MMR",
        "ML" => "MLI",
        "MO" => "MAC",
        "MN" => "MNG",
        "MH" => "MHL",
        "MK" => "MKD",
        "MU" => "MUS",
        "MT" => "MLT",
        "MW" => "MWI",
        "MV" => "MDV",
        "MQ" => "MTQ",
        "MP" => "MNP",
        "MS" => "MSR",
        "MR" => "MRT",
        "IM" => "IMN",
        "UG" => "UGA",
        "TZ" => "TZA",
        "MY" => "MYS",
        "MX" => "MEX",
        "IL" => "ISR",
        "FR" => "FRA",
        "IO" => "IOT",
        "SH" => "SHN",
        "FI" => "FIN",
        "FJ" => "FJI",
        "FK" => "FLK",
        "FM" => "FSM",
        "FO" => "FRO",
        "NI" => "NIC",
        "NL" => "NLD",
        "NO" => "NOR",
        "NA" => "NAM",
        "VU" => "VUT",
        "NC" => "NCL",
        "NE" => "NER",
        "NF" => "NFK",
        "NG" => "NGA",
        "NZ" => "NZL",
        "NP" => "NPL",
        "NR" => "NRU",
        "NU" => "NIU",
        "CK" => "COK",
        "XK" => "XKX",
        "CI" => "CIV",
        "CH" => "CHE",
        "CO" => "COL",
        "CN" => "CHN",
        "CM" => "CMR",
        "CL" => "CHL",
        "CC" => "CCK",
        "CA" => "CAN",
        "CG" => "COG",
        "CF" => "CAF",
        "CD" => "COD",
        "CZ" => "CZE",
        "CY" => "CYP",
        "CX" => "CXR",
        "CR" => "CRI",
        "CW" => "CUW",
        "CV" => "CPV",
        "CU" => "CUB",
        "SZ" => "SWZ",
        "SY" => "SYR",
        "SX" => "SXM",
        "KG" => "KGZ",
        "KE" => "KEN",
        "SS" => "SSD",
        "SR" => "SUR",
        "KI" => "KIR",
        "KH" => "KHM",
        "KN" => "KNA",
        "KM" => "COM",
        "ST" => "STP",
        "SK" => "SVK",
        "KR" => "KOR",
        "SI" => "SVN",
        "KP" => "PRK",
        "KW" => "KWT",
        "SN" => "SEN",
        "SM" => "SMR",
        "SL" => "SLE",
        "SC" => "SYC",
        "KZ" => "KAZ",
        "KY" => "CYM",
        "SG" => "SGP",
        "SE" => "SWE",
        "SD" => "SDN",
        "DO" => "DOM",
        "DM" => "DMA",
        "DJ" => "DJI",
        "DK" => "DNK",
        "VG" => "VGB",
        "DE" => "DEU",
        "YE" => "YEM",
        "DZ" => "DZA",
        "US" => "USA",
        "UY" => "URY",
        "YT" => "MYT",
        "UM" => "UMI",
        "LB" => "LBN",
        "LC" => "LCA",
        "LA" => "LAO",
        "TV" => "TUV",
        "TW" => "TWN",
        "TT" => "TTO",
        "TR" => "TUR",
        "LK" => "LKA",
        "LI" => "LIE",
        "LV" => "LVA",
        "TO" => "TON",
        "LT" => "LTU",
        "LU" => "LUX",
        "LR" => "LBR",
        "LS" => "LSO",
        "TH" => "THA",
        "TF" => "ATF",
        "TG" => "TGO",
        "TD" => "TCD",
        "TC" => "TCA",
        "LY" => "LBY",
        "VA" => "VAT",
        "VC" => "VCT",
        "AE" => "ARE",
        "AD" => "AND",
        "AG" => "ATG",
        "AF" => "AFG",
        "AI" => "AIA",
        "VI" => "VIR",
        "IS" => "ISL",
        "IR" => "IRN",
        "AM" => "ARM",
        "AL" => "ALB",
        "AO" => "AGO",
        "AQ" => "ATA",
        "AS" => "ASM",
        "AR" => "ARG",
        "AU" => "AUS",
        "AT" => "AUT",
        "AW" => "ABW",
        "IN" => "IND",
        "AX" => "ALA",
        "AZ" => "AZE",
        "IE" => "IRL",
        "ID" => "IDN",
        "UA" => "UKR",
        "QA" => "QAT",
        "MZ" => "MOZ"
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
            'customerAddress.country' => $this->validateCountry($card->getCountry()),
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
            'billingContact.email' => $card->getEmail(),
            // billing address
            'billingAddress.city' => $card->getBillingCity(),
            'billingAddress.company' => $card->getBillingCompany(),
            'billingAddress.country' => $this->validateCountry($card->getBillingCountry()),
            'billingAddress.state' => $card->getBillingState(),
            'billingAddress.addressAdditional1' => $card->getBillingAddress1(),
            'billingAddress.addressAdditional2' => $card->getBillingAddress2(),
            'billingAddress.zipCode' => $card->getBillingPostcode(),
        ];

        return array_filter($fields);
    }

    /**
     * @param string $country
     * @return string Valid 3-letters country code or empty string.
     */
    protected function validateCountry($country = "")
    {
        $country = strtoupper($country);

        /*
         * If country is an ISO 3-letters
         */
        if (strlen($country) === 3 && !in_array($country, static::$countries)) {
            throw new \InvalidArgumentException('Country must be a valid ISO 2-letters or 3-letters code.');
        }

        /*
         * If country is an ISO 2-letters
         */
        if (strlen($country) === 2) {
            if (isset(static::$countries[$country])) {
                return static::$countries[$country];
            } else {
                throw new \InvalidArgumentException('Country must be a valid ISO 2-letters or 3-letters code.');
            }
        }

        /*
         * If country is not a code
         */
        if (strlen($country) > 3 || strlen($country) === 1) {
            throw new \InvalidArgumentException('Country must be an ISO 2-letters or 3-letters code.');
        }

        /*
         * If country is empty or a valid 3-letter code.
         */
        return $country;
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