<?php

namespace Modules\Workshop\Generators;

class Model extends Generator
{
    protected function generate()
    {
        $fields = $this->getFields();
        $fillable = $fields->pluck('fieldInput.name')->reject(function ($value, $key) {
            return $value == 'id';
        })->map(function ($name) {
            return "'$name'";
        })->implode(',');

        $contents = $this->view('scaffolding.model', [
            'nameModel'   => $this->getNameModel(),
            'fillable'    => $fillable,
            'jsonContent' => $fields
        ]);

        $nameFile = ucwords($this->getNameModel()) . ".php";
        $pathFile = $this->modulePath(['Models', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
