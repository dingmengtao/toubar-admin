<?php

use WebEd\Base\Hook\Facades\ActionsFacade;
use WebEd\Base\Hook\Facades\FiltersFacade;

if (!function_exists('add_action')) {
    /**
     * @param string $hook
     * @param \Closure|string|array|callable $callback
     * @param int $priority
     */
    function add_action($hook, $callback, $priority = 20)
    {
        ActionsFacade::addListener($hook, $callback, $priority);
    }
}

if (!function_exists('do_action')) {
    /**
     * Do actions
     * @param string $hookName
     * @param array ...$args
     */
    function do_action($hookName, ...$args)
    {
        ActionsFacade::fire($hookName, $args);
    }
}

if (!function_exists('add_filter')) {
    /**
     * @param string $hook
     * @param \Closure|string|array|callable $callback
     * @param int $priority
     */
    function add_filter($hook, $callback, $priority = 20)
    {
        FiltersFacade::addListener($hook, $callback, $priority);
    }
}

if (!function_exists('do_filter')) {
    /**
     * Do action then return value
     * @param string $hookName
     * @param array ...$args
     * @return mixed
     */
    function do_filter($hookName, ...$args)
    {
        return FiltersFacade::fire($hookName, $args);
    }
}

if (!function_exists('get_hooks')) {
    /**
     * @param null $name
     * @param bool $isFilter
     * @return array|null
     */
    function get_hooks($name = null, $isFilter = true)
    {
        if ($isFilter == true) {
            $listeners = FiltersFacade::getListeners();
        } else {
            $listeners = ActionsFacade::getListeners();
        }

        if (empty($name)) {
            return $listeners;
        }
        return array_get($listeners, $name);
    }
}
