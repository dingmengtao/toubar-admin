<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeRepository extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeRepository
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:repository
    	{alias : The alias of the module}
    	{name : The class name}
    	{--no-cache : Generate this repository without repository caching}';
}
