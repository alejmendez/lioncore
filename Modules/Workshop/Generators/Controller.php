<?php

namespace Modules\Workshop\Generators;

class Controller extends Generator
{
    public function generate()
    {
        $contents = $this->view('scaffolding.controller', [
            'nameModel'    => $this->getNameModel(),
            'json'         => $this->json,
        ]);

        $nameFile = ucwords($this->getNameModel()) . "Controller.php";
        $pathFile = $this->modulePath(['Http', 'Controllers', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }
}
