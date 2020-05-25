<?php

namespace Modules\Workshop\Tests\Feature;

use Modules\Workshop\Tests\BaseWorkshopTest as TestCase;

use Modules\Workshop\Generators\GeneratorCrud;

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
