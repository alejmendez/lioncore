<?php

namespace Alejmendez87\Workshop\Generators;

class Factory extends Generator
{
    public function generate()
    {
        $fields = $this->getFieldsWithoutId();

        $contents = $this->view('factory', [
            'nameModel'    => strtolower($this->getNameModel()),
            'fields'       => $fields,
            'json'         => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Factory.php";
        $pathFile = $this->path(['Database', 'factories', $nameFile]);
        $this->writeFilePhp($pathFile, $contents);
    }
}
