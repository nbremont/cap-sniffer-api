<?php

namespace Api\Controller;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TestController
 */
class CalendarController extends AbstractController
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/calendar/{type}/{week}/{seance}', function ($type, $week, $seance) use ($app) {
            return $this->getCalendarAction($type, $week, $seance);
        });

        return $controllers;
    }

    /**
     * @param string $type
     * @param int $week
     * @param int $seance
     *
     * @return string
     */
    public function getCalendarAction($type, $week, $seance)
    {
        $typeName = $this->typeProvider->getTypeByKey($type);
        $calendar = $this->serializer->serialize([
            'content' => $this->capSniffer->generateCalendar($typeName, $week, $seance),
        ], 'json');

        return new Response($calendar, 200, ['Content-type' => 'application/json']);
    }
}
