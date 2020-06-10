<?php

namespace App\Generators;

use Illuminate\Support\Str;

class FormRequest extends Generator
{
    public function generate()
    {
        $fields = $this->getFieldsWithoutId()->map(function($field) {
            if (!isset($field['validations'])) {
                $field['validations'] = '';
            }
            if ($field['type'] == 'string' && !Str::contains($field['validations'], 'max')) {
                if ($field['validations'] == '') {
                    $field['validations'] = 'max:' . $field['length'];
                } else {
                    $field['validations'] = explode(',', $field['validations']);
                    $field['validations'][] = 'max:' . $field['length'];
                    $field['validations'] = implode(',', $field['validations']);
                }
            }
            return $field;
        })->reject(function ($field) {
            return $field['validations'] == '';
        });

        $contents = $this->view('scaffolding.formRequest', [
            'nameModel' => $this->getNameModel(),
            'fields'    => $fields,
            'json'      => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Request.php";
        $pathFile = $this->appPath(['Http', 'Requests', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
