<?php namespace WebEd\Base\ModulesManagement\Console\Generators\Core;

use WebEd\Base\ModulesManagement\Console\Generators\AbstractCoreGenerator;

class MakeHook extends AbstractCoreGenerator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:make:hook
    	{alias : The alias of the module}
    	{name : The class name}';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Hook';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../../resources/stubs/hooks/hook.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Hook\\' . $this->argument('name') . 'Hook';
    }
}
