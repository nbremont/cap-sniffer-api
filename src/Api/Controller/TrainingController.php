<?php

namespace Api\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

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
}
