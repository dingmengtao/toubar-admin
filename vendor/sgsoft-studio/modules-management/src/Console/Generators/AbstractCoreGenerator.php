<?php namespace WebEd\Base\ModulesManagement\Console\Generators;

abstract class AbstractCoreGenerator extends AbstractGenerator
{
    /**
     * Get root folder of every modules by module type
     * @return string
     */
    protected function resolveModuleRootFolder()
    {
        $path = webed_core_path();

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

        $module = get_core_module($alias);

        if(!$module) {
            $this->error('Module not exists');
            die();
        }

        $moduleRootFolder = $this->resolveModuleRootFolder();

        return $this->moduleInformation = array_merge($module, [
            'module-path' => $moduleRootFolder . basename(str_replace('/module.json', '', $module['file'])) . '/'
        ]);
    }
}
