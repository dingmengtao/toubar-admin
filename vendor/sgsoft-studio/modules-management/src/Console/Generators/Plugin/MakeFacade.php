<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeFacade extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeFacade
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:facade
    	{alias : The alias of the module}
    	{name : The class name}';
}
