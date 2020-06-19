<?php

namespace App\Generators;

use Illuminate\Support\Str;

/*
resources\js\src\router
resources\js\src\store
resources\js\src\views
resources\js\src\i18n\trans\es.js
*/

class View extends Generator
{
    const PATHVIEW = 'scaffolding.views';

    public function generate()
    {
        $this->generateView('list');
        $this->generateView('form');
    }

    protected function generateView($viewName)
    {
        $contents = $this->view(self::PATHVIEW . '.' . $viewName, $this->getData());

        $path = $this->getPath();
        $pathFile = $path . '/' . $viewName . '.vue';

        $this->writeFile($pathFile, $contents);
    }

    protected function getData()
    {
        $fields = $this->getFields();
        $fieldsSelect = $fields->pluck('fieldInput.name')
            ->map(function ($name) {
                return "'$name'";
            })->implode(',');

        return [
            'title' => $this->title,
            'nameModel' => $this->getNameModel(),
            'jsonContent' => $fields,
            'fieldsSelect' => $fieldsSelect
        ];
    }

    protected function getPath()
    {
        $path = resource_path('js/src/views/' . strtolower(Str::of($this->getNameModel())->plural()));

        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }

        return $path;
    }
}
