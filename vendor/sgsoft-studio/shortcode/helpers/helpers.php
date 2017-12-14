<?php

if (!function_exists('cms_shortcode')) {
    /**
     * @return \WebEd\Base\Shortcode\Support\Shortcode
     */
    function cms_shortcode()
    {
        return \Shortcode::getFacadeRoot();
    }
}

if (!function_exists('add_shortcode')) {
    /**
     * @param $name
     * @param callable|string $callback
     * @return \WebEd\Base\Shortcode\Support\Shortcode
     */
    function add_shortcode($name, $callback)
    {
        return cms_shortcode()->register($name, $callback);
    }
}

if (!function_exists('do_shortcode')) {
    /**
     * @param $content
     * @return string
     */
    function do_shortcode($content)
    {
        return cms_shortcode()->compile($content);
    }
}

if (!function_exists('generate_shortcode')) {
    /**
     * @param $name
     * @param array $attributes
     * @return string
     */
    function generate_shortcode($name, array $attributes)
    {
        $parsedAttributes = '';
        foreach ($attributes as $key => $attribute) {
            $parsedAttributes .= ' ' . $key . '="' . str_slug($attribute) . '"';
        }
        return '[' . $name . $parsedAttributes . ']';
    }
}
