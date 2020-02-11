<?php

namespace Modules\Workshop\Generators;

class FormRequest extends Generator
{
    protected function generate()
    {
        $json = $this->json->reject(function ($value, $key) {
            return $value['name'] == 'id' || $value['validations'] == '';
        });

        $contents = view('scaffolding.formRequest', [
            'nameModel' => $this->nameModel,
            'jsonContent' => $json
        ])->render();

        $contents = "<?php\n" . $contents;
        $nameFile = ucwords($this->nameModel) . "Request.php";
        $pathFile = app_path('Http/Requests') . DIRECTORY_SEPARATOR . $nameFile;

        File::put($pathFile, $contents);
    }
}
