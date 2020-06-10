<?php

namespace App\Generators;

use Illuminate\Support\Str;

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
        $path = resource_path('assets/js/pages/' . strtolower(Str::of($this->getNameModel())->plural()));

        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }

        return $path;
    }
}
