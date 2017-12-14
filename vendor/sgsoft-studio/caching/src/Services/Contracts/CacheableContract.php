<?php namespace WebEd\Base\Caching\Services\Contracts;

interface CacheableContract
{
    /**
     * Determine when enabled cache for query
     * @var bool
     */
    public function isUseCache();

    /**
     * @param bool $bool
     * @return $this
     */
    public function withCache($bool = true);
}
