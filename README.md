## Imaginarium client

Imaginarium server client.

### Installation

```
composer require apps-of-the-day/imaginarium-client-php
```

### Usage
```
<?php

use ImaginariumClient\Configurator;
use ImaginariumClient\DTO\Image;
use ImaginariumClient\DTO\Uploaded;
use ImaginariumClient\ImaginariumClient;
use Psr\Log\NullLogger;

require_once 'vendor/autoload.php';

$config = new Configurator('http://imaginaroum-server', 'SECRET_TOKEN');
$client = new ImaginariumClient(new GuzzleHttp\Client(), $config, new NullLogger());

/** @var Uploaded[] $result **/
$result = 
    $client->upload(
        [
            new Image(new SplFileObject('./kitty.png', 'rb'))
        ]
    )
;
```
