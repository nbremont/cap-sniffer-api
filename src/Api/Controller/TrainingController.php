<?php

namespace Api\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TestController
 */
class TrainingController extends AbstractController
{
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
}
