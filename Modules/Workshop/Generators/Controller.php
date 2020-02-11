<?php

namespace Modules\Workshop\Generators;

class Controller extends Generator
{
    protected function generate()
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
            'jsonContent'  => $fields,
            'fieldsSelect' => $fieldsSelect,
            'validations'  => $validations
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Controller.php";
        $pathFile = $this->modulePath(['Http', 'Controllers', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
