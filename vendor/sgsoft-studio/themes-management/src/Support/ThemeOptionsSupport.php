<?php namespace WebEd\Base\ThemesManagement\Support;

use Illuminate\Support\Collection;
use WebEd\Base\Settings\Repositories\Contracts\SettingRepositoryContract;
use WebEd\Base\ThemesManagement\Repositories\Contracts\ThemeOptionRepositoryContract;
use WebEd\Base\ThemesManagement\Repositories\ThemeOptionRepository;

class ThemeOptionsSupport
{
    /**
     * @var array
     */
    protected $groups;

    /**
     * @var mixed
     */
    protected $currentTheme;

    /**
     * @var array|string
     */
    protected $options;

    /**
     * @var int
     */
    protected $optionsCount = 0;

    public function __construct()
    {
        $this->groups = [
            'basic' => [
                'title' => trans('webed-core::base.setting_group.basic'),
                'priority' => 1,
                'items' => [],
            ],
        ];

        $this->currentTheme = get_current_theme();

        if ($this->currentTheme) {
            $this->options = $this->getOption();
        }
    }

    /**
     * @return array
     */
    public function getOptionsFromDB()
    {
        if (!$this->currentTheme) {
            return null;
        }

        /**
         * @var ThemeOptionRepository $options
         */
        $options = app(ThemeOptionRepositoryContract::class);

        $this->options = $options->getOptionsByThemeId(array_get($this->currentTheme, 'id'));

        return $this->options;
    }

    /**
     * @param string $groupKey
     * @param string $groupTitle
     * @return $this
     */
    public function addGroup($groupKey, $groupTitle, $priority = 999)
    {
        if (!isset($this->groups[$groupKey])) {
            $this->groups[$groupKey] = [
                'title' => $groupTitle,
                'priority' => $priority,
                'items' => [],
            ];
        }

        return $this;
    }

    public function getGroup()
    {
        return $this->groups;
    }

    /**
     * @param $groupKey
     * @param array $options
     * @return $this
     */
    public function modifyGroup($groupKey, $options = [])
    {
        if (isset($options['items'])) {
            unset($options['items']);
        }
        $this->groups[$groupKey] = array_merge($this->groups[$groupKey], $options);

        return $this;
    }

    /**
     * @param $name
     * @param $options
     * @param \Closure $htmlHelpersParams
     * @return $this
     */
    public function addOptionField($name, $options, \Closure $htmlHelpersParams)
    {
        $options = array_merge([
            'group' => 'basic',
            'type' => null,
            'priority' => 999,
            'label' => null,
            'helper' => null,
        ], $options);

        if (array_get($this->groups, $options['group']) === null) {
            $options['group'] = 'basic';
        }

        $this->groups[$options['group']]['items'][] = [
            'name' => $name,
            'type' => $options['type'],
            'priority' => $options['priority'],
            'params' => $htmlHelpersParams,
            'label' => array_get($options, 'label'),
            'helper' => array_get($options, 'helper'),
        ];

        $this->optionsCount++;

        return $this;
    }

    /**
     * @return Collection
     */
    public function export()
    {
        $optionGroup = collect($this->groups)->sortBy('priority')->toArray();

        foreach ($optionGroup as $key => $group) {
            $optionGroup[$key]['items'] = collect($group['items'])->sortBy('priority')->toArray();
        }

        return collect($optionGroup);
    }

    /**
     * @param null $key
     * @param null $default
     * @return array|string
     */
    public function getOption($key = null, $default = null)
    {
        if ($this->options === null) {
            $this->options = $this->getOptionsFromDB();
        }

        if ($key === null) {
            return $this->options;
        }

        return array_get($this->options, $key, (string)$default);
    }

    /**
     * Retrieve current activated theme
     * @return mixed|null
     */
    public function getCurrentTheme()
    {
        return $this->currentTheme;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->optionsCount;
    }
}
