<?php
use GuzzleHttp\Client;
use DigginGuzzle4CharsetSubscriber\CharsetSubscriber;

require_once __DIR__.'./vendor/autoload.php';

$url = 'http://d.hatena.ne.jp/'; // euc-jp web-site

$client = new Client();
$client->getEmitter()->attach(new CharsetSubscriber);
$res = $client->get($url);

var_dump(strip_tags($res->getBody()->__toString())); // will be output as UTF-8 
