<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Theme;

use WebEd\Base\ModulesManagement\Console\Generators\ThemeGeneratorTrait;

class MakeModel extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeModel
{
    use ThemeGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:model
    	{name : The class name}
    	{table : The table name}';

    /**
     * @param $stub
     */
    protected function replaceParameters(&$stub)
    {
        $stub = str_replace([
            '{alias}',
            'ThemeRootNamespace',
            '{table}',
        ], [
            $this->moduleInformation['alias'],
            $this->moduleInformation['namespace'],
            $this->argument('table'),
        ], $stub);
    }
}
