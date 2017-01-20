<?php

use Behat\Gherkin\Node\PyStringNode;
use Behat\WebApiExtension\Context\WebApiContext;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class ApiContext
 */
class ApiFeatureContext extends WebApiContext
{
    const FIXTURES_PATH = __DIR__ . '/../../fixtures/api';

    /**
     * @Then the json response contains result of fixture for :arg1 km :arg2 weeks and :arg3 seances
     *
     * @param string $type
     * @param string $week
     * @param string $seance
     */
    public function theJsonResponseContainsResultOfFixtureForKmWeeksAndSeances($type, $week, $seance)
    {
        $expected = new PyStringNode(explode("\n", $this->getFixturesByConfiguration($type, $week, $seance)), 0);
        $this->theResponseShouldContainJson($expected);
    }

    /**
     * @param int $type
     * @param int $week
     * @param int $seance
     *
     * @return string
     */
    public function getFixturesByConfiguration($type, $week, $seance)
    {
        $filePath = self::FIXTURES_PATH . '/plan-'.$type.'-'.$week.'-'.$seance.'.json';
        if (!is_file($filePath)) {
            throw new FileNotFoundException(null, null, null, $filePath);
        }

        return file_get_contents($filePath);
    }

}