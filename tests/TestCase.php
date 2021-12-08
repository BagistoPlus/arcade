<?php

namespace EldoMagan\BagistoArcade\Tests;

use EldoMagan\BagistoArcade\Providers\ArcadeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ArcadeServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_arcade_table.php.stub';
        $migration->up();
        */
    }
}
