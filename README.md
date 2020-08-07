## Imaginarium client

Imaginarium api client.

### Installation

```
composer require apps-of-the-day/imaginarium-client-php
```

### Usage
```
<?php

use GuzzleHttp\Client;
use ImaginariumClient\Configurator;
use ImaginariumClient\DTO\Image;
use ImaginariumClient\ImaginariumClient;
use Psr\Log\NullLogger;

require_once 'vendor/autoload.php';

$config = new Configurator('', '');
$guzzle = new Client();
$client = new ImaginariumClient($guzzle, $config, new NullLogger());

$result = $client->upload(['file.txt' => fopen('file.txt', 'rb')]);

$result->current();

```
