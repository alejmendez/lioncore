<?php

namespace Modules\Workshop\Generators;

class Migration extends Generator
{
    public function generate()
    {
        if ($this->json->inDB) {
            $generator->migrationDB();
            return;
        }

        $generator->migrationFile();
    }

    public function migrationFile()
    {
        $contents = view('scaffolding.migration', [
            'id' => $this->id,
            'nameModel' => $this->nameModel,
            'jsonContent' => $this->json
        ])->render();

        $contents = "<?php\n" . $contents;
        $date = $this->dataModel['dateMigration'] ?? date('Y_m_d_His');
        $nameFile = $date . "_create_" . Str::plural(strtolower($this->nameModel)) . "_table.php";
        $pathFile = $this->getMigrationPath() . DIRECTORY_SEPARATOR . $nameFile;

        File::put($pathFile, $contents);
    }

    public function migrationDB()
    {
        $form = Form::whereName(strtolower($this->nameModel))->first();
        if (!$form) {
            $form = Form::create([
                'name' => strtolower($this->nameModel)
            ]);
        }

        $form->fields()->forcedelete();
        $fields = [];

        foreach ($this->json as $field) {
            $fields[] = Field::create($field);
        }

        $form->fields()->saveMany($fields);
    }
}
