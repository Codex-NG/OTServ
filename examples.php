<?php

include __DIR__. '/OTServ.php';

$server = new OTServ('shadowcores.twifysoft.net');

if ($server->get()) {
    echo 'Players online: ' . $server->playersOnline();
} else {
    echo 'Server is offline, or wrong ip/port!';
}