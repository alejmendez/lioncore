<?php

namespace Alejmendez87\Workshop\Generators;

use Illuminate\Support\Str;

class Test extends Generator
{
    public function generate()
    {
        $fields = $this->getFieldsWithoutId();

        $fieldsInList = $fields->reject(function ($field) {
            return !$field['inList'];
        })->map(function ($field) {
            return "'" . $field['name'] . "'";
        })->implode(", ");

        $contents = $this->view('test', [
            'nameModel'    => strtolower($this->getNameModel()),
            'fields'       => $fields,
            'fieldsInList' => $fieldsInList,
            'json'         => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Test.php";
        $pathFile = $this->path(['Tests', 'Feature', $nameFile]);
        $this->writeFilePhp($pathFile, $contents);
    }
}
