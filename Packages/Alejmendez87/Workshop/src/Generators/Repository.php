<?php

namespace Alejmendez87\Workshop\Generators;

use Illuminate\Support\Str;

class Repository extends Generator
{
    public function generate()
    {
        $fields = $this->getFieldsWithoutId();
        $nameRoutePlural = strtolower($this->getModelPluralName());
        $fieldsInList = $fields->reject(function ($field) {
            return !$field['inList'];
        })->map(function ($field) {
            return "'" . $field['name'] . "'";
        })->implode(", ");

        $data = [
            'nameModel'       => strtolower($this->getNameModel()),
            'nameRoutePlural' => $nameRoutePlural,
            'fieldsInList'    => $fieldsInList,
            'json'            => $this->json,
        ];

        $this->generateInterface($data);
        $this->generateEloquent($data);
        $this->generateCache($data);
        $this->addCodeRepositoryServiceProvider($data);
    }

    public function generateInterface($data)
    {
        $contents = $this->view('repository.interface', $data);

        $nameFile = ucwords($this->getNameModel()) . "Repository.php";
        $pathFile = $this->path(['app', 'Repositories', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }

    public function generateEloquent($data)
    {
        $contents = $this->view('repository.eloquent', $data);

        $nameFile = "Eloquent" . ucwords($this->getNameModel()) . "Repository.php";
        $pathFile = $this->path(['app', 'Repositories', 'Eloquent', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }

    public function generateCache($data)
    {
        $contents = $this->view('repository.cache', $data);

        $nameFile = "Cache" . ucwords($this->getNameModel()) . "Decorator.php";
        $pathFile = $this->path(['app', 'Repositories', 'Cache', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }

    public function addCodeRepositoryServiceProvider($data)
    {
        $nameModel = ucwords($data['nameModel']);
        $pathFile = $this->path(['app', 'Providers', 'RepositoryServiceProvider.php']);
        $stringSearch = $nameModel . "Repository::class";

        $content = file_get_contents($pathFile);

        if (Str::contains($content, $stringSearch)) {
            return;
        }

        $stringImport =
        "use App\\Models\\" . $nameModel . ";\n" .
        "use App\\Repositories\\" . $nameModel . "Repository;\n" .
        "use App\\Repositories\\Eloquent\\Eloquent" . $nameModel . "Repository;\n" .
        "use App\\Repositories\\Cache\\Cache" . $nameModel . "Decorator;\n";

        $content = $this->addNewContent($content, '// add class', $stringImport, 0, "");

        $stringImport =
        "\$this->app->bind(" . $nameModel . "Repository::class, function () {\n" .
            "    \$repository = new Eloquent" . $nameModel . "Repository(new " . $nameModel . "());\n" .
            "\n" .
            "    if (!config('app.cache')) {\n" .
            "        return \$repository;\n" .
            "    }\n" .
            "\n" .
            "    return new Cache" . $nameModel . "Decorator(\$repository);\n" .
        "}\n";

        $content = $this->addNewContent($content, '// add bind', $stringImport, 2, "    ");
        $this->writeFile($pathFile, $content);
    }
}
