<?php
/**
 * Lists all events in your iPhoto library, together with the number of photos, sorted alphabetically
 *
 * Usage: php examples/events.php [path-to-iphoto-library]
 *
 * @author Robbert Klarenbeek <robbertkl@renbeek.nl>
 * @copyright Copyright (c) 2013, Robbert Klarenbeek
 * @package photolibrary
 */

// Change this if you're not using Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Default to OS X default iPhoto library
$libraryPath = ($argc >= 2) ? $argv[1] : $_SERVER['HOME'] . '/Pictures/iPhoto Library.photolibrary';

$library = new \PhotoLibrary\Library($libraryPath);

$events = array();
foreach ($library->getAlbumsOfType('Event') as $album) {
    $events[$album->getName()] = $album->getPhotoCount();
}

ksort($events);
foreach ($events as $eventName => $photoCount) {
    echo $eventName . ' (' . $photoCount . ' photos)' . PHP_EOL;
}
