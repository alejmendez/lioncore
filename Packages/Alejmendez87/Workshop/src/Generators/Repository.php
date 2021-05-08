<?php

namespace Alejmendez87\Workshop\Generators;

class Repository extends Generator
{
    public function generate()
    {
        $fields = $this->getFieldsWithoutId();

        $fieldsInList = $fields->reject(function ($field) {
            return !$field['inList'];
        })->map(function ($field) {
            return "'" . $field['name'] . "'";
        })->implode(", ");

        $contents = $this->view('repository', [
            'nameModel'    => $this->getNameModel(),
            'fieldsInList' => $fieldsInList,
            'json'         => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Repository.php";
        $pathFile = $this->path(['app', 'Repositories', $nameFile]);

        // $this->writeFilePhp($pathFile, $contents);
    }
}
