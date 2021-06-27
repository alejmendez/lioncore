<?php

namespace Alejmendez87\Workshop\Generators;

class Resource extends Generator
{
    public function generate()
    {
        $fields = $this->getFields();
        $nameRoutePlural = strtolower($this->getModelPluralName());
        $fields = $fields->map(function ($field) {
            return "            '" . $field['name'] . "' => \$resource->" . $field['name'];
        })->implode(",\n");

        $data = [
            'nameModel'       => strtolower($this->getNameModel()),
            'nameRoutePlural' => $nameRoutePlural,
            'fields'          => $fields,
            'json'            => $this->json,
        ];

        $this->generateInterface($data);
        $this->generateEloquent($data);
    }

    public function generateInterface($data)
    {
        $contents = $this->view('resources.collection', $data);
        $nameFile = ucwords($this->getNameModel()) . "Collection.php";
        $pathFile = $this->path(['app', 'Http', 'Resources', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }

    public function generateEloquent($data)
    {
        $contents = $this->view('resources.resource', $data);
        $nameFile = ucwords($this->getNameModel()) . "Resource.php";
        $pathFile = $this->path(['app', 'Http', 'Resources', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
