guzzle4-charset-subscriber
==========================

A bridge Diggin_Http_Charset & Guzzle4. enable auto convert charset encoding to UTF-8.

### INSTALL
`php composer.phar require sasezaki/diggin-guzzle4-charset-subscriber`

### USAGE

``` php
<?php

use GuzzleHttp\Client;
use DigginGuzzle4CharsetSubscriber\CharsetSubscriber;

require_once __DIR__.'./vendor/autoload.php';

$url = 'http://d.hatena.ne.jp/'; // euc-jp web-site

$client = new Client();
$client->getEmitter()->attach(new CharsetSubscriber);
$res = $client->get($url);

var_dump(strip_tags($res->getBody()->__toString())); // will be output as UTF-8
```


### Guzzle3
If you looking for Guzzle3.
  - https://github.com/diggin/guzzle-plugin-AutoCharsetEncodingPlugin
