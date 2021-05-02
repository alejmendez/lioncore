<?php

namespace App\Generators;

use Illuminate\Support\Str;
use App\Models\Form;
use App\Models\Field;

class Migration extends Generator
{
    public function generate()
    {
        if ($this->json['inDB']) {
            $this->migrationDB();
            return;
        }

        $this->migrationFile();
    }

    public function migrationFile()
    {
        $fields = $this->getFields();
        $idField = $this->json['id'];
        $id = $fields->firstWhere('name', $idField);

        $fields = $fields->reject(function ($field) use($idField) {
            return $field['name'] == $idField;
        })->map(function($field) {
            $fieldStr = '$table->' . $field['type'] . '(\'' . $field['name'] . '\'';
            if (isset($field['length'])) {
                $fieldStr .= ', ' . $field['length'];
            }
            $fieldStr .= ')';

            if (isset($field['validations']) && !Str::contains($field['validations'], 'required')) {
                $fieldStr .= '->nullable()';
            }
            if (isset($field['default'])) {
                if (is_string($field['default'])) {
                    $field['default'] = "'" . $field['default'] . "'";
                }
                $fieldStr .= '->default(' . $field['default'] . ')';
            }
            $fieldStr .= ';';
            return $fieldStr;
        });

        $contents = $this->view('scaffolding.migration', [
            'id' => $id,
            'nameModel' => $this->getNameModel(),
            'fields' => $fields
        ]);

        $date = $this->json['dateMigration'] ?? date('Y_m_d_His');
        $nameFile = $date . "_create_" . Str::plural(strtolower($this->getNameModel())) . "_table.php";
        $pathFile = $this->path(['Database', 'Migrations', $nameFile]);

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
