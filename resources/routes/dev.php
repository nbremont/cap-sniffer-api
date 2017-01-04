<?php

require_once 'prod.php';

$app->get('/api/doc', 'training.controller:indexAction');