<?php

namespace Api\Controller;

use Cp\CapSniffer;
use Cp\DomainObject\TypeInterface;
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
     * @param CapSniffer $capSniffer
     */
    public function __construct(CapSniffer $capSniffer)
    {
        $this->capSniffer = $capSniffer;
    }

    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $test = $app['controllers_factory'];

        $test->get('/training/{type}/{week}/{seance}', function ($type, $week, $seance) {
            return $this->testAction($type, $week, $seance);
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
    public function testAction($type, $week, $seance)
    {
        return $this->capSniffer->generateCalendar($this->typeProvider->getTypes()[$type], $week, $seance);
    }
}
