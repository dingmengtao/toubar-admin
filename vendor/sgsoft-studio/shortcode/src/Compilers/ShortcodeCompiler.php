<?php namespace WebEd\Base\Shortcode\Compilers;

/**
 * @author Webwizo - <https://github.com/webwizo/laravel-shortcodes>
 * @modified Tedozi Manson
 */
class ShortcodeCompiler
{
    /**
     * Enable strip state
     *
     * @var boolean
     */
    protected $strip = false;

    /**
     * @var
     */
    protected $matches;

    /**
     * Registered laravel-shortcodes
     *
     * @var array
     */
    protected $registered = [];

    /**
     * Add a new shortcode
     *
     * @param string $name
     * @param callable|string $callback
     */
    public function add($name, $callback)
    {
        $this->registered[$name] = $callback;
    }

    /**
     * Compile the contents
     *
     * @param  string $value
     *
     * @return string
     */
    public function compile($value)
    {
        // Only continue is laravel-shortcodes have been registered
        if (!$this->hasShortcodes()) {
            return $value;
        }
        // Set empty result
        $result = '';
        // Here we will loop through all of the tokens returned by the Zend lexer and
        // parse each one into the corresponding valid PHP. We will then have this
        // template as the correctly rendered PHP that can be rendered natively.
        foreach (token_get_all($value) as $token) {
            $result .= is_array($token) ? $this->parseToken($token) : $token;
        }

        return $result;
    }

    /**
     * Check if laravel-shortcodes have been registered
     *
     * @return boolean
     */
    public function hasShortcodes()
    {
        return !empty($this->registered);
    }

    /**
     * Parse the tokens from the template.
     *
     * @param  array $token
     *
     * @return string
     */
    protected function parseToken($token)
    {
        list($id, $content) = $token;
        if ($id == T_INLINE_HTML) {
            $content = $this->renderShortcodes($content);
        }

        return $content;
    }

    /**
     * Render laravel-shortcodes
     *
     * @param  string $value
     *
     * @return string
     */
    protected function renderShortcodes($value)
    {
        $pattern = $this->getRegex();

        return preg_replace_callback("/{$pattern}/s", [$this, 'render'], $value);
    }

    /**
     * @param array $matches
     * @return mixed|void
     */
    public function render(array $matches)
    {
        // Compile the shortcode
        $compiled = $this->compileShortcode($matches);
        $name = $compiled->getName();

        if (!$this->getFunction($name)) {
            return null;
        }

        // Render the shortcode through the callback
        return call_user_func_array($this->getFunction($name), [
            $compiled,
            $compiled->getContent(),
            $this,
            $name
        ]);
    }

    protected function getFunction($name)
    {
        $callback = $this->registered[$name];

        if (is_string($callback)) {
            if (strpos($callback, '@')) {
                $callback = explode('@', $callback);
                return [app('\\' . $callback[0]), $callback[1]];
            } else {
                return $callback;
            }
        } elseif ($callback instanceof \Closure) {
            return $callback;
        } elseif (is_array($callback) && sizeof($callback) > 1) {
            return [app('\\' . $callback[0]), $callback[1]];
        }
        return null;
    }

    /**
     * Get Compiled Attributes.
     *
     * @param $matches
     *
     * @return Shortcode
     */
    protected function compileShortcode($matches)
    {
        // Set matches
        $this->setMatches($matches);

        // pars the attributes
        $attributes = $this->parseAttributes($this->matches[3]);

        // return shortcode instance
        return new Shortcode(
            $this->getName(),
            $attributes,
            $this->getContent()
        );
    }

    /**
     * Set the matches
     *
     * @param array $matches
     */
    protected function setMatches($matches = [])
    {
        $this->matches = $matches;
    }

    /**
     * Return the shortcode name
     *
     * @return string
     */
    public function getName()
    {
        return $this->matches[2];
    }

    /**
     * Return the shortcode content
     *
     * @return string
     */
    public function getContent()
    {
        // Compile the content, to support nested laravel-shortcodes
        return $this->compile($this->matches[5]);
    }

    /**
     * Parse the shortcode attributes
     *
     * @author Wordpress
     * @return array
     */
    protected function parseAttributes($text)
    {
        $attributes = [];
        // attributes pattern
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        // Match
        if (preg_match_all($pattern, preg_replace('/[\x{00a0}\x{200b}]+/u', " ", $text), $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1])) {
                    $attributes[strtolower($m[1])] = str_replace("&quot;", "", stripcslashes($m[2]));
                } elseif (!empty($m[3])) {
                    $attributes[strtolower($m[3])] = str_replace("&quot;", "", stripcslashes($m[4]));
                } elseif (!empty($m[5])) {
                    $attributes[strtolower($m[5])] = str_replace("&quot;", "", stripcslashes($m[6]));
                } elseif (isset($m[7]) && strlen($m[7])) {
                    $attributes[] = str_replace("&quot;", "", stripcslashes($m[7]));
                } elseif (isset($m[8])) {
                    $attributes[] = str_replace("&quot;", "", stripcslashes($m[8]));
                }
            }
        } else {
            $attributes = ltrim($text);
        }

        // return attributes
        return is_array($attributes) ? $attributes : [$attributes];
    }

    /**
     * Get shortcode names
     *
     * @return string
     */
    protected function getShortcodeNames()
    {
        return join('|', array_map('preg_quote', array_keys($this->registered)));
    }

    /**
     * Get shortcode regex.
     *
     * @author Wordpress
     * @return string
     */
    protected function getRegex()
    {
        $shortcodeNames = $this->getShortcodeNames();

        return "\\[(\\[?)($shortcodeNames)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)";
    }

    /**
     * Remove all shortcode tags from the given content.
     *
     * @param string $content Content to remove shortcode tags.
     *
     * @return string Content without shortcode tags.
     */
    public function strip($content)
    {
        if (empty($this->registered)) {
            return $content;
        }
        $pattern = $this->getRegex();

        return preg_replace_callback("/{$pattern}/s", [$this, 'stripTag'], $content);
    }

    /**
     * @return boolean
     */
    public function getStrip()
    {
        return $this->strip;
    }

    /**
     * @param $strip
     * @return $this
     */
    public function setStrip($strip)
    {
        $this->strip = !!$strip;

        return $this;
    }

    /**
     * Remove shortcode tag
     *
     * @param $m
     *
     * @return string Content without shortcode tag.
     */
    protected function stripTag($m)
    {
        if ($m[1] == '[' && $m[6] == ']') {
            return substr($m[0], 1, -1);
        }

        return $m[1] . $m[6];
    }

    /**
     * @return array
     */
    public function getRegistered()
    {
        return $this->registered;
    }
}
