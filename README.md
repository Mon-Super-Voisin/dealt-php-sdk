<img src="https://dealt.fr/logo.svg" width="200"/>

## Dealt PHP SDK

### Installation ⚙️

###### Requirements

[PHP 7.1+](https://php.net/releases/) - _library tested on php 7.1, 7.2, 7.3, 7.4 & 8.1_

###### Composer

```bash
composer require dealt/dealt-sdk
```

### Usage ✨

##### Dealt Client initialization

Initalize the Dealt client with your api key.
You can specify the API environment you want to target using the `DealtEnvironment` constants. Use `DealtEnvironment.TEST` for development purposes.

```php
use Dealt\DealtSDK\DealtClient;
use Dealt\DealtSDK\DealtEnvironment;

$client = new DealtClient([
    "api_key": "secret_dealt_api_key",
    "env": DealtEnvironment::PRODUCTION
]);
```

##### Offer availability

Check if an offer is available for a given country / zipCode :

```php
$offer = $client->offers->availability([
    'offer_id' => 'your-offer-uuid',
    'address'  => [
        'country' => 'France',
        'zipCode' => '75016',
    ]
]);
// the result is an instance of OfferAvailabilityQuerySuccess
$available = $offer->available;
$netPrice = $offer->netPrice->amount;
$grossPrice = $offer->grossPrice->amount;
$vat = $offer->vat->amount;
```

### Development 👨🏼‍💻

```bash
composer lint # lint source files
composer test:lint # ensure valid codestyle
composer test:types # phpstan reporting
composer test:unit # phpunit tests
```

### Dealt GraphQL API compatibility ✨

| GraphQL Operation     | operation type | supported |
| --------------------- | -------------- | --------- |
| **offerAvailability** | _query_        | ✅        |
| **missions**          | _query_        | ⚙️        |
| **mission**           | _query_        | ⚙️        |
| **submitMission**     | _mutation_     | ✅        |
| **cancelMission**     | _mutation_     | ⚙️        |
