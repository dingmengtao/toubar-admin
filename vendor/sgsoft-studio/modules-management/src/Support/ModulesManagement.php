<?php namespace WebEd\Base\ModulesManagement\Support;

use \Closure;
use Illuminate\Support\Collection;
use WebEd\Base\ModulesManagement\Events\ModuleDisabled;
use WebEd\Base\ModulesManagement\Events\ModuleEnabled;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Composer;
use WebEd\Base\ModulesManagement\Facades\ModulesFacade;

class ModulesManagement
{
    /**
     * @var Collection
     */
    protected $modules;

    /**
     * @var Collection
     */
    protected $plugins;

    /**
     * @var Composer
     */
    protected $composer;

    public function __construct(Composer $composer)
    {
        $this->composer = $composer;
        $this->composer->setWorkingPath(base_path());

        $this->modules = get_core_module();

        $this->plugins = get_plugin();
    }

    /**
     * Run command composer dump-autoload
     */
    public function refreshComposerAutoload()
    {
        $this->composer->dumpAutoloads();
        $result = response_with_messages('Composer autoload refreshed');

        return $result;
    }

    /**
     * @return Collection
     */
    public function getAllModulesInformation()
    {
        return $this->modules;
    }

    /**
     * @return Collection
     */
    public function getAllPlugins()
    {
        return $this->plugins;
    }
}
