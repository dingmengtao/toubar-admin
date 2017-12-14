<?php namespace WebEd\Base\Pages\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class DeletePageAction extends AbstractAction
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
     * @param int $id
     * @param bool $force
     * @return array
     */
    public function run($id, $force)
    {
        if ($force) {
            $id = do_filter(BASE_FILTER_BEFORE_FORCE_DELETE, $id, WEBED_PAGES);
        } else {
            $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_PAGES);
        }

        $result = $this->pageRepository->deletePage($id, $force);

        if ($force) {
            do_action(BASE_ACTION_AFTER_FORCE_DELETE, WEBED_PAGES, $id, $result);
        } else {
            do_action(BASE_ACTION_AFTER_DELETE, WEBED_PAGES, $id, $result);
        }

        $msg = $result ? trans('webed-core::base.form.request_completed') : trans('webed-core::base.form.error_occurred');

        if (!$result) {
            return $this->error($msg);
        }

        return $this->success($msg);
    }
}
