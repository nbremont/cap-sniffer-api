<?php
// include the prod configuration
require __DIR__.'/prod.php';
// enable the debug mode
$app['env'] = 'dev';
$app['debug'] = true;
