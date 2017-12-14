<?php namespace WebEd\Base\ModulesManagement\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use WebEd\Base\ModulesManagement\Repositories\Contracts\PluginRepositoryContract;
use WebEd\Base\ModulesManagement\Repositories\PluginRepository;
use Closure;
use Illuminate\Support\Facades\File;

class PluginsSupport
{
    /**
     * @var Collection
     */
    protected $plugins;

    /**
     * @var PluginRepository
     */
    protected $pluginRepository;

    /**
     * @var Collection
     */
    protected $pluginsInDb;

    /**
     * @var bool
     */
    protected $canAccessDb = false;

    public function __construct(PluginRepositoryContract $pluginRepository)
    {
        $this->pluginRepository = $pluginRepository;

        $this->canAccessDb = $this->checkConnection();

        if ($this->canAccessDb) {
            if (!$this->pluginsInDb) {
                $this->pluginsInDb = $this->pluginRepository->get();
            }
        }
    }

    /**
     * @return Collection
     */
    public function getAllPlugins()
    {
        if ($this->plugins) {
            return $this->plugins;
        }

        $modulesArr = [];

        $modules = get_folders_in_path(webed_plugins_path());

        foreach ($modules as $row) {
            $file = $row . '/module.json';
            $data = json_decode(get_file_data($file), true);
            if ($data === null || !is_array($data)) {
                continue;
            }

            if ($this->canAccessDb) {
                $plugin = $this->pluginsInDb->where('alias', '=', array_get($data, 'alias'))->first();

                if (!$plugin) {
                    $result = $this->pluginRepository
                        ->create([
                            'alias' => array_get($data, 'alias'),
                            'enabled' => false,
                            'installed' => false,
                        ]);
                    /**
                     * Everything ok
                     */
                    if ($result) {
                        $plugin = $this->pluginRepository->find($result);
                        $this->pluginsInDb->push($plugin);
                    }
                }
                if ($plugin) {
                    $data['enabled'] = !!$plugin->enabled;
                    $data['installed'] = !!$plugin->installed;
                    $data['id'] = $plugin->id;
                    $data['installed_version'] = $plugin->installed_version;
                }
            }

            $modulesArr[array_get($data, 'namespace')] = array_merge($data, [
                'file' => $file,
            ]);
        }

        $this->plugins = collect($modulesArr);
        return $this->plugins;
    }

    /**
     * @param $alias
     * @return mixed
     */
    public function findByAlias($alias)
    {
        if (!$this->plugins) {
            $this->getAllPlugins();
        }

        return $this->plugins
            ->where('alias', '=', $alias)
            ->first();
    }

    /**
     * @param array|string $alias
     * @param array $data
     * @return bool
     */
    public function savePlugin($alias, array $data)
    {
        $module = is_array($alias) ? $alias : $this->findByAlias($alias);
        if (!$module) {
            return false;
        }

        return $this->pluginRepository
            ->createOrUpdate(array_get($module, 'id'), array_merge($data, [
                /**
                 * Prevent user edit module alias
                 */
                'alias' => array_get($module, 'alias'),
            ]));
    }

    /**
     * Determine when module is activated
     * @param string $alias
     * @param \Closure|null $trueCallback
     * @param \Closure|null $falseCallback
     * @return bool
     */
    public function isActivated($alias, Closure $trueCallback = null, Closure $falseCallback = null)
    {
        $module = $this->findByAlias($alias);
        if ($module && isset($module['enabled']) && $module['enabled']) {
            if ($trueCallback) {
                call_user_func($trueCallback);
            }
            return true;
        }
        if ($falseCallback) {
            call_user_func($falseCallback);
        }
        return false;
    }

    /**
     * Determine when module is installed
     * @param string $alias
     * @param \Closure|null $trueCallback
     * @param \Closure|null $falseCallback
     * @return bool
     */
    public function isInstalled($alias, Closure $trueCallback = null, Closure $falseCallback = null)
    {
        $module = $this->findByAlias($alias);
        if ($module && isset($module['installed']) && $module['installed']) {
            if ($trueCallback) {
                call_user_func($trueCallback);
            }
            return true;
        }
        if ($falseCallback) {
            call_user_func($falseCallback);
        }
        return false;
    }

    /**
     * @param $alias
     * return mixed
     */
    public function enableModule($alias)
    {
        $this->modifyModule($alias, ['enabled' => true], function () use ($alias) {
            do_action(WEBED_PLUGIN_ENABLED, $alias);
        });

        return $this->modifyComposerAutoload($alias);
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function disableModule($alias)
    {
        $this->modifyModule($alias, ['enabled' => false], function () use ($alias) {
            do_action(WEBED_PLUGIN_DISABLED, $alias);
        });

        return $this->modifyComposerAutoload($alias, true);
    }

    /**
     * @param string $alias
     * @param array $data
     * @param Closure|null $callback
     * @return $this
     */
    public function modifyModule($alias, array $data, \Closure $callback = null)
    {
        $plugin = $this->findByAlias($alias);

        if (!$plugin) {
            throw new \RuntimeException('Plugin not found: ' . $alias);
        }

        $this->savePlugin($plugin, $data);

        if ($callback) {
            call_user_func($callback);
        }

        return $this;
    }
    /**
     * Modify the composer autoload information
     * @param $alias
     * @param bool $isDisabled
     */
    public function modifyComposerAutoload($alias, $isDisabled = false)
    {
        $module = $this->findByAlias($alias);
        if (!$module) {
            return $this;
        }
        $moduleAutoloadType = array_get($module, 'autoload', 'psr-4');
        $relativePath = str_replace(base_path() . '/', '', str_replace('module.json', '', array_get($module, 'file', ''))) . 'src';

        $moduleNamespace = array_get($module, 'namespace');

        if (!$moduleNamespace) {
            return $this;
        }

        if (substr($moduleNamespace, -1) !== '\\') {
            $moduleNamespace .= '\\';
        }

        /**
         * Composer information
         */
        $composerContent = json_decode(File::get(base_path('composer.json')), true);
        $autoload = array_get($composerContent, 'autoload', []);

        if (!array_get($autoload, $moduleAutoloadType)) {
            $autoload[$moduleAutoloadType] = [];
        }

        if ($isDisabled === true) {
            if (isset($autoload[$moduleAutoloadType][$moduleNamespace])) {
                unset($autoload[$moduleAutoloadType][$moduleNamespace]);
            }
        } else {
            if ($moduleAutoloadType === 'classmap') {
                $autoload[$moduleAutoloadType][] = $relativePath;
            } else {
                $autoload[$moduleAutoloadType][$moduleNamespace] = $relativePath;
            }
        }
        $composerContent['autoload'] = $autoload;

        /**
         * Save file
         */
        File::put(base_path('composer.json'), json_encode_prettify($composerContent));

        return $this;
    }

    /**
     * @return bool
     */
    protected function checkConnection()
    {
        if (app()->runningInConsole()) {
            if (!check_db_connection() || !Schema::hasTable(webed_db_prefix() . 'plugins')) {
                return false;
            }
        }
        return true;
    }
}
