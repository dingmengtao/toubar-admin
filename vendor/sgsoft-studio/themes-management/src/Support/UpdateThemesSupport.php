<?php namespace WebEd\Base\ThemesManagement\Support;

class UpdateThemesSupport
{
    /**
     * @var array
     */
    protected $batches = [];

    /**
     * @param array $batches
     * @return $this
     */
    public function registerUpdateBatches(array $batches)
    {
        $this->batches = $batches;
        return $this;
    }

    /**
     * @return $this
     */
    public function loadBatches()
    {
        $currentThemeInformation = get_current_theme();

        if (!$currentThemeInformation) {
            return $this;
        }

        $installedThemeVersion = array_get($currentThemeInformation, 'installed_version');

        foreach ($this->batches as $version => $batch) {
            if (!$installedThemeVersion || version_compare($version, $installedThemeVersion, '>')) {
                require $batch;
            }
        }

        return $this;
    }
}
