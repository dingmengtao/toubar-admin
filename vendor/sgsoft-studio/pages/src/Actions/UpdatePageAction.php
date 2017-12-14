<?php namespace WebEd\Base\Pages\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class UpdatePageAction extends AbstractAction
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
     * @param array $data
     * @return array
     */
    public function run($id, array $data)
    {
        $item = $this->pageRepository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_PAGES, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-pages::base.form.page_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->pageRepository->updatePage($item, $data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_PAGES, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
