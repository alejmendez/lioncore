<?php

namespace App\Console;

use Illuminate\Console\Command;

use App\Generators\GeneratorCrud;

class GenerateGrud extends Command
{
    protected $signature = 'workshop:generate-crud
        {nameModel? : Name of the model}
        {module? : Name of the module}
        {--i|migration}
        {--m|model}
        {--o|formrequest}
        {--c|controller}
        {--p|permissions}
        {--w|view}
        {--r|route}
        {--t|translations}
        {--f|factory}
        {--e|test}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generator crud.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $models = (String) $this->argument('nameModel');

        $generatorCrud = new GeneratorCrud($models, $this);
        $generatorCrud->run();
    }
}
