<?php

namespace Alejmendez87\Workshop\Generators;

class Controller extends Generator
{
    public function generate()
    {
        $fields = $this->getFieldsWithoutId();
        $nameRoutePlural = strtolower($this->getModelPluralName());
        $fieldsInList = $fields->reject(function ($field) {
            return !$field['inList'];
        })->map(function ($field) {
            return "'" . $field['name'] . "'";
        })->implode(", ");

        $contents = $this->view('controller', [
            'nameModel'       => $this->getNameModel(),
            'nameModelLower'  => strtolower($this->getNameModel()),
            'nameRoutePlural' => $nameRoutePlural,
            'fieldsInList'    => $fieldsInList,
            'json'            => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Controller.php";
        $pathFile = $this->path(['app', 'Http', 'Controllers', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
