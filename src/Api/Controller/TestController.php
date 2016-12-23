<?php

namespace Api\Controller;

use Cp\CapSniffer;
use Cp\Provider\TypeProvider;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;

/**
 * Class TestController
 */
class TestController implements ControllerProviderInterface
{
    /**
     * @var CapSniffer
     */
    protected $capSniffer;

    /**
     * @var TypeProvider
     */
    protected $typeProvider;

    /**
     * TestController constructor.
     *
     * @param CapSniffer   $capSniffer
     * @param TypeProvider $typeProvider
     */
    public function __construct(CapSniffer $capSniffer, TypeProvider $typeProvider)
    {
        $this->capSniffer = $capSniffer;
        $this->typeProvider = $typeProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $test = $app['controllers_factory'];

        $test->get('/training/{type}/{week}/{seance}', function ($type, $week, $seance) use ($app) {
            return $this->trainingAction($app['cp.parser.plan'], $app['cp.transformer.url'], $type, $week, $seance);
        });

        return $test;
    }

    /**
     * @param string $type
     * @param int    $week
     * @param int    $seance
     *
     * @return string
     */
    public function trainingAction($plan, $transformer, $type, $week, $seance)
    {
        return $plan->parseToJson(
            $transformer->transformPlan($week, $seance, $this->typeProvider->getTypeByKey($type))
        );
    }
}
