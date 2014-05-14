# Zuora REST PHP Client

[![Build Status](https://travis-ci.org/mhrabovcin/zuora-rest.png)](https://travis-ci.org/mhrabovcin/zuora-rest)
[![Coverage Status](https://coveralls.io/repos/mhrabovcin/zuora-rest/badge.png?branch=master)](https://coveralls.io/r/mhrabovcin/zuora-rest?branch=master)
[![Total Downloads](https://poser.pugx.org/mhrabovcin/zuora-rest/downloads.png)](https://packagist.org/packages/mhrabovcin/zuora-rest)
[![Latest Stable Version](https://poser.pugx.org/mhrabovcin/zuora-rest/v/stable.png)](https://packagist.org/packages/mhrabovcin/zuora-rest)

Simple Zuora REST API client.

## Installation

Zuora REST PHP Client can be installed with [Composer](http://getcomposer.org)
by adding it as a dependency to your project's composer.json file.

```json
{
    "require": {
        "mhrabovcin/zuora-rest": "*"
    }
}
```

Please refer to [Composer's documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction)
for more detailed installation and usage instructions.

## Usage

To initialize client use following code:

```php
use \Zuora\Client;

$client = Client::factory(array(
    'username' => 'email@exmaple.com',
    'password' => 'secretpassword',
    // For production endpoint
    'endpoint' => 'https://api.zuora.com/rest'
));
```

Client has method for querying Zuora API

```php
$account = $client->getAccount('A0000001');
print $account->getAccountNumber() . "\n"; // A0000001
print $account->getBillToContact()->getFirstName() . "\n"; // John

$credit_cards = $cliennt->getCreditCards('A0000001');
$card = reset($credit_cards);
print $card->isDefaultPaymentMethod() . "\n";
print $card->getCardHolderInfo()->getCardHolderName() . "\n";
```
## For developers

Refer to [PHP Project Starter's documentation](https://github.com/cpliakas/php-project-starter#using-apache-ant)
for the Apache Ant targets supported by this project.

## TODO

* Add lazy result loading

