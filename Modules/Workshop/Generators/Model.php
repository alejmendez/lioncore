<?php

namespace Modules\Workshop\Generators;

class Model extends Generator
{
    protected function generate()
    {
        $this->info(__('Generating Model'));

        $fillable = $this->json->pluck('fieldInput.name')->reject(function ($value, $key) {
            return $value == 'id';
        })->map(function ($name) {
            return "'$name'";
        })->implode(',');

        $contents = view('scaffolding.model', [
            'nameModel'   => $this->nameModel,
            'fillable'    => $fillable,
            'jsonContent' => $this->json
        ])->render();

        $contents = "<?php\n" . $contents;
        $nameFile = ucwords($this->nameModel) . ".php";
        $pathFile = app_path('Models') . DIRECTORY_SEPARATOR . $nameFile;

        File::put($pathFile, $contents);
    }
}
