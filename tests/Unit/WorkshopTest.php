<?php

namespace App\Tests\Feature;

use App\Tests\BaseWorkshopTest as TestCase;

use App\Generators\GeneratorCrud;

class WorkshopTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function getAllJsonsOfModules()
    {
        $generatorCrud = new GeneratorCrud("", "");

        $allModelsFiles = $this->invokeMethod($generatorCrud, 'getAllModelsFiles');

        dump($allModelsFiles);
    }

    /** @test */
    public function getJsonContent()
    {
        $generatorCrud = new GeneratorCrud("", "");

        $jsonContentAll = $this->invokeMethod($generatorCrud, 'getJsonContent', [false]);

        dump($allModelsFiles);
    }
}
