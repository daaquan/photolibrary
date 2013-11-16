<?php
/**
 * Does the same as events.php (actually includes it), but uses a cache (if the necessary packages/extensions are installed)
 * and possibly adds some additional output with informative text about the cache
 *
 * Usage: see examples/events.php
 *
 * @author Robbert Klarenbeek <robbertkl@renbeek.nl>
 * @copyright Copyright (c) 2013, Robbert Klarenbeek
 * @package photolibrary
 */

// Change this if you're not using Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Try APC and {Filesystem + Serializer}, just as an example
if (extension_loaded('apc') && ini_get('apc.enabled') && (PHP_SAPI != 'cli' || ini_get('apc.enable_cli')) && class_exists('\Zend\Cache\Storage\Adapter\Apc')) {
    $cache = new \Zend\Cache\Storage\Adapter\Apc();
} elseif (class_exists('\Zend\Cache\Storage\Adapter\Filesystem') && class_exists('\Zend\Serializer\Serializer')) {
    $cache = new \Zend\Cache\Storage\Adapter\Filesystem();

    // The Storage\Adapter\Filesystem does not support array or object datatypes, therefore add a Serializer plugin
    $plugin = new \Zend\Cache\Storage\Plugin\Serializer();
    $cache->addPlugin($plugin);
}

if (!isset($cache)) {
    echo 'ERROR: unable to select a cache to use' . PHP_EOL;
    exit(1);
}

\PhotoLibrary\Library::setCache($cache);

if (!\PhotoLibrary\Library::isUsingCache()) {
    echo 'WARNING: cache is set, but will not be used (most likely due to incorrect storage capabilites)' . PHP_EOL;

    // In this case, the next PhotoLibrary\Library construction triggers an
    // Exception, unless a Zend\Cache\Storage\Plugin\ExceptionHandler with the
    // throw_exceptions => false option is added to the cache storage, which will
    // cause it to continue without using a cache. Here's how to do that:
    //
    // $plugin = new \Zend\Cache\Storage\Plugin\ExceptionHandler();
    // $plugin->getOptions()->setThrowExceptions(false);
    // $cache->addPlugin($plugin);
}

require __DIR__ . '/events.php';
