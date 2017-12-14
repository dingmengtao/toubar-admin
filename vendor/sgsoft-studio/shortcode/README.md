#WebEd shortcode
![Total downloads](https://poser.pugx.org/sgsoft-studio/shortcode/d/total.svg)
![Latest Stable Version](https://poser.pugx.org/sgsoft-studio/shortcode/v/stable.svg)
![License](https://poser.pugx.org/sgsoft-studio/shortcode/license.svg)

####Documentation
Shortcode already enabled by WebEd. You cannot turn off it.

[https://github.com/webwizo/laravel-shortcodes](https://github.com/webwizo/laravel-shortcodes)

####Quick use
To register shortcode, just put this in your module service provider:
```
add_shortcode('revslider', function ($shortcode, $content, $compiler, $name) {
    /**
     * @var \WebEd\Base\Shortcode\Compilers\Shortcode $shortcode
     * @var string $content
     * @var \WebEd\Base\Shortcode\Compilers\ShortcodeCompiler $compiler
     * @var string $name
     */
     // put your magic here...
});
```
Compile your shortcode
```
do_shortcode('some string with shortcode [revslider id=17 class="revolution-slider"]', $stripContent = false);
```