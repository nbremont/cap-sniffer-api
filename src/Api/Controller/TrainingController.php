<?php

namespace Api\Controller;

use Cp\Provider\ConfigurationProvider;
use Silex\Application;
use Swagger\Annotations as SWG;
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

        $controllers->get('/training/configuration/{type}', function ($type) {
            return $this->getConfigurationForType($type);
        });

        $controllers->get('/training/types', function () {
            return $this->getTypesAction();
        });

        return $controllers;
    }

    /**
     * @SWG\Get(
     *     path="/api/training/types",
     *     @SWG\Response(
     *         response="200",
     *         description="Get types of plan",
     *     ),
     * )
     *
     * @return JsonResponse
     */
    public function getTypesAction()
    {
        return new JsonResponse($this->typeProvider->getTypes());
    }

    /**
     * @SWG\Get(
     *     path="/api/training/configuration/{type}",
     *     @SWG\Parameter(
     *         name="type",
     *         in="path",
     *         description="Type of plan",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Get configuration for training plan",
     *     ),
     * )
     *
     * @param string $typeName
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
     * @SWG\Get(
     *     path="/api/training/{type}/{week}/{seance}",
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
     *         description="Get PLan",
     *     ),
     * )
     *
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
    public function setConfigurationProvider(ConfigurationProvider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }
}
