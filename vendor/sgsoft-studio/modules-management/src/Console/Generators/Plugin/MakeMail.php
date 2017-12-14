<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Plugin;

use WebEd\Base\ModulesManagement\Console\Generators\PluginGeneratorTrait;

class MakeMail extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeMail
{
    use PluginGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:mail
    	{alias : The alias of the module}
    	{name : The class name}';
}
