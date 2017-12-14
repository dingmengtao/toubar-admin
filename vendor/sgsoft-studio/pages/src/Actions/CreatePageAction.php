<?php namespace WebEd\Base\Pages\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class CreatePageAction extends AbstractAction
{
    /**
     * @var PageRepository
     */
    protected $pageRepository;

    public function __construct(PageRepositoryContract $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_PAGES, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->pageRepository->createPage($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_PAGES, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
