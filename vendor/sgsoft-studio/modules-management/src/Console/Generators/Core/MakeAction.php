<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Core;

use WebEd\Base\ModulesManagement\Console\Generators\AbstractCoreGenerator;

class MakeAction extends AbstractCoreGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:make:action
    	{alias : The alias of the module}
    	{name : The class name}
    	{--type= : Action type}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Action';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if($this->option('type')) {
            return __DIR__ . '/../../../../resources/stubs/actions/action-' . $this->option('type') . '.stub';
        }
        return __DIR__ . '/../../../../resources/stubs/actions/action.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Actions\\' . $this->argument('name') . 'Action';
    }
}
