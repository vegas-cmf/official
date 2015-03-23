<?php
error_reporting(E_ALL);

define('APP_ROOT', dirname(dirname(__FILE__)));

try {
    require APP_ROOT . '/vendor/autoload.php';
    require APP_ROOT . '/app/Bootstrap.php';

    //ensure that you copied config.sample.php to config.php
    $config = require APP_ROOT . '/app/config/config.php';

    $bootstrap = new \Bootstrap(new \Phalcon\Config($config));

    echo $bootstrap->setup()->run();
} catch (\Exception $ex) {
    echo $ex->getMessage();
    echo $ex->getTraceAsString();
}
