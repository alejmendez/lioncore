<?php

namespace App\Generators;

class Controller extends Generator
{
    public function generate()
    {
        $fields = $this->getFieldsWithoutId();

        $fieldsInList = $fields->reject(function ($field) {
            return !$field['inList'];
        })->map(function ($field) {
            return "'" . $field['name'] . "'";
        })->implode(", ");

        $contents = $this->view('scaffolding.controller', [
            'nameModel'    => $this->getNameModel(),
            'fieldsInList' => $fieldsInList,
            'json'         => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Controller.php";
        $pathFile = $this->modulePath(['Http', 'Controllers', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
