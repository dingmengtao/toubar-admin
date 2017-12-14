<?php namespace WebEd\Base\Caching\Services;

use WebEd\Base\Caching\Services\Contracts\CacheServiceContract;
use Illuminate\Support\Facades\Cache;
use \WebEd\Base\Caching\Services\Contracts\CacheableContract;

class CacheService implements CacheServiceContract
{
    /**
     * Cache life time
     * @var int
     */
    protected $cacheLifetime;

    /**
     * Set cache driver
     * @var string
     */
    protected $cacheDriver;

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * @var CacheableContract
     */
    protected $class;

    /**
     * @var string
     */
    protected $cacheGroup;

    /**
     * @var string
     */
    protected $cacheFile;

    public function __construct()
    {
        $this->cacheFile = storage_path('framework/cache/cache-service.json');
    }

    /**
     * Dynamically pass missing methods to the model.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->class, $method)) {
            if ($this->class->isUseCache()) {
                $this->setCacheKey($method, $parameters);
            }
            return $this->retrieveFromCache(function () use ($method, $parameters) {
                return call_user_func_array([$this->class, $method], $parameters);
            });
        }
    }

    /**
     * @param string $whereToSave
     * @return \WebEd\Base\Caching\Services\CacheService
     */
    public function setCacheFile($whereToSave)
    {
        $this->cacheFile = $whereToSave;

        return $this;
    }

    /**
     * @return string
     */
    public function getCacheFile()
    {
        return $this->cacheFile;
    }

    /**
     * @param CacheableContract
     * @return \WebEd\Base\Caching\Services\CacheService
     */
    public function setCacheObject(CacheableContract $item)
    {
        $this->class = $item;

        return $this;
    }

    /**
     * @param string $groupName
     * @return $this
     */
    public function setCacheGroup($groupName)
    {
        $this->cacheGroup = $groupName;

        return $this;
    }

    /**
     * @param $args
     * @return string
     */
    protected function generateCacheHash($args)
    {
        return md5(serialize($args));
    }

    /**
     * @param int $cacheLifetime
     * @return \WebEd\Base\Caching\Services\CacheService
     */
    public function setCacheLifetime($cacheLifetime)
    {
        $this->cacheLifetime = $cacheLifetime;
        return $this;
    }

    /**
     * @return int
     */
    public function getCacheLifetime()
    {
        return (int)$this->cacheLifetime ?: 0;
    }

    /**
     * @param string $cacheDriver
     * @return \WebEd\Base\Caching\Services\CacheService
     */
    public function setCacheDriver($cacheDriver)
    {
        $this->cacheDriver = $cacheDriver;
        return $this;
    }

    /**
     * @return string
     */
    public function getCacheDriver()
    {
        return $this->cacheDriver ?: config('cache.default');
    }

    /**
     * @param string $className
     * @param string $method
     * @param array $args
     * @return \WebEd\Base\Caching\Services\CacheService
     */
    public function setCacheKey($method, $args)
    {
        if (!$this->class->isUseCache()) {
            $this->resetCacheKey();
            return $this;
        }
        $this->cacheKey = get_class($this->class) . '@' . $method . '.' . $this->generateCacheHash($args);
        return $this;
    }

    /**
     * @return string
     */
    public function getCacheKey()
    {
        return $this->cacheKey;
    }

    /**
     * @return \WebEd\Base\Caching\Services\CacheService
     */
    public function resetCacheKey()
    {
        $this->cacheKey = null;
        return $this;
    }

    /**
     * @return array
     */
    public function getCacheKeys()
    {
        $file = $this->getCacheFile();

        if (!file_exists($file)) {
            file_put_contents($file, null);
        }

        return json_decode(file_get_contents($file), true) ?: [];
    }

    /**
     * Store cache key to file
     * @return \WebEd\Base\Caching\Services\CacheService
     */
    public function storeCacheKey()
    {
        $file = $this->getCacheFile();
        if (!file_exists($file)) {
            file_put_contents($file, null);
        }

        $className = $this->cacheGroup ?: get_class($this->class);
        $currentCacheKey = $this->getCacheKey();
        $cacheKeys = $this->getCacheKeys();

        if (!isset($cacheKeys[$className]) || !in_array($currentCacheKey, $cacheKeys[$className])) {
            if ($currentCacheKey) {
                $cacheKeys[$className][] = $currentCacheKey;
                file_put_contents($file, json_encode_prettify($cacheKeys));
            }
        }

        return $this;
    }

    /**
     * Try to retrieve data from cache
     * @param \Closure $closure
     * @return mixed
     */
    public function retrieveFromCache(\Closure $closure)
    {
        if ($this->class->isUseCache() && $this->getCacheLifetime() !== 0) {
            $lifetime = $this->getCacheLifetime();
            $cacheKey = $this->getCacheKey();
            $cacheDriver = $this->getCacheDriver();

            $result = ($lifetime < 0)
                ? Cache::store($cacheDriver)->rememberForever($cacheKey, $closure)
                : Cache::store($cacheDriver)->remember($cacheKey, $lifetime, $closure);

            $this->storeCacheKey();

            return $result;
        }
        return call_user_func($closure);
    }

    /**
     * Reset all cache data
     * @return \WebEd\Base\Caching\Services\CacheService
     */
    public function resetCache()
    {
        $this->cacheLifetime = null;
        $this->cacheDriver = null;
        $this->cacheKey = null;

        return $this;
    }

    /**
     * Flush cache of current class
     * @return array
     */
    public function flushCache()
    {
        $file = $this->getCacheFile();

        $flushedKeys = [];
        $calledClass = $this->cacheGroup ?: get_class($this->class);
        $cacheKeys = $this->getCacheKeys();

        if (isset($cacheKeys[$calledClass]) && is_array($cacheKeys[$calledClass])) {
            foreach ($cacheKeys[$calledClass] as $row) {
                Cache::forget($row);
                $flushedKeys[] = $row;
            }

            unset($cacheKeys[$calledClass]);
            file_put_contents($file, json_encode($cacheKeys));
        }

        return $flushedKeys;
    }
}
