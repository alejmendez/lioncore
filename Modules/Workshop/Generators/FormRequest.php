<?php

namespace Modules\Workshop\Generators;

class FormRequest extends Generator
{
    protected function generate()
    {
        $json = $this->getFields()->reject(function ($value, $key) {
            return $value['name'] == 'id' || $value['validations'] == '';
        });

        $contents = $this->view('scaffolding.formRequest', [
            'nameModel' => $this->getNameModel(),
            'jsonContent' => $json
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Request.php";
        $pathFile = $this->modulePath(['Http', 'Requests', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
