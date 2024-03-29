<?php

namespace App\Generators;

class Model extends Generator
{
    public function generate()
    {
        $fields = $this->getFieldsWithoutId();
        $fillable = $fields->map(function ($field) {
            return "'" . $field['name'] . "'";
        });

        $contents = $this->view('scaffolding.model', [
            'nameModel' => $this->getNameModel(),
            'fillable'  => $fillable,
            'json'      => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . ".php";
        $pathFile = $this->path(['app', 'Models', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
