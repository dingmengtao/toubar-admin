<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Theme;

use WebEd\Base\ModulesManagement\Console\Generators\ThemeGeneratorTrait;

class MakeHook extends \WebEd\Base\ModulesManagement\Console\Generators\Core\MakeHook
{
    use ThemeGeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:make:hook
    	{name : The class name}';
}
