<?php

namespace App\Generators;

use Illuminate\Support\Str;

class Factory extends Generator
{
    public function generate()
    {
        $fields = $this->getFieldsWithoutId();

        $contents = $this->view('scaffolding.factory', [
            'nameModel'    => strtolower($this->getNameModel()),
            'fields'       => $fields,
            'json'         => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Factory.php";
        $pathFile = $this->appPath(['Database', 'factories', $nameFile]);
        $this->writeFilePhp($pathFile, $contents);
    }
}
