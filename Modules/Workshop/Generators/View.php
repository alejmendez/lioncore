<?php

namespace Modules\Workshop\Generators;

class View extends Generator
{
    protected function generate()
    {
        $this->generateViewList();
        $this->generateViewForm();
    }

    protected function generateViewList()
    {
        $fieldsSelect = $this->json->pluck('fieldInput.name')
            ->map(function ($name) {
                return "'$name'";
            })->implode(',');

        $contents = view('scaffolding.views.list', [
            'title' => $this->title,
            'module' => $this->module,
            'nameModel' => $this->nameModel,
            'jsonContent' => $this->json,
            'fieldsSelect' => $fieldsSelect
        ])->render();

        $path = resource_path('assets/js/pages/' . ucwords($this->module) . '/' . strtolower(str_plural($this->nameModel)));
        $pathFile = $path . '/list.vue';

        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }

        File::put($pathFile, $contents);
    }

    protected function generateViewForm()
    {
        $fieldsSelect = $this->json->pluck('fieldInput.name')
            ->map(function ($name) {
                return "'$name'";
            })->implode(',');

        $contents = view('scaffolding.views.form', [
            'title' => $this->title,
            'module' => $this->module,
            'nameModel' => $this->nameModel,
            'jsonContent' => $this->json,
            'fieldsSelect' => $fieldsSelect
        ])->render();

        $pathFile = resource_path('assets/js/pages/' . ucwords($this->module) . '/' . strtolower(str_plural($this->nameModel)) . '/form.vue');

        File::put($pathFile, $contents);
    }
}
