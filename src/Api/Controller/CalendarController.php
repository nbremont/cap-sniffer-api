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
     * @SWG\Get(
     *     path="/api/calendar/{type}/{week}/{seance}",
     *     @SWG\Parameter(
     *         name="type",
     *         in="path",
     *         description="Type of plan",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="week",
     *         in="path",
     *         description="Number of week for a training plan",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="seance",
     *         in="path",
     *         description="Number of seance for a training plan",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Get content calendar (ics)",
     *     ),
     * )
     *
     * @param string $type
     * @param int    $week
     * @param int    $seance
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
