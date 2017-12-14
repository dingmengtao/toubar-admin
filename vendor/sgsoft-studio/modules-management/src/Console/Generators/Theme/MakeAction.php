<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Theme;

use WebEd\Base\ModulesManagement\Console\Generators\ThemeGeneratorTrait;

class MakeAction extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeAction
{
    use ThemeGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:action
    	{name : The class name}
    	{--type= : Action type}';
}
