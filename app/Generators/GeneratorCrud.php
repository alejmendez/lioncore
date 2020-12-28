<?php

namespace App\Generators;

use File;

use App\Generators\Interfaces\Generator;
use App\Console\GenerateGrud;
use App\Generators\Entities\ModelCrud;

use App\Generators\Migration;
use App\Generators\Model;
use App\Generators\FormRequest;
use App\Generators\Controller;
use App\Generators\Permission;
use App\Generators\View;
use App\Generators\Route;
use App\Generators\Translation;

class GeneratorCrud implements Generator
{
    protected $models;
    protected $console;

    protected $allOptionsActive = false;
    protected $listOptions = [
        'migration',
        'model',
        'formrequest',
        'controller',
        'permissions',
        'view',
        'route',
        'translations',
        'factory',
        'test',
    ];

    public function __construct(String $models, GenerateGrud $console = null)
    {
        $this->console = $console;
        $this->initVars($models);
    }

    public function initVars(String $models)
    {
        $this->models = explode(',', $models);
        $this->models = array_map('trim', $this->models);

        if (count($this->models) == 1) {
            if ($this->models[0] == '') {
                $this->models = [false];
            } elseif ($this->models[0] == 'all') {
                $this->models = $this->getAllModelsFiles();
            }
        }

        $cantOptions = 0;
        foreach ($this->listOptions as $option) {
            if ($this->getOption($option)) {
                $cantOptions++;
            }
        }
        $this->allOptionsActive = $cantOptions === 0;
    }

    public function run()
    {
        foreach ($this->models as $model) {
            $json = $this->getJsonContent($model);

            $this->generateMigration($json);
            $this->generateModel($json);
            $this->generateFormRequest($json);
            $this->generateController($json);
            $this->generateRepository($json);
            $this->generatePermissions($json);
            $this->generateViewVue($json);
            $this->generateRoute($json);
            $this->generateTranslations($json);
            $this->generateFactory($json);
            $this->generateTest($json);
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
            $this->error(__('The model not exist'));
            exit();
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

        if (!isset($json['id'])) {
            $id = collect($json['fields'])->firstWhere('primary', true);
            $json['id'] = $id ? $id['name'] : 'id';
        }

        return $json;
    }

    protected function generateMigration($json)
    {
        if (!$this->getOption('migration')) return;
        $this->info(__('Generating Migration'));
        $generator = new Migration($json);
        $generator->generate();
    }

    protected function generateModel($json)
    {
        if (!$this->getOption('model')) return;
        $this->info(__('Generating Model'));
        $generator = new Model($json);
        $generator->generate();
    }

    protected function generateFormRequest($json)
    {
        if (!$this->getOption('formrequest')) return;
        $this->info(__('Generating FormRequest'));
        $generator = new FormRequest($json);
        $generator->generate();
    }

    protected function generateController($json)
    {
        if (!$this->getOption('controller')) return;
        $this->info(__('Generating Controller'));
        $generator = new Controller($json);
        $generator->generate();
    }

    protected function generateRepository($json)
    {
        if (!$this->getOption('repository')) return;
        $this->info(__('Generating Repository'));
        $generator = new Repository($json);
        $generator->generate();
    }

    protected function generatePermissions($json)
    {
        if (!$this->getOption('permissions')) return;
        $this->info(__('Generating Permissions'));
        $generator = new Permission($json);
        $generator->generate();
    }

    protected function generateViewVue($json)
    {
        if (!$this->getOption('view')) return;
        $this->info(__('Generating View'));
        $generator = new View($json);
        $generator->generate();
    }

    protected function generateRoute($json)
    {
        if (!$this->getOption('route')) return;
        $this->info(__('Generating Routes'));
        $generator = new Route($json);
        $generator->generate();
    }

    protected function generateTranslations($json)
    {
        if (!$this->getOption('translations')) return;
        $this->info(__('Generating Translations'));
        $generator = new Translation($json);
        $generator->generate();
    }

    protected function generateFactory($json)
    {
        if (!$this->getOption('factory')) return;
        $this->info(__('Generating Factory'));
        $generator = new Factory($json);
        $generator->generate();
    }

    protected function generateTest($json)
    {
        if (!$this->getOption('test')) return;
        $this->info(__('Generating Test'));
        $generator = new Test($json);
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
    public function choice($question, array $choices, $default = null, $maxAttempts = null, $allowMultipleSelections = false)
    {
        return $this->console->choice($question, $choices, $default, $maxAttempts, $allowMultipleSelections);
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

    protected function getOption($option)
    {
        return $this->allOptionsActive ? true : $this->console->option($option);
    }
}
