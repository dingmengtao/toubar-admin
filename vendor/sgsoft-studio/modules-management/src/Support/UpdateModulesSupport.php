<?php namespace WebEd\Base\ModulesManagement\Support;

class UpdateModulesSupport
{
    /**
     * @var array
     */
    protected $batches = [
        'core' => [

        ],
        'plugins' => [

        ],
    ];

    /**
     * @param $moduleAlias
     * @param array $batches
     * @param string $type
     * @return $this
     */
    public function registerUpdateBatches($moduleAlias, array $batches, $type = 'plugins')
    {
        $this->batches[$type][$moduleAlias] = $batches;

        return $this;
    }

    /**
     * @param $moduleAlias
     * @param string $type
     * @return $this
     */
    public function loadBatches($moduleAlias, $type = 'plugins')
    {
        if ($type == 'plugins') {
            $currentModuleInformation = get_plugin($moduleAlias);
        } else {
            $currentModuleInformation = get_core_module($moduleAlias);
        }

        if (!$currentModuleInformation) {
            return $this;
        }

        $installedModuleVersion = array_get($currentModuleInformation, 'installed_version');
        foreach ($this->batches[$type][$moduleAlias] as $version => $batch) {
            if (!$installedModuleVersion || version_compare($version, $installedModuleVersion, '>')) {
                require $batch;
            }
        }
        return $this;
    }
}
