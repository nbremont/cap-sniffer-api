<?php

namespace Api\Controller;

use Cp\CapSniffer;
use Cp\Provider\TypeProvider;
use JMS\Serializer\Serializer;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;

/**
 * Class AbstractController
 *
 * @package Api\Controller
 */
class AbstractController implements ControllerProviderInterface
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
    }
}
