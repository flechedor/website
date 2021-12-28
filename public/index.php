<?php

define('_DEBUG_', true);

date_default_timezone_set('Europe/Paris');
setlocale(LC_ALL, 'fr');
include __DIR__ . '/../kirby/bootstrap.php';

$base = dirname(__DIR__);
$storage = $base . '/storage';

function _debug(...$params) {
    global $storage;
    if(_DEBUG_ === false) return;
    if($fp = fopen($storage.'/logs/debug.log', 'a')) {
        fwrite($fp, date('Y-m-d H:i:s -').' '.print_r($params, true) . PHP_EOL);
        fclose($fp);
    }
}

$kirby = new Kirby([
    'roots' => [
        'index' => __DIR__,
        'base' => $base,
        'content' => $base . '/content',
        'site' => $base . '/site',
        'storage' => $storage,
        'accounts' => $storage . '/accounts',
        'cache' => $storage . '/cache',
        'logs' => $storage . '/logs',
        'sessions' => $storage . '/sessions'
    ]
]);

echo $kirby->render();
