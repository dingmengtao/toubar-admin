<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeMiddleware extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeMiddleware
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:middleware
    	{alias : The alias of the module}
    	{name : The class name}';
}
