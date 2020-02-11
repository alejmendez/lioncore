<?php

namespace Modules\Workshop\Generators;

use Str;
use Modules\Core\Models\Form;
use Modules\Core\Models\Field;

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
        $contents = $this->view('scaffolding.migration', [
            'id' => $this->id,
            'nameModel' => $this->getNameModel(),
            'jsonContent' => $this->getFields()
        ]);

        $date = $this->dataModel['dateMigration'] ?? date('Y_m_d_His');
        $nameFile = $date . "_create_" . Str::plural(strtolower($this->getNameModel())) . "_table.php";
        $pathFile = $this->modulePath(['Database', 'Migrations', $nameFile]);

        $this->writeFilePhp($pathFile, $contents);
    }

    public function migrationDB()
    {
        $form = Form::whereName(strtolower($this->getNameModel()))->first();
        if (!$form) {
            $form = Form::create([
                'name' => strtolower($this->getNameModel())
            ]);
        }

        $form->fields()->forcedelete();
        $fields = [];

        foreach ($this->getFields() as $field) {
            $fields[] = Field::create($field);
        }

        $form->fields()->saveMany($fields);
    }
}
