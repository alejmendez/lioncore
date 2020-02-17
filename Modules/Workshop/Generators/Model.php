<?php

namespace Modules\Workshop\Generators;

class Model extends Generator
{
    public function generate()
    {
        $fields = $this->getFields();
        $fillable = $fields->reject(function ($field) {
            return $field['name'] == 'id';
        })->map(function ($field) {
            return "'" . $field['name'] . "'";
        });

        $contents = $this->view('scaffolding.model', [
            'nameModel' => $this->getNameModel(),
            'fillable'  => $fillable,
            'fields'    => $fields,
            'json'      => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . ".php";
        $pathFile = $this->modulePath(['Models', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
