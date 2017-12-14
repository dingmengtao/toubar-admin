<?php namespace WebEd\Base\ModulesManagement\Support;

use Illuminate\Support\Collection;
use WebEd\Base\Models\EloquentBase;
use WebEd\Base\ModulesManagement\Repositories\Contracts\CoreModuleRepositoryContract;
use WebEd\Base\ModulesManagement\Repositories\CoreModuleRepository;
use Illuminate\Support\Facades\File;

class CoreModulesSupport
{
    /**
     * @var Collection
     */
    protected $modules;

    /**
     * @var CoreModuleRepository
     */
    protected $coreModuleRepository;

    /**
     * @var Collection
     */
    protected $modulesInDb;

    /**
     * @var bool
     */
    protected $canAccessDb = false;

    public function __construct(CoreModuleRepositoryContract $coreModuleRepository)
    {
        $this->coreModuleRepository = $coreModuleRepository;

        $this->canAccessDb = $this->checkConnection();

        if ($this->canAccessDb) {
            if (!$this->modulesInDb) {
                $this->modulesInDb = $this->coreModuleRepository->get();
            }
        }
    }

    /**
     * @return Collection
     */
    public function getAllModules()
    {
        if ($this->modules) {
            return $this->modules;
        }

        $modulesArr = [];

        $modules = get_folders_in_path(webed_core_path());

        foreach ($modules as $row) {
            $file = $row . '/module.json';
            $data = json_decode(get_file_data($file), true);

            if ($data === null || !is_array($data)) {
                continue;
            }

            if ($this->canAccessDb) {
                $plugin = $this->modulesInDb->where('alias', '=', $data['alias'])->first();

                if (!$plugin) {
                    $result = $this->coreModuleRepository
                        ->create([
                            'alias' => array_get($data, 'alias'),
                        ]);

                    if ($result) {
                        $plugin = $this->coreModuleRepository->find($result);
                        $this->modulesInDb->push($plugin);
                    }
                }

                if ($plugin) {
                    $data['id'] = $plugin->id;
                    $data['installed_version'] = $plugin->installed_version;
                }
            }

            $modulesArr[array_get($data, 'namespace')] = array_merge($data, [
                'file' => $file,
            ]);
        }

        $this->modules = collect(array_merge($this->getBaseVendorModules(), $modulesArr));

        return $this->modules;
    }

    /**
     * @return array
     */
    public function getBaseVendorModules()
    {
        $modules = get_folders_in_path(base_path('vendor/sgsoft-studio'));

        $modulesArr = [];
        foreach ($modules as $module) {
            $file = $module . '/module.json';
            $data = json_decode(get_file_data($file), true);
            if ($data === null || !is_array($data)) {
                continue;
            }

            if (!array_get($data, 'version')) {
                $data['version'] = get_core_module_composer_version($data['repos']);
            }

            if ($this->canAccessDb) {
                $plugin = $this->modulesInDb->where('alias', '=', $data['alias'])->first();

                if (!$plugin) {
                    $plugin = $this->coreModuleRepository->findWhere([
                        'alias' => $data['alias']
                    ]);
                }

                if (!$plugin) {
                    $result = $this->coreModuleRepository
                        ->create([
                            'alias' => array_get($data, 'alias'),
                        ]);

                    if ($result) {
                        $plugin = $this->coreModuleRepository->find($result);
                    }
                }

                if ($plugin) {
                    $data['id'] = $plugin->id;
                    $data['installed_version'] = $plugin->installed_version;
                }
            }

            $modulesArr[array_get($data, 'namespace')] = array_merge($data, [
                'file' => $file,
            ]);
        }
        return $modulesArr;
    }

    /**
     * @param $alias
     * @return mixed
     */
    public function findByAlias($alias)
    {
        if (!$this->modules) {
            $this->getAllModules();
        }

        return $this->modules
            ->where('alias', '=', $alias)
            ->first();
    }

    /**
     * @param $alias
     * @param array $data
     * @return bool
     */
    public function saveModule($alias, array $data)
    {
        $module = is_array($alias) ? $alias : $this->findByAlias($alias);
        if (!$module) {
            return false;
        }

        return $this->coreModuleRepository
            ->createOrUpdate(array_get($module, 'id'), array_merge($data, [
                'alias' => array_get($module, 'alias'),
            ]));
    }

    /**
     * @param $alias
     * @param bool $isMoved
     * @return $this
     */
    public function modifyComposerAutoload($alias, $isMoved = false)
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

        if (!$isMoved) {
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
            if (!check_db_connection() || !\Schema::hasTable(webed_db_prefix() . 'core_modules')) {
                return false;
            }
        }
        return true;
    }
}
