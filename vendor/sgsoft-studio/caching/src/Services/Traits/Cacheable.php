<?php namespace WebEd\Base\Caching\Services\Traits;

/**
 * @property bool $cacheEnabled
 */
trait Cacheable
{
    /**
     * @return bool
     */
    public function isUseCache()
    {
        return !!$this->cacheEnabled;
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function withCache($bool = true)
    {
        $this->cacheEnabled = !!$bool;

        return $this;
    }
}
