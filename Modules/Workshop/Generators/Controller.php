<?php

namespace Modules\Workshop\Generators;

class Controller extends Generator
{
    public function generate()
    {
        $fields = $this->getFields();
        $validations  = $fields->reject(function ($value, $key) {
            return $value['name'] == 'id' || $value['validations'] == '';
        });

        $fieldsSelect = $fields->pluck('name');
        $fieldsSelect = json_encode($fieldsSelect);
        $fieldsSelect = str_replace(",", ", ", $fieldsSelect);

        $contents = $this->view('scaffolding.controller', [
            'nameModel'    => $this->getNameModel(),
            'fields'       => $fields,
            'fieldsSelect' => $fieldsSelect,
            'validations'  => $validations,
            'json'         => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Controller.php";
        $pathFile = $this->modulePath(['Http', 'Controllers', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
