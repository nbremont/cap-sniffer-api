<?php

use Behat\Gherkin\Node\PyStringNode;
use Behat\WebApiExtension\Context\WebApiContext;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class ApiContext
 */
class ApiFeatureContext extends WebApiContext
{
    const FIXTURES_PATH = __DIR__.'/../../fixtures/api';

    /**
     * @Then the json response contains result of fixture :resource for :type km :week weeks and :seance seances
     *
     * @param string $resource
     * @param string $type
     * @param string $week
     * @param string $seance
     */
    public function theJsonResponseContainsResultOfFixturePlanForKmWeeksAndSeances($resource, $type, $week, $seance)
    {
        $expected = new PyStringNode(explode("\n", $this->getFixturesByResources($resource, $type, $week, $seance)), 0);
        $this->theResponseShouldContainJson($expected);
    }

    /**
     * @Then the json response contains result of fixture :resource for :type
     *
     * @param string $resource
     * @param string $type
     */
    public function theJsonResponseContainsResultOfFixtureFor($resource, $type)
    {
        $expected = new PyStringNode(explode("\n", $this->getFixturesByResources($resource, $type)), 0);
        $this->theResponseShouldContainJson($expected);
    }

    /**
     * @param string $resource
     * @param string $type
     * @param string $week
     * @param string $seance
     *
     * @return string
     */
    public function getFixturesByResources($resource, $type, $week = null, $seance = null)
    {
        $weekSuffix = null !== $week ? '-'.$week : '';
        $seanceSuffix = null !== $seance ? '-'.$seance : '';

        $filePath = self::FIXTURES_PATH.'/'.$resource.'-'.$type.$weekSuffix.$seanceSuffix.'.json';
        if (!is_file($filePath)) {
            throw new FileNotFoundException(null, null, null, $filePath);
        }

        return file_get_contents($filePath);
    }
}
