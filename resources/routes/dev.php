<?php

require_once 'prod.php';

$app->get('/api/doc', 'swagger.controller:indexAction');