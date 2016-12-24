<?php

namespace Api\Controller;

use Cp\CapSniffer;
use Cp\Provider\TypeProvider;
use JMS\Serializer\Serializer;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TestController
 */
class TrainingController implements ControllerProviderInterface
{
    /**
     * @var CapSniffer
     */
    protected $capSniffer;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var TypeProvider
     */
    protected $typeProvider;

    /**
     * TestController constructor.
     *
     * @param CapSniffer   $capSniffer
     * @param Serializer   $serializer
     * @param TypeProvider $typeProvider
     */
    public function __construct(CapSniffer $capSniffer, Serializer $serializer, TypeProvider $typeProvider)
    {
        $this->capSniffer = $capSniffer;
        $this->serializer = $serializer;
        $this->typeProvider = $typeProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/training/{type}/{week}/{seance}', function ($type, $week, $seance) use ($app) {
            return $this->getTrainingPlanAction($type, $week, $seance);
        });

        $controllers->get('/calendar/{type}/{week}/{seance}', function ($type, $week, $seance) use ($app) {
            return $this->getCalendarAction($type, $week, $seance);
        });

        return $controllers;
    }

    /**
     * @param string $type
     * @param int    $week
     * @param int    $seance
     *
     * @return string
     */
    public function getTrainingPlanAction($type, $week, $seance)
    {
        $typeName = $this->typeProvider->getTypeByKey($type);
        $plan = $this->serializer->serialize($this->capSniffer->getPlan($typeName, $week, $seance), 'json');

        return new Response($plan, 200, ['Content-type' => 'application/json']);
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
