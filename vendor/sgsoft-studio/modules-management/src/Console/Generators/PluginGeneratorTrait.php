<?php namespace WebEd\Base\ModulesManagement\Console\Generators;

trait PluginGeneratorTrait
{
    /**
     * Get root folder of every modules by module type
     * @param array $type
     * @return string
     */
    protected function resolveModuleRootFolder()
    {
        $path = webed_plugins_path();

        if (!ends_with('/', $path)) {
            $path .= '/';
        }

        return $path;
    }

    /**
     * Current module information
     * @return array
     */
    protected function getCurrentModule()
    {
        $alias = $this->argument('alias');

        $module = get_plugin($alias);

        if(!$module) {
            $this->error('Plugin not exists');
            die();
        }

        $moduleRootFolder = $this->resolveModuleRootFolder();

        return $this->moduleInformation = array_merge($module, [
            'module-path' => $moduleRootFolder . basename(str_replace('/module.json', '', $module['file'])) . '/'
        ]);
    }
}
