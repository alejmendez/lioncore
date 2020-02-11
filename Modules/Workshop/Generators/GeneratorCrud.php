<?php

namespace Modules\Workshop\Generators;

use File;
use Module;

use Modules\Workshop\Generators\Interfaces\Generator;
use Modules\Workshop\Console\GenerateGrud;
use Modules\Workshop\Generators\Entities\ModelCrud;

use Illuminate\Support\Str;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;

use App\Models\Form;
use App\Models\Field;

class GeneratorCrud implements Generator
{
    protected $models;
    protected $module;
    protected $console;

    protected $nameModel = '';
    protected $id;
    protected $dataModel;
    protected $title;
    protected $pathCrudDef = 'CrudDef';
    protected $inDB = false;

    public function __construct(String $models, String $module, GenerateGrud $console = null)
    {
        $this->console = $console;
        $this->initVars($models, $module);
    }

    public function initVars(String $models, String $module)
    {
        $this->models = explode(',', $models);
        $this->models = array_map('trim', $this->models);

        $this->module = $module;

        if (count($this->models) == 1) {
            if ($this->models[0] == '') {
                $this->models = [false];
            } elseif ($this->models[0] == 'all') {
                $this->models = $this->getAllModelsFiles();
            }
        }
    }

    public function run()
    {
        foreach ($this->models as $model) {
            $json = $this->getJsonContent($model);

            $this->generateMigration($json);
            $this->generateModel($json);
            $this->generateFormRequest($json);
            $this->generateController($json);
            $this->generatePermissions($json);
            $this->generateViewVue($json);
            $this->generateRoute($json);
            $this->generateTranslations($json);
        }
    }

    protected function getAllModelsFiles()
    {
        return ModelCrud::getAllModelsFiles();
    }

    protected function getJsonContent($nameModel)
    {
        $model = null;
        $files = $this->getAllModelsFiles();
        if (!$nameModel) {
            $filesList = [];
            $exit = '* ' . __('exit');

            foreach ($files as $file) {
                $filesList[] = $file->getName();
            }

            $filesList[] = $exit;
            $nameModel = $this->choice(__('What model do I use?'), $filesList);

            if ($nameModel == $exit) {
                $this->exit();
            }
        }

        if (!isset($files[$nameModel])) {
            return false;
        }

        $model = $files[$nameModel];
        $this->info(__('Using the model') . ': ' . $model->getName());

        $fileSelectContent = $this->loadModel($model);

        return $fileSelectContent;
    }

    protected function loadModel($model)
    {
        $fileSelectContent = File::get($model->getPath());
        $json = json_decode($fileSelectContent, true);
        return $json;
    }

    protected function generateMigration($json)
    {
        $this->info(__('Generating Migration'));
        $generator = new Migration($json);
        $generator->generate();
    }

    protected function generateModel($json)
    {
        $this->info(__('Generating Model'));
        $generator = new Model($json);
        $generator->generate();
    }

    protected function generateFormRequest($json)
    {
        $this->info(__('Generating FormRequest'));
        $generator = new FormRequest($json);
        $generator->generate();
    }

    protected function generateController($json)
    {
        $this->info(__('Generating Controller'));
        $generator = new Controller($json);
        $generator->generate();
    }

    protected function generatePermissions($json)
    {
        $this->info(__('Generating Permissions'));
        $generator = new Permission($json);
        $generator->generate();
    }

    protected function generateViewVue($json)
    {
        $this->info(__('Generating View'));
        $generator = new View($json);
        $generator->generate();
    }

    protected function generateRoute($json)
    {
        $this->info(__('Generating Routes'));
        $generator = new Route($json);
        $generator->generate();
    }

    protected function generateTranslations($json)
    {
        $this->info(__('Generating Translations'));
        $generator = new Translation($json);
        $generator->generate();
    }

    /**
     * Give the user a single choice from an array of answers.
     *
     * @param  string  $question
     * @param  array  $choices
     * @param  string|null  $default
     * @param  mixed|null  $attempts
     * @param  bool|null  $multiple
     * @return string
     */
    public function choice($question, array $choices, $default = null, $attempts = null, $multiple = null)
    {
        return $this->console->choice($question, $choices, $default, $attempts, $multiple);
    }

    /**
     * Write a string as information output.
     *
     * @param  string  $string
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function info($string, $verbosity = null)
    {
        $this->console->info($string, $verbosity);
    }

    /**
     * Write a string as error output.
     *
     * @param  string  $string
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function error($string, $verbosity = null)
    {
        $this->console->error($string, $verbosity);
    }

    public function exit()
    {
        $this->info(__('goodbye'));
        exit;
    }
}
