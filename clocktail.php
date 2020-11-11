<?php


require './vendor/autoload.php';

// Check path to run
$path = '/etc/clocktail.crontab';
$log = '/var/log/clocktail.log';

// Create croon object
$croon = new \Croon\Croon(array(
    'source' => array(
        'type' => 'file',
        'path' => $path
    ),
    'log' => array(
        'file' => $log
    )
));

$croon->run();