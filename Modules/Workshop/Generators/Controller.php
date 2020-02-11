<?php

namespace Modules\Workshop\Generators;

class Controller extends Generator
{
    protected function generate()
    {
        $validations  = $this->json->reject(function ($value, $key) {
            return $value['name'] == 'id' || $value['validations'] == '';
        });

        $fieldsSelect = $this->json->pluck('name');
        $fieldsSelect = json_encode($fieldsSelect);
        $fieldsSelect = str_replace(",", ", ", $fieldsSelect);

        $contents = view('scaffolding.controller', [
            'nameModel'    => $this->nameModel,
            'jsonContent'  => $this->json,
            'fieldsSelect' => $fieldsSelect,
            'validations'  => $validations
        ])->render();

        $contents = "<?php\n" . $contents;
        $nameFile = ucwords($this->nameModel) . "Controller.php";
        $pathFile = app_path('Http/Controllers/' . ucwords($this->module)) . DIRECTORY_SEPARATOR . $nameFile;

        File::put($pathFile, $contents);
    }
}
