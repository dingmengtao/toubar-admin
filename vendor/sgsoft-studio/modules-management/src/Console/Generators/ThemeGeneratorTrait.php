<?php namespace WebEd\Base\ModulesManagement\Console\Generators;

trait ThemeGeneratorTrait
{
    /**
     * Get root folder of every modules by module type
     * @param array $type
     * @return string
     */
    protected function resolveModuleRootFolder()
    {
        $path = webed_themes_path();

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
        $theme = get_current_theme();

        if(!$theme) {
            $this->error('No theme activated or theme not exists');
            die();
        }

        $themeRootFolder = $this->resolveModuleRootFolder();

        return $this->moduleInformation = array_merge($theme, [
            'module-path' => $themeRootFolder . basename(str_replace('/module.json', '', $theme['file'])) . '/'
        ]);
    }

    /**
     * @param $stub
     */
    protected function replaceParameters(&$stub)
    {
        $stub = str_replace([
            '{alias}',
            'ThemeRootNamespace',
        ], [
            $this->moduleInformation['alias'],
            $this->moduleInformation['namespace'],
        ], $stub);
    }
}
