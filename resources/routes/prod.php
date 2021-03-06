<?php

$app->get('/api/training/types', 'training.controller:getTypesAction');
$app->get('/api/training/configuration/{type}', 'training.controller:getConfigurationForType');

$app->get('/api/training/{type}/{week}/{seance}', 'training.controller:getTrainingPlanAction')
    ->assert('type', '\d+')
    ->assert('week', '\d+')
    ->assert('seance', '\d+')
;

$app->get('/api/calendar/{type}/{week}/{seance}', 'calendar.controller:getCalendarAction');