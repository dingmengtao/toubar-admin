<?php
/**
 * Created by PhpStorm.
 * User: Zhupe
 * Date: 2018/1/10
 * Time: 15:39
 */

namespace WebEd\Plugins\Blog\Actions\Navigation;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\Contracts\NavigationRepositoryContract;
use WebEd\Plugins\Blog\Repositories\NavigationRepository;
class CreateNavigationAction extends AbstractAction
{
    /**
     * @var NavigationRepository
     */
    protected $repository;

    public function __construct(NavigationRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function run(array $data)
    {

        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_NAVIGATION, 'create.post');

        $data['created_by'] = get_current_logged_user_id();


        $result = $this->repository->createNavigation($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_BLOG_NAVIGATION, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}