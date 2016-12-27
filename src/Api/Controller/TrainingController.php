<?php

namespace Api\Controller;

use Cp\Provider\ConfigurationProvider;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TestController
 */
class TrainingController extends AbstractController
{
    /**
     * @var ConfigurationProvider
     */
    protected $configurationProvider;

    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/training/{type}/{week}/{seance}', function ($type, $week, $seance) use ($app) {
            return $this->getTrainingPlanAction($type, $week, $seance);
        });

        $controllers->get('/training/types', function () {
            return $this->getTypesAction();
        });

        $controllers->get('/training/configuration/{type}', function ($type) {
            return $this->getConfigurationForType($type);
        });

        return $controllers;
    }

    /**
     * @return JsonResponse
     */
    public function getTypesAction()
    {
        return new JsonResponse($this->typeProvider->getTypes());
    }

    /**
     * @param $typeName
     *
     * @return JsonResponse
     */
    public function getConfigurationForType($typeName)
    {
        $configurationCollection = $this->getConfigurationProvider()->getConfigurationByType($typeName);

        return new JsonResponse(
            json_decode($this->serializer->serialize($configurationCollection, 'json'))
        );
    }

    /**
     * @param string $type
     * @param int    $week
     * @param int    $seance
     *
     * @return JsonResponse
     */
    public function getTrainingPlanAction($type, $week, $seance)
    {
        return new JsonResponse(
            json_decode($this->serializer->serialize($this->capSniffer->getPlan($type, $week, $seance), 'json'))
        );
    }

    /**
     * @return ConfigurationProvider
     */
    public function getConfigurationProvider()
    {
        return $this->configurationProvider;
    }

    /**
     * @param ConfigurationProvider $configurationProvider
     */
    public function setConfigurationProvider($configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }
}
