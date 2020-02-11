<?php

namespace Modules\Workshop\Generators;

abstract class Generator
{
    public function __construct($json)
    {
        $this->json = $json;
    }

    protected function getMigrationPath()
    {
        return $this->laravel->databasePath().DIRECTORY_SEPARATOR.'migrations';
    }
}
