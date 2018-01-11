<?php namespace WebEd\Plugins\Share\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Share\Repositories\Contracts\ShareRepositoryContract;
use WebEd\Plugins\Share\Repositories\ShareRepository;

class UpdateShareAction extends AbstractAction
{
    /**
     * @var ShareRepository
     */
    protected $repository;

    public function __construct(ShareRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, array $data)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_SHARE, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->updateShare($item, $data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_SHARE, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
