<?php namespace WebEd\Plugins\Blog\Hook\CustomFields;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Models\EloquentBase;
use WebEd\Plugins\Blog\Models\Post;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;

class RenderCustomFields extends \WebEd\Base\CustomFields\Hook\RenderCustomFields
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    //protected $categoryRepository;

    public function __construct(PostRepositoryContract $postRepository)
    {
        parent::__construct();

        $this->postRepository = $postRepository;
    }

    /**
     * @param string $location
     * @param string $screenName
     * @param BaseModelContract|EloquentBase|Post $object
     */
    public function handle($location, $screenName, $object = null)
    {
        if ($location != 'main') {
            return;
        }

        switch ($screenName) {
            case WEBED_BLOG_CATEGORIES:
                add_custom_fields_rules_to_check([
                    WEBED_BLOG_CATEGORIES . '.category_template' => isset($object->page_template) ? $object->page_template : '',
                    WEBED_BLOG_CATEGORIES => isset($object->id) ? $object->id : null,
                    'model_name' => WEBED_BLOG_CATEGORIES,
                ]);
                break;
            case WEBED_BLOG_POSTS:
                add_custom_fields_rules_to_check([
                    WEBED_BLOG_POSTS . '.post_template' => isset($object->page_template) ? $object->page_template : '',
                    'model_name' => WEBED_BLOG_POSTS,
                ]);
                if ($object) {
                    $relatedCategoryIds = $this->postRepository->getRelatedCategoryIds($object);
                    $relatedCategoryTemplates = $this->postRepository->getRelatedCategories($object, [
                        'select' => ['page_template'],
                        'condition' => [
                            ['page_template', '<>', ''],
                        ],
                    ])->pluck('page_template')->toArray();
                    add_custom_fields_rules_to_check([
                        WEBED_BLOG_POSTS . '.post_with_related_category' => $relatedCategoryIds,
                        WEBED_BLOG_POSTS . '.post_with_related_category_template' => $relatedCategoryTemplates,
                    ]);
                }
                break;
            default:
                return;
        }

        $this->render($screenName, isset($object->id) ? $object->id : null);
    }
}