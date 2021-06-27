<?php

namespace Alejmendez87\Workshop\Generators;

class Model extends Generator
{
    public function generate()
    {
        $fields = $this->getFieldsWithoutId();
        $fillable = $fields->map(function ($field) {
            return "'" . $field['name'] . "'";
        });

        $data = [
            'nameModel' => $this->getNameModel(),
            'fields'    => $fields,
            'fillable'  => $fillable,
            'json'      => $this->json,
        ];

        $this->generateModel($data);
        $this->generateFilter($data);
    }

    public function generateModel($data)
    {
        $contents = $this->view('model.model', $data);

        $nameFile = ucwords($this->getNameModel()) . ".php";
        $pathFile = $this->path(['app', 'Models', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }

    public function generateFilter($data)
    {
        $contents = $this->view('model.modelFilter', $data);

        $nameFile = ucwords($this->getNameModel()) . "Filter.php";
        $pathFile = $this->path(['app', 'ModelFilters', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
