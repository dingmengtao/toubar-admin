<?php namespace WebEd\Plugins\Blog\Models\Contracts;

interface PostModelContract
{
    /**
     * @return mixed
     */
    public function categories();

    /**
     * @return mixed
     */
    public function tags();
}
