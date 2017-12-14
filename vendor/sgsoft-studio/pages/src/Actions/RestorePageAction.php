<?php namespace WebEd\Base\Pages\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class RestorePageAction extends AbstractAction
{
    /**
     * @var PageRepository
     */
    protected $pageRepository;

    public function __construct(PageRepositoryContract $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param $id
     * @return array
     */
    public function run($id)
    {
        $id = do_filter(BASE_FILTER_BEFORE_RESTORE, $id, WEBED_PAGES);

        $result = $this->pageRepository->restore($id);

        do_action(BASE_ACTION_AFTER_RESTORE, WEBED_PAGES, $id, $result);

        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');

        if (!$result) {
            return $this->error($msg);
        }

        return $this->success($msg);
    }
}
