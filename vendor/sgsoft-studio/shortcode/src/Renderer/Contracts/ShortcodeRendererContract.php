<?php namespace WebEd\Base\Shortcode\Renderer\Contracts;

interface ShortcodeRendererContract
{
    /**
     * @var \WebEd\Base\Shortcode\Compilers\Shortcode $shortcode
     * @var string $content
     * @var \WebEd\Base\Shortcode\Compilers\ShortcodeCompiler $compiler
     * @var string $name
     */
    public function handle($shortcode, $content, $compiler, $name);
}
