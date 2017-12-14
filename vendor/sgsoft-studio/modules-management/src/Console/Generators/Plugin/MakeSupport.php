<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeSupport extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeSupport
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:support
    	{alias : The alias of the module}
    	{name : The class name}';
}
