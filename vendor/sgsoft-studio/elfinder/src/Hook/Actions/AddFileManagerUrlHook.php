<?php namespace WebEd\Base\Elfinder\Hook\Actions;

class AddFileManagerUrlHook
{
    public function __construct()
    {

    }

    public function execute()
    {
        echo view('webed-elfinder::admin.hook.top-script')->render();
    }
}
