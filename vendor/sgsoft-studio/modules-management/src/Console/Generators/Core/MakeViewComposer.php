<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Core;

use WebEd\Base\ModulesManagement\Console\Generators\AbstractCoreGenerator;

class MakeViewComposer extends AbstractCoreGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:make:composer
    	{alias : The alias of the module}
    	{name : The class name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View composer handler';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../../resources/stubs/view-composers/composer.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Http\ViewComposers\\' . $this->argument('name') . 'ViewComposer';
    }
}
