<?php

namespace Api\ServiceProvider;

use Cocur\Slugify\Slugify;
use Cp\Calendar\Builder\CalendarBuilder;
use Cp\Calendar\Builder\CalendarEventBuilder;
use Cp\CapSniffer;
use Cp\Manager\ConfigurationManager;
use Cp\Manager\PlanManager;
use Cp\Parser\PlanParser;
use Cp\Provider\PlanProvider;
use Cp\Provider\TypeProvider;
use Cp\Transformer\UrlTransformer;
use Doctrine\Common\Cache\MemcachedCache;
use JMS\Serializer\SerializerBuilder;
use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\CalendarStream;
use Jsvrcek\ICS\Utility\Formatter;
use Memcached;
use PHPHtmlParser\Dom;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class CapServiceProvider
 */
class CapServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['ics.calendar_stream'] = function () {
            return new CalendarStream();
        };

        $app['ics.utility.formater'] = function () {
            return new Formatter();
        };

        $app['ics.calendar_export'] = function () use ($app) {
            return new CalendarExport(
                $app['ics.calendar_stream'],
                $app['ics.utility.formater']
            );
        };

        $app['phphtml.parser.dom'] = function () {
            return new Dom();
        };

        $app['jms.serializer.builder'] = function () {
            return new SerializerBuilder();
        };

        $app['jms.serializer.builder'] = function () {
            $builder = new SerializerBuilder();

            return $builder->create();
        };

        $app['jms.serializer'] = function () use ($app) {
            return $app['jms.serializer.builder']->build();
        };

        $app['cocur.slugify'] = function () {
            return new Slugify();
        };

        $app['memcached'] = function () use ($app) {
            $memcached = new Memcached();
            $memcached->addServer($app['memcache.host'], $app['memcache.port']);

            return $memcached;
        };

        $app['doctrine.cache'] = function () use ($app) {
            $memcached = new MemcachedCache();
            $memcached->setMemcached($app['memcached']);

            return $memcached;
        };

        $app['cp.transformer.url'] = function () use ($app) {
            return new UrlTransformer($app['url.base']);
        };

        $app['cp.parser.plan'] = function () use ($app) {
            return new PlanParser($app['phphtml.parser.dom']);
        };

        $app['cp.provider.type'] = function () {
            return new TypeProvider();
        };

        $app['cp.manager.plan'] = function () use ($app) {
            return new PlanManager(
                $app['cp.parser.plan'],
                $app['cp.transformer.url'],
                $app['jms.serializer'],
                $app['doctrine.cache']
            );
        };

        $app['cp.manager.configuration'] = function () use ($app) {
            return new ConfigurationManager($app['cp.provider.type']);
        };

        $app['cp.provider.plan'] = function () use ($app) {
            return new PlanProvider($app['cp.manager.plan']);
        };

        $app['cp.calendar.buider.calendar_event'] = function () {
            return new CalendarEventBuilder();
        };

        $app['cp.calendar.builder.calendar'] = function () use ($app) {
            return new CalendarBuilder(
                $app['ics.calendar_export'],
                $app['cp.calendar.buider.calendar_event']
            );
        };

        $app['cp.parser.plan'] = function () use ($app) {
            return new PlanParser($app['phphtml.parser.dom']);
        };

        $app['cp.cap_sniffer'] = function () use ($app) {
            return new CapSniffer(
                $app['cp.provider.type'],
                $app['cp.provider.plan'],
                $app['cp.calendar.builder.calendar'],
                $app['cocur.slugify'],
                $app['cp.manager.configuration']
            );
        };
    }
}
