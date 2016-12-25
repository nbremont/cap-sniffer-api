<?php

namespace Api\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @return JsonResponse
     */
    public function getCalendarAction($type, $week, $seance)
    {
        return new JsonResponse([
            'content' => $this->capSniffer->generateCalendar($type, $week, $seance),
        ]);
    }
}
