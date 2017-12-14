<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeCriteria extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeCriteria
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:criteria
    	{alias : The alias of the module}
    	{name : The class name}';
}
