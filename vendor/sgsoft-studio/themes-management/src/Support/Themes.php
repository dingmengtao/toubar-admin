<?php namespace WebEd\Base\ThemesManagement\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use WebEd\Base\ThemesManagement\Repositories\Contracts\ThemeRepositoryContract;
use WebEd\Base\ThemesManagement\Repositories\ThemeRepository;

class Themes
{
    /**
     * @var array
     */
    protected $themes;

    /**
     * @var Collection
     */
    protected $themesCollection;

    /**
     * @var Collection
     */
    protected $themesInDb;

    /**
     * @var ThemeRepository
     */
    protected $themeRepository;

    /**
     * @var bool
     */
    protected $canAccessDb = false;

    public function __construct(ThemeRepositoryContract $themeRepository)
    {
        $this->themeRepository = $themeRepository;

        $this->canAccessDb = $this->checkConnection();

        if ($this->canAccessDb) {
            if (!$this->themesInDb) {
                $this->themesInDb = $this->themeRepository->get();
            }
        }
    }

    /**
     * @param bool $toArray
     * @return array|Collection
     */
    public function getAllThemes($toArray = true)
    {
        if ($this->themes) {
            if ($toArray == true) {
                return $this->themes;
            }
            return $this->themesCollection;
        }

        $modulesArr = [];

        $modules = get_folders_in_path(webed_themes_path());

        foreach ($modules as $row) {
            $file = $row . '/module.json';
            $data = json_decode(get_file_data($file), true);
            if ($data === null || !is_array($data)) {
                continue;
            }

            if ($this->canAccessDb) {
                $theme = $this->themesInDb->where('alias', '=', array_get($data, 'alias'))->first();

                if (!$theme) {
                    $result = $this->themeRepository
                        ->create([
                            'alias' => array_get($data, 'alias'),
                            'enabled' => false,
                            'installed' => false,
                        ]);
                    /**
                     * Everything ok
                     */
                    if ($result) {
                        $theme = $this->themeRepository->find($result);
                        $this->themesInDb->push($theme);
                    }
                }

                if ($theme) {
                    $data['enabled'] = !!$theme->enabled;
                    $data['installed'] = !!$theme->installed;
                    $data['id'] = $theme->id;
                    $data['installed_version'] = $theme->installed_version;
                }
            }

            $modulesArr[array_get($data, 'namespace')] = array_merge($data, [
                'file' => $file,
                'type' => 'themes',
                'require' => array_get($data, 'require') && is_array(array_get($data, 'require')) ? array_get($data, 'require') : []
            ]);
        }

        $this->themes = $modulesArr;
        $this->themesCollection = collect($modulesArr);
        if ($toArray == true) {
            return $this->themes;
        }
        return $this->themesCollection;
    }

    /**
     * @param $alias
     * @return mixed
     */
    public function findByAlias($alias)
    {
        if (!$this->themesCollection) {
            $this->getAllThemes();
        }

        return $this->themesCollection
            ->where('alias', '=', $alias)
            ->first();
    }

    /**
     * @return mixed
     */
    public function getCurrentTheme()
    {
        if (!$this->themesCollection) {
            $this->getAllThemes();
        }
        return $this->themesCollection
            ->where('enabled', true)
            ->first();
    }

    /**
     * @param $alias
     * @param array $data
     * @return bool
     */
    public function saveTheme($alias, array $data)
    {
        $module = is_array($alias) ? $alias : get_theme_information($alias);
        if (!$module) {
            return false;
        }

        /**
         * @var ThemeRepository $themeRepo
         */
        $themeRepo = app(ThemeRepositoryContract::class);

        $result = $themeRepo
            ->createOrUpdate(array_get($module, 'id'), array_merge($data, [
                'alias' => array_get($module, 'alias'),
            ]));

        return $result;
    }

    /**
     * @return bool
     */
    protected function checkConnection()
    {
        if (app()->runningInConsole()) {
            if (!check_db_connection() || !Schema::hasTable(webed_db_prefix() . 'themes')) {
                return false;
            }
        }
        return true;
    }
}
