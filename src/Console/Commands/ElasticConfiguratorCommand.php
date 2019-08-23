<?php

namespace BrandStudio\Elasticsearch\Console\Commands;

use Illuminate\Console\Command;

class ElasticConfiguratorCommand extends Command
{

        /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brandstudio:elastic {operation} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elasticsearch Index configurator file [create, drop, migrate]';

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
        $operation_name = $this->argument('operation');
        $name = $this->argument('name');

        $operation = ucfirst($this->argument('operation'));
        $class = "BrandStudio\\Elasticsearch\\Console\\Operations\\{$operation}Configurator";

        if (!class_exists($class)) {
            throw new \Exception("Invalid '{$operation}' operation! Supported operations: ['create', 'migrate']");
        }
        $class::execute($name);
    }

}
