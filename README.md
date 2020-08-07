## Imaginarium client

### Installation

```
composer require 
```

### Usage
```
<?php

use ImaginariumClient\Configurator;
use ImaginariumClient\DTO\Image;
use ImaginariumClient\ImaginariumClient;
use Psr\Log\NullLogger;

require_once 'vendor/autoload.php';

$config = new Configurator('http://imaginaroum-server', 'SECRET_TOKEN');
$client = new ImaginariumClient(new GuzzleHttp\Client(), $config, new NullLogger());

$client->upload(
    [
        new Image(new SplFileObject('./kitty.png', 'rb'))
    ]
);
```
