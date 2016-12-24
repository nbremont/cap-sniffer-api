<?php

namespace Api\Controller;

use Cp\CapSniffer;
use Cp\Parser\PlanParser;
use Cp\Provider\TypeProvider;
use Cp\Transformer\UrlTransformer;
use JMS\Serializer\Serializer;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * TestController constructor.
     *
     * @param CapSniffer $capSniffer
     * @param Serializer $serializer
     */
    public function __construct(CapSniffer $capSniffer, Serializer $serializer)
    {
        $this->capSniffer = $capSniffer;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/training/{type}/{week}/{seance}', function ($type, $week, $seance) use ($app) {
            return $this->trainingAction($type, $week, $seance);
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
    public function trainingAction($type, $week, $seance)
    {
        $plan = $this->serializer->serialize($this->capSniffer->getPlan($type, $week, $seance), 'json');

        return new Response($plan, 200, ['Content-type' => 'application/json']);
    }
}
