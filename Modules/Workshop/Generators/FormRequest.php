<?php

namespace Modules\Workshop\Generators;

use Str;

class FormRequest extends Generator
{
    protected function generate()
    {
        $json = $this->getFields()->map(function($field){
            if ($field['type'] == 'string' && !Str::contains($field['validations'], 'max')) {
                $field['validations'] = explode(',', $field['validations']);
                $field['validations'][] = 'max:' . $field['length'];
                $field['validations'] = implode(',', $field['validations']);
            }
            return $field;
        })->reject(function ($value, $key) {
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
